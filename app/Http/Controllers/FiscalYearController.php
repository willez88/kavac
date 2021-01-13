<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\FiscalYear;
use Illuminate\Http\Request;

/**
 * @class FiscalYearController
 * @brief Gestiona información del año fiscal
 *
 * Controlador para gestionar información de los años fiscales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class FiscalYearController extends Controller
{
    /**
     * Listado de años fiscales registrados
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
     * Muestra el formulario para el registro de un nuevo año fiscal
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
     * Registra un nuevo año fiscal
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
     * Muestra información de un año fiscal
     *
     * @method    show
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     FiscalYear    $fiscalYear    Objeto con información de la petición
     */
    public function show(FiscalYear $fiscalYear)
    {
        //
    }

    /**
     * Muestra el formulario con información del año fiscal a actualizar
     *
     * @method    edit
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     FiscalYear    $fiscalYear    Objeto con información del año fiscal a actualizar
     */
    public function edit(FiscalYear $fiscalYear)
    {
        //
    }

    /**
     * Actualiza los datos de un año fiscal
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request       $request       Objeto con información de la petición
     * @param     FiscalYear    $fiscalYear    Objeto con información del año fiscal a actualizar
     */
    public function update(Request $request, FiscalYear $fiscalYear)
    {
        //
    }

    /**
     * Elimina un año fiscal
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     FiscalYear    $fiscalYear    Objeto con información del año fiscal a eliminar
     */
    public function destroy(FiscalYear $fiscalYear)
    {
        //
    }
}
