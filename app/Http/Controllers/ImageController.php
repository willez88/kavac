<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Repositories\UploadImageRepository;
use Illuminate\Http\Request;

/**
 * @class ImageController
 * @brief Gestiona información de Imágenes
 * 
 * Controlador para gestionar Imágenes
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, UploadImageRepository $up)
    {
        if ($request->file('image')) {
            
            if ($up->uploadImage($request->file('image'), 'pictures')) {
                $image_id = $up->getImageStored()->id;
                return response()->json(['result' => true, 'image_id' => $image_id], 200);
            }
        }
        return response()->json(['result' => false, 'message' => 'No se pudo subir la imagen'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function edit(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }

    public function getImage(Request $request, Image $image)
    {
        return response()->json(['result' => true, 'image' => $image], 200);
    }
}
