<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use App\Repositories\ReportRepository;
use App\Models\Institution;

/**
 * @class AccountingSeatReportPdfController
 * @brief Controlador para la generación del reporte de asiento contable
 *
 * Clase que gestiona el reporte de asiento contable
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingSeatReportPdfController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.seating.report', ['only' => 'pdf']);
    }

    /**
     * vista en la que se genera el reporte en pdf de balance de comprobación
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param Int $id id del asiento contable
    */
    public function pdf($id)
    {

        /** @var Objet objeto con la información del asiento contable */
        $seat = AccountingSeat::with('accountingAccounts.account.accountConverters.budgetAccount')->find($id);

        /** @var Object configuración general de la apliación */
        $setting = Setting::all()->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default', true)->first();
        
        $Seating = true;

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
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de asiento contable');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.accounting_seat_and_daily_book_pdf', true, [
            'pdf' => $pdf,
            'seat' => $seat,
            'currency' => $currency,
            'Seating' => $Seating,
        ]);
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
