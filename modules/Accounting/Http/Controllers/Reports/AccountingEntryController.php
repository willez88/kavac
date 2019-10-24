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

        /** @var Objet objeto con la información del asiento contable */
        $entry = AccountingEntry::with(
            'accountingAccounts.account.accountConverters.budgetAccount',
            'currency'
        )->find($id);

        /** @var Object configuración general de la apliación */
        $setting = Setting::all()->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default', true)->first();
        
        $Entry = true;

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
        $pdf->setBody('accounting::pdf.entry_and_daily_book', true, [
            'pdf' => $pdf,
            'entry' => $entry,
            'currency' => $entry->currency,
            'Entry' => $Entry,
        ]);
    }

    public function getCheckBreak()
    {
        return $this->PageBreakTrigger;
    }
}
