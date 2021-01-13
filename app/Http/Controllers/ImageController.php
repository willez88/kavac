<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Image;
use App\Repositories\UploadImageRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;

/**
 * @class ImageController
 * @brief Gestiona información de Imágenes
 *
 * Controlador para gestionar Imágenes
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ImageController extends Controller
{
    /**
     * Registra una nueva imagen
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request                  $request    Objeto con información de la petición
     * @param     UploadImageRepository    $up         Objeto con las propiedades necesarias para registrar y subir
     *                                                 la imagen al servidor
     *
     * @return    JsonResponse      JSON con información del resultado en el registro de la imagen
     */
    public function store(Request $request, UploadImageRepository $up)
    {
        if ($request->file('image')) {
            if ($up->uploadImage($request->file('image'), 'pictures')) {
                /** @var integer Identificador de la imagen registrada */
                $image_id = $up->getImageStored()->id;
                /** @var string URL de la imagen */
                $image_url = $up->getImageStored()->url;
                return response()->json(['result' => true, 'image_id' => $image_id, 'image_url' => $image_url], 200);
            }
        }
        return response()->json(['result' => false, 'message' => __('No se pudo subir la imagen')], 200);
    }

    /**
     * Elimina una imagen
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     * @param     integer    $id         Identificador de la imagen a eliminar
     *
     * @return    JsonResponse     JSON con información del resultado en la eliminación de la imagen
     */
    public function destroy(Request $request, $id)
    {
        /** @var Image Objeto con información de la imagen a eliminar */
        $image = Image::find($id);

        if (is_null($image)) {
            return response()->json([
                'result' => false, 'message' => __('La imagen no existe o ya fue eliminada')
            ], 200);
        }

        /** @var string Ruta del archivo a eliminar */
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

    /**
     * Obtiene detalles de una imagen
     *
     * @method  getImage
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request $request Datos de la petición
     * @param  Image   $image   Objeto con los datos de la imagen
     *
     * @return JsonResponse             JSON con los detalles de la imagen consultada
     */
    public function getImage(Request $request, Image $image)
    {
        return response()->json(['result' => true, 'image' => $image], 200);
    }
}
