<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Repositories\ReportRepository;
use Carbon\Carbon;
use Modules\Payroll\Models\PayrollVacationRequest;
use Modules\Payroll\Models\PayrollStaff;
use Modules\Payroll\Models\PayrollEmployment;
use Modules\Payroll\Models\PayrollPositionType;
use Modules\Payroll\Models\Payroll;
use Modules\Payroll\Models\Institution;
use Modules\Payroll\Models\PayrollVacationPolicy;

/**
 * @class      PayrollReportController
 * @brief      Controlador que gestiona los reportes del módulo de talento humano
 *
 * Clase que gestiona los reportes del módulo de talento humano
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
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
        $filename = 'payroll-report-' . Carbon::now()->format('Y-m-d') . '.pdf';

        if ($request->current == 'vacation-enjoyment-summaries') {
            $body = 'payroll::pdf.payroll-vacation-enjoyment-summaries';
        } elseif ($request->current == 'vacation-status') {
            $body = 'payroll::pdf.payroll-vacation-status';
        } elseif ($request->current == 'registers') {
            $body = 'payroll::pdf.payroll-registers';
        } elseif ($request->current == 'employment-status') {
            $body = 'payroll::pdf.payroll-employment-status';
        } elseif ($request->current == 'staff-vacation-enjoyment') {
            $body = 'payroll::pdf.payroll-staff-vacation-enjoyment';
        } else {
            $body = '';
        }

        $pdf->setConfig(
            [
                'institution' => $institution,
                'urlVerify'   => url(''),
                'orientation' => 'P',
                'filename'    => $filename
            ]
        );

        if ($request->current == 'vacation-enjoyment-summaries') {

            $vacationPolicy = PayrollVacationPolicy::where('active', true)->firstOrFail();

            $records = PayrollVacationRequest::where('status', 'approved')
                ->where('payroll_staff_id', $request->input('id'))
                ->orderBy('vacation_period_year', 'DESC');

            $payrollStaff = PayrollStaff::find($request->input('id'));
            $date = new Carbon($payrollStaff->payrollEmployment->start_date);
            $payrollStaffYear = $date->year;
            $currentYear = Carbon::now()->year;
            $years = [];

            while ($payrollStaffYear <= $currentYear) $years[] = $payrollStaffYear++;

            $records = $records->get();

            foreach ($records as $record) {
                $index = array_search($record->vacation_period_year, $years);

                $record->days_old = $index * $vacationPolicy->additional_days_per_year + $vacationPolicy->vacation_days;
                $record->pending_days = $index * $vacationPolicy->additional_days_per_year + $vacationPolicy->vacation_days - $record->days_requested;
            }

            $pdf->setHeader("Reporte de disfrute de vacaciones");
        } elseif ($request->current == 'vacation-status') {
            $records = PayrollVacationRequest::find($request->input('id'));
            $pdf->setHeader("Reporte de estatus de vacaciones");
        } elseif ($request->current == 'registers') {
            $payrollRegister = Payroll::find($request->input('id'));
            $records = $payrollRegister->payrollStaffPayrolls;
            $pdf->setHeader("Reporte de registros de nómina");
        } elseif ($request->current == 'employment-status') {
            $records = PayrollStaff::find($request->input('id'));
            $pdf->setHeader("Reporte de estatus de los trabajadores");
        } else if ($request->current == 'staff-vacation-enjoyment') {

            $payroll_staff_id = $request->input('payroll_staff_id');

            $records = PayrollVacationRequest::where('status', 'approved');

            if ($payroll_staff_id) {
                $records = $records->where('payroll_staff_id', $payroll_staff_id);
            }

            $records = $records->get();

            $pdf->setHeader("Reporte de Personal en Disfrute de Vacaciones");
        }

        $pdf->setFooter();
        $pdf->setBody(
            $body,
            true,
            [
                'pdf'    => $pdf,
                'field'  => $records
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
        $file = storage_path() . DIRECTORY_SEPARATOR . 'reports' . DIRECTORY_SEPARATOR . $filename ?? 'payroll-report-' . Carbon::now() . '.pdf';
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

    public function benefitsAdvance()
    {
        return view('payroll::reports.benefits.payroll-report-benefit-advances');
    }
    /**
     * Funcion publica para los reportes de empleados.
     *
     * @author Ezequiel Baptista <ebaptista@cenditel.gob.ve>
     */
    public function employmentStatus()
    {
        return view('payroll::reports.payroll-report-employment-status');
    }

    public function staffVacationEnjoyment()
    {
        return view('payroll::reports.payroll-report-staff-vacation-enjoyment');
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
            $startDate = date('Y-m-d', mktime(0, 0, 0, $start_date[1], 1, $start_date[0]));
        }
        if ($request->end_date) {
            $end_date = explode('-', $request->end_date);
            $end_day = date("d", mktime(0, 0, 0, $end_date[1], 0, $end_date[0]));
            $endDate = date('Y-m-d', mktime(0, 0, 0, $end_date[1], $end_day, $end_date[0]));
        }

        $user = Auth()->user();
        $profileUser = $user->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        if (($request->current == "staff-vacation-enjoyment") || ($request->current == "vacation-status")) {
            if ($user->hasRole('admin')) {
                $records = PayrollVacationRequest::searchPayrollVacationRequest(
                    $startDate,
                    $endDate,
                    $request->payroll_staff_id ?? ''
                )->where('institution_id', $institution->id)->where('status', 'approved')->get();
            } else {
                $records = [];
            }
        } else if ($request->current == "vacation-enjoyment-summaries") {
            if ($request->need_institution_start_year) {
                $institution = Institution::where('active', true)->where('default', true)->first();

                $date = new Carbon($institution->start_operations_date);

                return response()->json(['institutionStartYear' => $date->year]);
            }

            $holiday_period = $request->input('holiday_period');
            $payroll_staff_id = $request->input('payroll_staff_id');

            $records = PayrollVacationRequest::where('status', 'approved');

            if ($holiday_period) {
                $records->where('vacation_period_year', $holiday_period);
            }

            if ($payroll_staff_id) {
                $records->where('payroll_staff_id', $payroll_staff_id);
            }

            $vacationPolicy = PayrollVacationPolicy::where('active', true)->firstOrFail();

            $records->orderBy('vacation_period_year', 'DESC');

            $payrollStaff = PayrollStaff::find($request->input('payroll_staff_id'));
            $date = new Carbon($payrollStaff->payrollEmployment->start_date);
            $payrollStaffYear = $date->year;
            $currentYear = Carbon::now()->year;
            $years = [];

            while ($payrollStaffYear <= $currentYear) $years[] = $payrollStaffYear++;

            $records = $records->get();

            foreach ($records as $record) {
                $index = array_search($record->vacation_period_year, $years);

                $record->days_old = $index * $vacationPolicy->additional_days_per_year + $vacationPolicy->vacation_days;
                $record->pending_days = $index * $vacationPolicy->additional_days_per_year + $vacationPolicy->vacation_days - $record->days_requested;
            }
        }

        return response()->json(['records' => $records], 200);
    }
}
