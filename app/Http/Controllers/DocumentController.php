<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Document;
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
     *
     * @param     Request    $request    Objeto con información de la petición
     */
    public function store(Request $request)
    {
        //
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
