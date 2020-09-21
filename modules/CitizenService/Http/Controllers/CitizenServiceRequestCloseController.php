<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Repositories\UploadImageRepository;
use App\Repositories\UploadDocRepository;
use Modules\CitizenService\Models\CitizenServiceRequest;

class CitizenServiceRequestCloseController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('citizenservice::requests.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request, UploadImageRepository $upImage, UploadDocRepository $upDoc)
    {
        $citizenServiceRequest = CitizenServiceRequest::find($request->request_id);
        $this->validate($request, [
            'file' => ['required', 'max:5000', 'mimes:jpeg,jpg,png,pdf,docx,doc,odt,mp4,avi'],
        ]);
        /** Cambiar a uso dinámico de las extensiones  */
        $documentFormat = ['doc', 'docx', 'pdf', 'odt'];
        $imageFormat = ['jpeg', 'jpg', 'png'];
        $videoFormat = ['mp4', 'avi'];
        $extensionFile = $request->file('file')->getClientOriginalExtension();
        if (in_array($extensionFile, $documentFormat)) {
            if ($citizenServiceRequest->file_counter <= 2) {
                if ($upDoc->uploadDoc($request->file('file'), 'documents', CitizenServiceRequest::class, $request->request_id, null, false, false, true)) {
                    error_log(CitizenServiceRequest::class);
                    error_log($request->request_id);

                    $file_id = $upDoc->getDocStored()->id;
                    //$document = Document::find($file_id);
                    //$document->documentable_type = 'Modules\CitizenService\Models\CitizenServiceRequestClose';
                    //$document->documentable_id = 'Modules\CitizenService\Models\CitizenServiceRequestClose';
                    $file_url = $upDoc->getDocStored()->url;
                    $file_name = $upDoc->getDocName();
                    error_log('Hola');
                    error_log($file_url.' '.$file_id);
                    error_log($file_name);
                    $citizenServiceRequest->file_counter = $citizenServiceRequest->file_counter + 1;
                    $citizenServiceRequest->save();
                    error_log('file_counter: '.$citizenServiceRequest->file_counter);
                    return response()->json(['result' => true, 'file_id' => $file_id,
                   'file_url' => $file_url,
                   'file_name' => $file_name], 200);
                } elseif (in_array($extensionFile, $imageFormat)) {
                    if ($upImage->uploadImage($request->file('file'), 'pictures')) {
                        $file_id = $upImage->getImageStored()->id;
                        $file_url = $upImage->getImageStored()->url;
                        $file_name = $upImage->getImageName();

                        return response()->json(['result' => true, 'file_id' => $file_id,
                     'file_url' => $file_url,
                     'file_name' => $file_name], 200);
                    }
                } elseif (in_array($extensionFile, $videoFormat)) {
                    dd('Is video');
                }
            }
        }
    }




    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        $image = Image::find($id);

        if (is_null($image)) {
            return response()->json([
                'result' => false, 'message' => __('La imagen no existe o ya fue eliminada')
            ], 200);
        }

        $file = $image->file;

        DB::transaction(function () use ($image, $file, $request) {
            if ($request->force_delete) {
                $image->forceDelete();
                if (Storage::disk((isset($request->store)) ? $request->store : 'pictures')->exists($file)) {
                    Storage::disk((isset($request->store)) ? $request->store : 'pictures')->delete($file);
                }
            } else {
                $image->delete();
            }
        });
        return response()->json(['result' => true, 'message' => 'Success'], 200);
    }

    public function vueClose($id)
    {
        $citizenServiceRequest = CitizenServiceRequest::where('id', $id)
            ->with('documents')->first();
        return response()->json(['records' => $citizenServiceRequest->documents], 200);
    }
}
