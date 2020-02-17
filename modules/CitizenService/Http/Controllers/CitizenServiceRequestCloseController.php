<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Repositories\UploadImageRepository;
use App\Repositories\UploadDocRepository;

class CitizenServiceRequestCloseController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, UploadImageRepository $upImage, UploadDocRepository $upDoc)
    {
        $this->validate($request, [
            'file' => ['required', 'max:5000', 'mimes:jpeg,jpg,png,pdf,docx,doc,odt,mp4,avi'],
        ]);
        /** Cambiar a uso dinámico de las extensiones  */

        $documentFormat = ['doc', 'docx', 'pdf', 'odt'];
        $imageFormat = ['jpeg', 'jpg', 'png'];
        $videoFormat = ['mp4', 'avi'];
        $extensionFile = $request->file('file')->getClientOriginalExtension();

        if (in_array($extensionFile, $documentFormat)) {
            if ($upDoc->uploadDoc($request->file('file'), 'documents')) {
                $doc_id = $upDoc->getDocStored()->id;
                $doc_url = $upDoc->getDocStored()->url;
                return response()->json(['result' => true, 'doc_name' => $doc_name], 200);
            }
        } elseif (in_array($extensionFile, $imageFormat)) {
            if ($upImage->uploadImage($request->file('file'), 'pictures')) {
                $image_id = $upImage->getImageStored()->id;
                $image_url = $upImage->getImageStored()->url;
                return response()->json(['result' => true, 'image_id' => $image_id, 'image_url' => $image_url], 200);
            }
        } elseif (in_array($extensionFile, $videoFormat)) {
            dd('Is video');
        }
        dd('Error');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
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
    }
}
