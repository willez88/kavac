<?php

namespace Modules\Accounting\Http\Controllers;

use Auth;
use DateTime;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Profile;

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
     * @return Renderable
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
        /**
         * [$records información de los ultimos 10 asientos contables generados]
         * @var array
         */
        $records = [];

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile && $user_profile['institution']['id']) {
            $records = AccountingEntry::with('accountingAccounts.account.accountConverters.budgetAccount')
                        ->where('institution_id', $user_profile['institution']['id'])
                        ->orderBy('from_date', 'ASC')->get();
        } else {
            if (auth()->user()->isAdmin()) {
                $records = AccountingEntry::with('accountingAccounts.account.accountConverters.budgetAccount')
                        ->orderBy('from_date', 'ASC')->get();
            }
        }

        return response()->json(['lastRecords' => $records, 'currency' => $currency], 200);
    }

    /**
     * Obtiene los registros de los ultimos reportes generados
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return JsonResponse
     */
    public function getReportHistories()
    {
        /**
         * [$report_histories almacenara la informacion de los reportes]
         * @var array
         */
        $report_histories = [];

        $reports = [];

        $institution      = get_institution();

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile && $user_profile['institution']['id']) {
            $reports = AccountingReportHistory::with('institution')
                        ->where('institution_id', $user_profile['institution']['id'])
                                            ->orderBy('updated_at', 'DESC')->get();
        } else {
            if (auth()->user()->isAdmin()) {
                $reports = AccountingReportHistory::with('institution')->orderBy('updated_at', 'DESC')->get();
            }
        }
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
                                 'institution_name' => $report['institution']['name'],
                                 'created_at' => $report['updated_at']->format('d/m/Y'),
                                 'name'       => $report['report'],
                                 'url'        => $report['url'],
                                 'interval'   => (floor(($interval->format('%a') / 7)) . ' semanas con '.
                                                 ($interval->format('%a') % 7) . ' días'),
                                ]);
        }

        return response()->json(['report_histories' => $report_histories], 200);
    }
}
