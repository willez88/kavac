<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Document;
use App\Repositories\UploadDocRepository;
use Illuminate\Http\Request;

/**
 * @class DocumentController
 * @brief Gestiona información de Documentos
 *
 * Controlador para gestionar Documentos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class DocumentController extends Controller
{
    /**
     * Listado de todos los documentos registrados
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function index()
    {
        //
    }

    /**
     * Muestra el formulario para la creación de documentos
     *
     * @method    create
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function create()
    {
        //
    }

    /**
     * Registra información de un nuevo documento
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @author     William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     * @param     UploadDocRepository    $up         Objeto con las propiedades necesarias para registrar y subir
     *
     * @return    JsonResponse      JSON con información del resultado en el registro del documento
     */
    public function store(Request $request, UploadDocRepository $up)
    {
        $document_ids = [];
        if ($request->documents) {
            foreach ($request->file('documents') as $document) {
                if ($up->uploadDoc($document, 'documents')) {
                    $document_ids[] = array('id' => $up->getDocStored()->id);
                }
            }
            return response()->json(['result' => true, 'document_ids' => $document_ids], 200);
        }
        return response()->json(['result' => false, 'message' => __('No se pudo subir el documento')], 200);
    }

    /**
     * Muestra información de un documento
     *
     * @method    show
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Document    $document    Objeto con información del documento a mostrar
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Muestra el formulacio con información del documento a actualizar
     *
     * @method    edit
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Document    $document    Objeto con información del documento a actualizar
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Actualiza la información de un documento
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request     $request     Objeto con información de la petición
     * @param     Document    $document    Objeto con información del documento a actualizar
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Elimina un documento
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Document    $document    Objeto con información del documento a eliminar
     */
    public function destroy(Document $document)
    {
        //
    }
}
