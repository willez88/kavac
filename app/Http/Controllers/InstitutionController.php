<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\DocumentStatus;
use App\Models\FiscalYear;
use Carbon\Carbon;

/**
 * @class InstitutionController
 * @brief Gestiona información de Instituciones
 *
 * Controlador para gestionar Instituciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class InstitutionController extends Controller
{
    /**
     * Obtiene las instituciones registradas
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id                      Identificador de la institución a buscar, este parámetro es opcional
     * @return \Illuminate\Http\JsonResponse    JSON con los datos de las instituciones
     */
    public function getInstitutions($id = null)
    {
        return response()->json(template_choices('App\Models\Institution', 'name', [], true));
    }

    /**
     * Obtiene el año actual para la ejecución de recursos
     *
     * @param  integer $institution_id          Identificador de la institución, si no se especifica toma
     *                                          el valor por defecto
     * @param  string  $year                    Año de la ejecución, si no se especifica toma el año actual
     *                                          del sistema
     * @return \Illuminate\Http\JsonResponse    JSON con información del año de execución
     */
    public function getExecutionYear($institution_id = null, $year = null)
    {
        $year = $year ?? Carbon::now()->format("Y");
        $execution = '';
        $filter = ['active' => true];
        $filter[(is_null($institution_id)) ? 'default' : 'id'] = (is_null($institution_id)) ? true : $institution_id;

        $institution = Institution::where($filter)->first();

        $documentStatus = DocumentStatus::where('action', 'AP')->first();

        $fiscalYear = FiscalYear::firstOrCreate(
            ['year' => $year, 'active' => true]
        );

        $exec_year = $fiscalYear->year;

        return response()->json(['result' => true, 'year' => $exec_year], 200);
    }
}
