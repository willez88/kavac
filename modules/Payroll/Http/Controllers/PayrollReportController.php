<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Repositories\ReportRepository;
use Carbon\Carbon;

use Modules\Payroll\Models\PayrollVacationRequest;
use Modules\Payroll\Models\Institution;
use App\Models\CodeSetting;

/**
 * @class      PayrollReportController
 * @brief      Controlador que gestiona los reportes del módulo de talento humano
 *
 * Clase que gestiona los reportes del módulo de talento humano
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollReportController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:payroll.reports', ['only' => 'create']);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $user = Auth()->user();
        $profileUser = $user->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }

        $pdf = new ReportRepository();
        $payrollVacationRequest = PayrollVacationRequest::find($request->input('id'));
        $filename = 'payroll-report-' . Carbon::now() . '.pdf';

        $body = ($request->current == 'vacation-enjoyment-summaries')
                    ? 'payroll::pdf.payroll-vacation-enjoyment-summaries'
                    : ($request->current == 'vacation-status')
                        ? 'payroll::pdf.payroll-vacation-status'
                        : '';
        $pdf->setConfig(
            [
                'institution' => $institution,
                'urlVerify'   => 'www.google.com',
                'orientation' => 'P',
                'filename'    => $filename
            ]
        );

        if ($request->current == 'vacation-enjoyment-summaries') {
            $pdf->setHeader("Reporte de disfrute de vacaciones");
        } elseif ($request->current == 'vacation-status') {
            $pdf->setHeader("Reporte de estatus de vacaciones");
        }
        $pdf->setFooter();
        $pdf->setBody(
            $body,
            true,
            [
                'pdf'    => $pdf,
                'field'  => $payrollVacationRequest
            ]
        );
        $url = '/payroll/reports/show/' . $filename;
        return response()->json(['result' => true, 'redirect' => $url], 200);
    }

    /**
     * Show the specified resource.
     * @param string filename
     * @return Renderable
     */
    public function show($filename)
    {
        $file = storage_path() . '/reports/' . $filename ?? 'payroll-report-' . Carbon::now() . '.pdf';
        return response()->download($file, $filename, [], 'inline');
    }

    public function vacationEnjoymentSummaries()
    {
        return view('payroll::reports.payroll-report-vacation-enjoyment-summaries');
    }

    public function vacationStatus()
    {
        return view('payroll::reports.payroll-report-vacation-status');
    }

    public function vacationBonusCalculations()
    {
        return view('payroll::reports.payroll-report-vacation-bonus-calculations');
    }

    /**
     * Muestra un listado para la generación de reportes según sea el caso
     *
     * @method    vueList
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function vueList(Request $request)
    {
        $startDate = $endDate = '';
        if ($request->start_date) {
            $start_date = explode('-', $request->start_date);
            $startDate = date('Y-m-d', mktime(0,0,0, $start_date[1], 1, $start_date[0]));
        }
        if ($request->end_date) {
            $end_date = explode('-', $request->end_date);
            $end_day = date("d", mktime(0,0,0, $end_date[1]+1, 0, $end_date[0]));
            $endDate = date('Y-m-d', mktime(0,0,0, $end_date[1], $end_day, $end_date[0]));
        }

        $user = Auth()->user();
        $profileUser = $user->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        if (($request->current == "vacation-enjoyment-summaries") || ($request->current == "vacation-status")) {
            if ($user->hasRole('admin')) {
                $records = PayrollVacationRequest::searchPayrollVacationRequest(
                    $startDate,
                    $endDate,
                    $request->payroll_staff_id ?? ''
                )->where('institution_id', $institution->id)->get();
            } else {
                $records = [];
            }
        } else {
            //
        }

        return response()->json(['records' => $records], 200);
    }
}