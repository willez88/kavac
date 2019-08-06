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
class AccountingLastOperationsController extends Controller
{
    public function get_operations()
    {
        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default',true)->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $report_histories = AccountingReportHistory::orderBy('updated_at','DESC')->get();

        /** @var Object con la información de los ultimos 10 asientos contables generados */
        $lastRecords = AccountingSeat::orderBy('updated_at','DESC')->take(10)->get();

        return response()->json(['lastRecords' => $lastRecords, 'currency' => $currency],200);
    }

    public function get_report_histories()
    {

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $report_histories = [];

        for ($i=1; $i <= 6 ; $i++) { 
            $aux = AccountingReportHistory::where('report', $i)->orderBy('updated_at','DESC')->first();
            if (!is_null($aux)) {

                /**
                * Se calcula el intervalo de tiempo entre la fecha en la que se genero el reporte y la fecha actual en semanas y dias
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

        // $report_histories = json_encode($report_histories);
        return response()->json(['report_histories' => $report_histories],200);
    }
}
