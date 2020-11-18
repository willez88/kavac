<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Document;
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

        $documentFormat = ['doc', 'docx', 'pdf', 'odt'];
        $imageFormat    = ['jpeg', 'jpg', 'png'];
        $videoFormat    = ['mp4', 'avi'];
        $extensionFile  = $request->file('file')->getClientOriginalExtension();
        if (in_array($extensionFile, $documentFormat)) {
            //if ($citizenServiceRequest->file_counter <= 2) {
            if ($upDoc->uploadDoc($request->file('file'),
                'documents',
                CitizenServiceRequest::class,
                $request->request_id,
                null,
                false,
                false,
                true
            )) {
                     $file_id = $upDoc->getDocStored()->id;
                     $file_url = $upDoc->getDocStored()->url;
                     $file_name = $upDoc->getDocName();

                //$citizenServiceRequest->file_counter = $citizenServiceRequest->file_counter + 1;
                     $citizenServiceRequest->save();

                return response()->json([
                    'result' => true,
                    'file_id' => $file_id,
                    'file_url' => $file_url,
                    'file_name' => $file_name
                ], 200);
            }
        } elseif (in_array($extensionFile, $imageFormat)) {
            if ($upImage->uploadImage($request->file('file'),
                'pictures',
                CitizenServiceRequest::class,
                $request->request_id,
                null,
                false,
                false,
                true
            )) {
                     $file_id = $upImage->getImageStored()->id;
                     $file_url = $upImage->getImageStored()->url;
                     $file_name = $upImage->getImageName();

                return response()->json([
                        'result' => true,
                        'file_id' => $file_id,
                        'file_url' => $file_url,
                        'file_name' => $file_name
                ], 200);
            }
        } //elseif (in_array($extensionFile, $videoFormat)) {
                //dd('Is video');
            //}
        //}
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
    public function update(Request $request, $id)
    {
        $citizenServiceRequest = CitizenServiceRequest::find($id);
        $citizenServiceRequest->state = 'Culminado';


        $citizenServiceRequest->save();
        
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('citizenservice.request.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy(Request $request, $id)
    {
            $image = Image::find($id);
            $doc = Document::find($id);
        if ((is_null($image)) && (!is_null($doc))) {
            return response()->json([
                'result' => false, 'message' => __('El archivo no existe o ya fue eliminado')
            ], 200);
        } elseif ((is_null($doc)) && (!is_null($image))) {
            return response()->json([
               'result' => false, 'message' => __('El archivo no existe o ya fue eliminado')
            ], 200);
        }
        $file = $image->file;
        if (!is_null($file)) {
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
        $file = $doc->file;
        if (!is_null($file)) {
            DB::transaction(function () use ($doc, $file, $request) {
                if ($request->force_delete) {
                    $doc->forceDelete();
                    if (Storage::disk((isset($request->store)) ? $request->store : 'documents')->exists($file)) {
                        Storage::disk((isset($request->store)) ? $request->store : 'documents')->delete($file);
                    }
                } else {
                    $doc->delete();
                }
            });

            return response()->json(['result' => true, 'message' => 'Success'], 200);
        }
    }

    public function getCitizenServiceRequestDocuments($id)
    {
        $citizenServiceRequest = CitizenServiceRequest::where('id', $id)
            ->with('documents')->first();
        return response()->json(['records' => $citizenServiceRequest->documents], 200);
    }
}
