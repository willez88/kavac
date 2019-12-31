<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Models\Institution;
use App\Models\DocumentStatus;
use App\Models\FiscalYear;
use Carbon\Carbon;
use Module;

/**
 * @class InstitutionController
 * @brief Gestiona información de Instituciones
 *
 * Controlador para gestionar Instituciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class InstitutionController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

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


        if ($institution && Module::has('Budget')) {
            $execution = \Modules\Budget\Models\BudgetSubSpecificFormulation::where([
                'year' => $year, 'assigned' => true, 'document_status_id' => $documentStatus->id,
                'institution_id' => $institution->id
            ])->first();
        }
        $fiscalYear = FiscalYear::firstOrCreate(
            ['year' => ($execution) ? $execution->year : $year, 'active' => true]
        );
        $exec_year = Crypt::encrypt($fiscalYear->year);

        return response()->json(['result' => true, 'year' => $exec_year], 200);
    }
}
