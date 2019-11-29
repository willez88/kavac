<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use App\Repositories\ReportRepository;
use App\Models\Institution;
use Auth;

/**
 * @class AccountingReportPdfCheckupBalanceController
 * @brief Controlador para la generación del reporte del asiento contable
 *
 * Clase que gestiona de la generación del reporte del asiento contable
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingEntryController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.entries.report', ['only' => 'pdf']);
    }

    /**
     * vista en la que se genera el reporte en pdf de balance de comprobación
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param Int $id id del asiento contable
    */
    public function pdf($id)
    {

        /**
         * [$entry información del asiento contable]
         * @var AccountingEntry
         */
        $entry = AccountingEntry::with(
            'accountingAccounts.account.accountConverters.budgetAccount',
            'currency'
        )->find($id);

        /**
         * [$setting configuración general de la apliación]
         * @var Setting
         */
        $setting = Setting::all()->first();
        
        $Entry   = true;

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $institution = Institution::find(1);
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url(' entries/pdf/'.$id)]);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de asiento contable');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.entry_and_daily_book', true, [
            'pdf'      => $pdf,
            'entry'    => $entry,
            'currency' => $entry->currency,
            'Entry'    => $Entry,
        ]);
    }

    public function getCheckBreak()
    {
        return $this->PageBreakTrigger;
    }
}
