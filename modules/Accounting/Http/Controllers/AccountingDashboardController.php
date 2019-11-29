<?php

namespace Modules\Accounting\Http\Controllers;

use Auth;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Institution;

/**
 * @class AccountingAccountConverterController
 * @brief Controlador para el manejo del dashboard
 *
 * Clase que gestiona la informacion del dashboard de contabilidad
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AccountingDashboardController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /**
         * Establece permisos de acceso para cada método del controlador
         */
        $this->middleware(
            'permission:accounting.dashboard',
            ['only' => ['index', 'get_operations', 'get_report_histories']]
        );
    }

    /**
     * [index Despliega la vista principal]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [view]
     */
    public function index()
    {
        return view('accounting::index_test');
    }

    /**
     * [getOperations Obtiene las ultimas 10 operaciones de creacion de asientos contables realizadas]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [Response]
     */
    public function getOperations()
    {
        /**
         * [$currency información de la modena por defecto establecida en la aplicación]
         * @var [Modules\Accounting\Models\Currency]
         */
        $currency    = Currency::where('default', true)->first();

        $institution = $this->getInstitution();
        /**
         * [$lastRecords información de los ultimos 10 asientos contables generados]
         * @var [Modules\Accounting\Models\AccountingEntry]
         */
        $lastRecords = AccountingEntry::where('institution_id', $institution->id)
                                        ->orderBy('updated_at', 'DESC')->take(10)->get();

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
        /**
         * [$report_histories almacenara la informacion de los reportes]
         * @var array
         */
        $report_histories = [];
        
        $institution      = $this->getInstitution();

        $reports = AccountingReportHistory::where('institution_id', $institution->id)
                                            ->orderBy('updated_at', 'DESC')->get();
        foreach ($reports as $report) {

            /**
            * Se calcula el intervalo de tiempo entre la fecha en la que se genero el reporte
            * y la fecha actual en semanas y dias
            */
            $datetime1 = new DateTime($report['updated_at']->format('Y-m-d'));
            $datetime2 = new DateTime(date("Y-m-d"));
            $interval = $datetime1->diff($datetime2);
            array_push($report_histories, [
                                 'id'         => $report['id'],
                                 'created_at' => $report['updated_at']->format('d/m/Y'),
                                 'name'       => $report['report'],
                                 'url'        => $report['url'],
                                 'interval'   => (floor(($interval->format('%a') / 7)) . ' semanas con '.
                                                 ($interval->format('%a') % 7) . ' días'),
                                ]);
        }

        return response()->json(['report_histories' => $report_histories], 200);
    }

    /**
     * [getInstitution obtiene la informacion de una institución]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  int|null $id [identificador unico de la institución]
     * @return Institution     [informacion de la institución]
     */
    public function getInstitution($id = null)
    {
        if ($id) {
            return Institution::find($id);
        }
        return Institution::first();
    }
}
