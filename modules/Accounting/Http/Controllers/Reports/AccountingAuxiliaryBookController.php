<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;

use App\Repositories\ReportRepository;
use App\Models\Institution;
use DateTime;
use Auth;

/**
 * @class AccountingReportPdfAuxiliaryBookController
 * @brief Controlador para la generación del reporte de libro auxiliar
 *
 * Clase que gestiona el reporte de libro auxiliar
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingAuxiliaryBookController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.auxiliarybook', ['only' => ['index', 'pdf']]);
    }

    /**
     * [pdf vista en la que se genera el reporte en pdf]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [string] $account_id [variable con el id de la cuenta]
     * @param  [string] $date       [fecha para la generación de reporte, formato 'YYYY-mm']
     */
    public function pdf($account_id, $date)
    {
        /**
         * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $url = 'auxiliaryBook/pdf/'.$account_id.'/'.$date;

        $currentDate = new DateTime;
        $currentDate = $currentDate->format('Y-m-d');

        /**
         * [$report almacena el registro del reporte del dia si existe]
         * @var [type]
         */
        $report = AccountingReportHistory::whereBetween('updated_at', [
                                                                        $currentDate.' 00:00:00',
                                                                        $currentDate.' 23:59:59'
                                                                    ])
                                        ->where('report', 'Libro Auxiliar')->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            AccountingReportHistory::create(
                [
                    'report' => 'Libro Auxiliar',
                    'url' => $url,
                ]
            );
        } else {
            $report->url = $url;
            $report->save();
        }

        /**
         * [$initDate fecha inicial de busqueda]
         * @var string
         */
        $initDate = $date.'-01';

        /**
         * [$day ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate fecha final de busqueda]
         * @var string
         */
        $endDate = $date.'-'.$day;

        /**
         * [$account cuenta patrimonial con su relacion en asientos contables]
         * @var [Modules\Accounting\Models\AccountingSeat]
         */
        $account = AccountingAccount::with(['seatAccount.seating' => function ($query) use ($initDate, $endDate) {
            if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
            }
        }])->find($account_id);

        /**
         * [$parent_account cuenta patrimonial de nivel superior]
         * @var [Modules\Accounting\Models\AccountingSeat]
         */
        $parent_account = $account->getParent(
            $account->group,
            $account->subgroup,
            $account->item,
            $account->generic,
            $account->specific,
            $account->subspecific
        );

        /**
         * [$setting configuración general de la aplicación]
         * @var [Modules\Accounting\Models\Setting]
         */
        $setting = Setting::all()->first();

        /**
         * [$currency información de la modena por defecto establecida en la aplicación]
         * @var [Modules\Accounting\Models\Currency]
         */
        $currency = Currency::where('default', true)->first();

        $initDate = new DateTime($initDate);
        $endDate = new DateTime($endDate);

        $initDate = $initDate->format('d/m/Y');
        $endDate = $endDate->format('d/m/Y');

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $institution = Institution::find(1);
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => 'www.google.com']);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de libro Auxiliar');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.auxiliary_book', true, [
            'pdf' => $pdf,
            'record' => $account,
            'initDate' => $initDate,
            'endDate' => $endDate,
            'currency' => $currency,
            'parent_account' => $parent_account,
        ]);
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
