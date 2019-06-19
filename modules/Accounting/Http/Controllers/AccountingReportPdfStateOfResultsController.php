<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;
use Auth;

/**
 * @class AccountingReportPdfStateOfResultsController
 * @brief Controlador para la generación del reporte de estado de resultados
 * 
 * Clase que gestiona el reporte de estado de resultados
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingReportPdfStateOfResultsController extends Controller
{
    /**
     * Despliega la vista principal del formulario de reporte de stado de resultados
     * @return View
     */
    public function index()
    {
        /** @var Object String con el tipo de reporte que abrira */
        $type_report = 'stateOfResults';

        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $seating = AccountingSeat::where('approved', true)->orderBy('from_date','ASC')->first();
        
        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $year_old = explode('-',$seating['from_date'])[0];

        return view('accounting::reports.index-balance_sheet_and_state_of_results',compact('year_old','type_report'));
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('accounting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
