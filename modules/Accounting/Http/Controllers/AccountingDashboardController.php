<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use DateTime;
use Auth;

class AccountingDashboardController extends Controller
{
    /**
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware(
            'permission:accounting.dashboard',
            ['only' => ['index', 'get_operations', 'get_report_histories']]
        );
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('accounting::index_test');
    }

    /**
     * Obtiene las ultimas 10 operaciones de creacion de asientos contables realizadas
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return View
     */
    public function getOperations()
    {
        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default', true)->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $report_histories = AccountingReportHistory::orderBy('updated_at', 'DESC')->get();

        /** @var Object con la información de los ultimos 10 asientos contables generados */
        $lastRecords = AccountingSeat::orderBy('updated_at', 'DESC')->take(10)->get();

        return response()->json(['lastRecords' => $lastRecords, 'currency' => $currency], 200);
    }

    /**
     * Obtiene los registros de los ultimos reportes generados
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return View
     */
    public function getReportHistories()
    {
        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $report_histories = [];

        for ($i=1; $i<=6; $i++) {
            $aux = AccountingReportHistory::where('report', $i)->orderBy('updated_at', 'DESC')->first();
            if (!is_null($aux)) {

                /**
                * Se calcula el intervalo de tiempo entre la fecha en la que se genero el reporte
                * y la fecha actual en semanas y dias
                */
                $datetime1 = new DateTime($aux['updated_at']->format('Y-m-d'));
                $datetime2 = new DateTime(date("Y-m-d"));
                $interval = $datetime1->diff($datetime2);
                array_push($report_histories, [
                                                'created_at' => $aux['updated_at']->format('d/m/Y'),
                                                'interval'=> (floor(($interval->format('%a') / 7)) . ' semanas con '
                             . ($interval->format('%a') % 7) . ' días'),
                                                'name' => $aux['name'],
                                                'url' => $aux['url'],
                                                'id' => $aux['id']
                                                ]);
            }
        }

        return response()->json(['report_histories' => $report_histories], 200);
    }
}
