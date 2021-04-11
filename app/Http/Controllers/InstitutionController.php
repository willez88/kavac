<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Institution;
use Carbon\Carbon;

/**
 * @class InstitutionController
 * @brief Gestiona información de Organizaciones
 *
 * Controlador para gestionar Organizaciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class InstitutionController extends Controller
{
    /**
     * Obtiene las Organizaciones registradas
     *
     * @method  getInstitutions
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  integer $id                      Identificador de la organización a buscar, este parámetro es opcional
     *
     * @return JsonResponse    JSON con los datos de las Organizaciones
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
     * @param  integer $institution_id          Identificador de la organización, si no se especifica toma
     *                                          el valor por defecto
     * @param  string  $year                    Año de la ejecución, si no se especifica toma el año actual
     *                                          del sistema
     * @return JsonResponse    JSON con información del año de execución
     */
    public function getExecutionYear($institution_id = null, $year = null)
    {
        /** @var string Texto que identifica el año fiscal actual */
        $year = $year ?? Carbon::now()->format("Y");
        /** @var string Año de ejercicio fiscal por defecto */
        $exec_year = $year;
        /** @var array Establece los filtros a aplicar para la consulta del año fiscal en curso */
        $filter = ['active' => true];
        $filter[(is_null($institution_id)) ? 'default' : 'id'] = (is_null($institution_id)) ? true : $institution_id;
        /** @var Institution Objeto con datos de los organismos a consultar */
        $institution = Institution::with(['fiscalYears'])->where($filter)->first();

        if ($institution) {
            /** @var FiscalYear Año de ejercicio fiscal activo */
            $fiscalYear = $institution->fiscalYears()->where('active', true)->first();
            if (!$fiscalYear) {
                $fiscalYear = $institution->fiscalYears()->updateOrCreate(
                    ['active' => true, 'year' => $year],
                    ['observations' => 'Ejercicio económico de ' . $institution->acronym]
                );
            }
            /** @var string Año fiscal actual */
            $exec_year = $fiscalYear->year;
        }

        return response()->json(['result' => true, 'year' => $exec_year], 200);
    }
}
