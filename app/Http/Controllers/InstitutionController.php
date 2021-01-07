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
     * @method  getInstitutions
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  integer $id                      Identificador de la institución a buscar, este parámetro es opcional
     *
     * @return JsonResponse    JSON con los datos de las instituciones
     */
    public function getInstitutions($id = null)
    {
        return response()->json(template_choices('App\Models\Institution', 'name', [], true));
    }

    /**
     * Obtiene el año actual para la ejecución de recursos
     *
     * @method  getExecutionYear
     *
     * @param  integer $institution_id          Identificador de la institución, si no se especifica toma
     *                                          el valor por defecto
     * @param  string  $year                    Año de la ejecución, si no se especifica toma el año actual
     *                                          del sistema
     * @return JsonResponse    JSON con información del año de execución
     */
    public function getExecutionYear($institution_id = null, $year = null)
    {
        /** @var string Texto que identifica el año fiscal actual */
        $year = $year ?? Carbon::now()->format("Y");
        /** @var array Establece los filtros a aplicar para la consulta del año fiscal en curso */
        $filter = ['active' => true];
        $filter[(is_null($institution_id)) ? 'default' : 'id'] = (is_null($institution_id)) ? true : $institution_id;
        /** @var Institution Objeto con datos de los organismos a consultar */
        $institution = Institution::where($filter)->first();
        /** @var DocumentStatus Objeto con información del estatus de documento que permite la aprobación de documentos */
        $documentStatus = DocumentStatus::where('action', 'AP')->first();
        /** @var FiscalYear Objeto con información del año fiscal en curso */
        $fiscalYear = FiscalYear::firstOrCreate(
            ['year' => $year, 'active' => true]
        );

        /** @var string Año fiscal actual */
        $exec_year = $fiscalYear->year;

        return response()->json(['result' => true, 'year' => $exec_year], 200);
    }
}
