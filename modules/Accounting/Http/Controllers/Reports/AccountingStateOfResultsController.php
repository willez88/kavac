<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Models\ExchangeRate;
use Modules\Accounting\Models\Institution;
use Modules\Accounting\Models\Profile;

use App\Repositories\ReportRepository;
use Modules\DigitalSignature\Repositories\ReportRepositorySign;

use Auth;
use DateTime;

/**
 * @class AccountingReportPdfStateOfResultsController
 * @brief Controlador para la generación del reporte de estado de resultados
 *
 * Clase que gestiona el reporte de estado de resultados
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                    LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingStateOfResultsController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.stateofresults', ['only' => ['pdf','pdfVue','pdfSign','pdfVueSign']]);
    }

    /**
     * [$convertions lista de conversiones validas]
     * @var array
     */
    protected $convertions = [];

    /**
     * [$currency moneda en la que se expresara el reporte]
     * @var [type]
     */
    protected $currency = null;

    public function getConvertions()
    {
        return $this->convertions;
    }

    public function setConvertions($convertions)
    {
        $this->convertions = $convertions;
    }

    public function getCurrencyId()
    {
        return $this->currency->id;
    }
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * [setCurrency]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Currency $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * [pdf genera el reporte en pdf de balance general]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  string   $date     [fecha]
     * @param  string   $level    [nivel de sub cuentas maximo a mostrar]
     * @param  Currency $currency [moneda en que se expresara el reporte]
     * @param  boolean  $zero     [si se tomaran cuentas con saldo cero]
     */
    public function pdfVue($date, $level, Currency $currency, $zero = false)
    {
        /**
         * [$day ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate formatea la fecha final de busqueda, (YYYY-mm-dd HH:mm:ss)]
         * @var [type]
         */
        $endDate = $date.'-'.$day;

        $institution_id = null;

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        $is_admin = auth()->user()->isAdmin();

        if (!$is_admin && $user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        /**
         * consulta de cada cuenta y asiento que pertenezca a ACTIVO, PASIVO, PATRIMONIO y CUENTA DE ORDEN
         * [$query registros de las cuentas patrimoniales seleccionadas]
         * @var Modules\Accounting\Models\AccountingAccount
         */
        $query = AccountingAccount::with('entryAccount.entries.currency')
            ->with(['entryAccount.entries' => function ($query) use ($endDate, $date, $institution_id, $is_admin) {
                if ($institution_id) {
                    if ($query->whereBetween('from_date', [explode('-', $date)[0].'-01-01', $endDate])
                        ->where('approved', true)->where('institution_id', $institution_id)) {
                        $query->whereBetween('from_date', [explode('-', $date)[0].'-01-01', $endDate])
                        ->where('approved', true)->where('institution_id', $institution_id);
                    }
                } else {
                    if ($is_admin) {
                        $query->whereBetween('from_date', [explode('-', $date)[0].'-01-01', $endDate])
                        ->where('approved', true)->where('institution_id', $institution_id);
                    }
                }
            }])
            ->whereHas('entryAccount.entries', function ($query) use ($endDate, $date, $institution_id, $is_admin) {
                $query->whereBetween('from_date', [explode('-', $date)[0].'-01-01', $endDate])
                        ->where('approved', true)->where('institution_id', $institution_id);
            })
            ->whereBetween('group', [5, 6])
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();

        $convertions = [];

        /*
         * Se recorre y evalua la relacion en las conversiones necesarias a realizar
         */
        foreach ($query as $record) {
            foreach ($record['entryAccount'] as $entryAccount) {
                $inRange = false;
                if ($entryAccount['entries']) {
                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)) {
                        $convertions = $this->calculateExchangeRates(
                            $convertions,
                            $entryAccount['entries'],
                            $currency['id']
                        );
                    }

                    foreach ($convertions as $convertion) {
                        foreach ($convertion as $convert) {
                            if ($entryAccount['entries']['from_date'] >= $convert['start_at'] &&
                                $entryAccount['entries']['from_date'] <= $convert['end_at']) {
                                $inRange = true;
                            }
                        }
                    }

                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)
                            && $entryAccount['entries']['currency']['id'] != $currency['id']) {
                        return response()->json([
                                        'result'=>false,
                                        'message'=>'Imposible expresar '.$entryAccount['entries']['currency']['symbol']
                                                    .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                                    ', verificar tipos de cambio configurados. '
                                    ], 200);
                    } elseif (!$inRange) {
                        if ($entryAccount['entries']['currency']['id'] != $currency->id) {
                            return response()->json([
                                    'result'=>false,
                                    'message'=>'Imposible expresar '.$entryAccount['entries']['currency']['symbol']
                                                .' ('.$entryAccount['entries']['currency']['name'].')'
                                                .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                                ', verificar tipos de cambio configurados. Para la fecha de '.
                                                $entryAccount['entries']['from_date'],
                                ], 200);
                        }
                    }
                }
            }
        }
        /**
         * [$day almacena el ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate formatea la fecha final de busqueda, (YYYY-mm-dd HH:mm:ss)]
         * @var string
         */
        $endDate = $date.'-'.$day;

        /**
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $zero = ($zero)?'true':'';
        $url  = 'StateOfResults/'.$endDate.'/'.$level.'/'.$zero;

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
                                        ->where('report', 'Estado de Resultados')
                                        ->where('institution_id', $institution_id)->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            $report = AccountingReportHistory::create(
                [
                    'report'         => 'Estado de Resultados',
                    'url'            => $url,
                    'currency_id'    => $currency->id,
                    'institution_id' => $institution_id,
                ]
            );
        } else {
            $report->url            = $url;
            $report->currency_id    = $currency->id;
            $report->institution_id = $institution_id;
            $report->save();
        }
        return response()->json(['result'=>true, 'id'=>$report->id], 200);
    }

    /**
     * [pdf genera el reporte en pdf de balance general]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  string   $date     [fecha]
     * @param  string   $level    [nivel de sub cuentas maximo a mostrar]
     * @param  Currency $currency [moneda en que se expresara el reporte]
     * @param  boolean  $zero     [si se tomaran cuentas con saldo cero]
     */
    public function pdfVueSign($date, $level, Currency $currency, $zero = false)
    {
        /**
         * [$day ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate formatea la fecha final de busqueda, (YYYY-mm-dd HH:mm:ss)]
         * @var [type]
         */
        $endDate = $date.'-'.$day;

        $institution_id = null;

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        $is_admin = auth()->user()->isAdmin();

        if (!$is_admin && $user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        /**
         * consulta de cada cuenta y asiento que pertenezca a ACTIVO, PASIVO, PATRIMONIO y CUENTA DE ORDEN
         * [$query registros de las cuentas patrimoniales seleccionadas]
         * @var Modules\Accounting\Models\AccountingAccount
         */
        $query = AccountingAccount::with('entryAccount.entries.currency')
            ->with(['entryAccount.entries' => function ($query) use ($endDate, $date, $institution_id, $is_admin) {
                if ($institution_id) {
                    if ($query->whereBetween('from_date', [explode('-', $date)[0].'-01-01', $endDate])
                        ->where('approved', true)->where('institution_id', $institution_id)) {
                        $query->whereBetween('from_date', [explode('-', $date)[0].'-01-01', $endDate])
                        ->where('approved', true)->where('institution_id', $institution_id);
                    }
                } else {
                    if ($is_admin) {
                        $query->whereBetween('from_date', [explode('-', $date)[0].'-01-01', $endDate])
                        ->where('approved', true)->where('institution_id', $institution_id);
                    }
                }
            }])
            ->whereHas('entryAccount.entries', function ($query) use ($endDate, $date, $institution_id, $is_admin) {
                $query->whereBetween('from_date', [explode('-', $date)[0].'-01-01', $endDate])
                        ->where('approved', true)->where('institution_id', $institution_id);
            })
            ->whereBetween('group', [5, 6])
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();

        $convertions = [];

        /*
         * Se recorre y evalua la relacion en las conversiones necesarias a realizar
         */
        foreach ($query as $record) {
            foreach ($record['entryAccount'] as $entryAccount) {
                $inRange = false;
                if ($entryAccount['entries']) {
                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)) {
                        $convertions = $this->calculateExchangeRates(
                            $convertions,
                            $entryAccount['entries'],
                            $currency['id']
                        );
                    }

                    foreach ($convertions as $convertion) {
                        foreach ($convertion as $convert) {
                            if ($entryAccount['entries']['from_date'] >= $convert['start_at'] &&
                                $entryAccount['entries']['from_date'] <= $convert['end_at']) {
                                $inRange = true;
                            }
                        }
                    }

                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)
                            && $entryAccount['entries']['currency']['id'] != $currency['id']) {
                        return response()->json([
                                        'result'=>false,
                                        'message'=>'Imposible expresar '.$entryAccount['entries']['currency']['symbol']
                                                    .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                                    ', verificar tipos de cambio configurados. '
                                    ], 200);
                    } elseif (!$inRange) {
                        if ($entryAccount['entries']['currency']['id'] != $currency->id) {
                            return response()->json([
                                    'result'=>false,
                                    'message'=>'Imposible expresar '.$entryAccount['entries']['currency']['symbol']
                                                .' ('.$entryAccount['entries']['currency']['name'].')'
                                                .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                                ', verificar tipos de cambio configurados. Para la fecha de '.
                                                $entryAccount['entries']['from_date'],
                                ], 200);
                        }
                    }
                }
            }
        }
        /**
         * [$day almacena el ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate formatea la fecha final de busqueda, (YYYY-mm-dd HH:mm:ss)]
         * @var string
         */
        $endDate = $date.'-'.$day;

        /**
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $zero = ($zero)?'true':'';
        $url  = 'StateOfResultsSign/'.$endDate.'/'.$level.'/'.$zero;

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
                                        ->where('report', 'Estado de Resultados')
                                        ->where('institution_id', $institution_id)->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            $report = AccountingReportHistory::create(
                [
                    'report'         => 'Estado de Resultados',
                    'url'            => $url,
                    'currency_id'    => $currency->id,
                    'institution_id' => $institution_id,
                ]
            );
        } else {
            $report->url            = $url;
            $report->currency_id    = $currency->id;
            $report->institution_id = $institution_id;
            $report->save();
        }
        return response()->json(['result'=>true, 'id'=>$report->id], 200);
    }

    /**
     * [pdf genera el reporte en pdf de estado de resultados]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $report [id de reporte y su informacion]
     */
    public function pdf($report)
    {
        $report  = AccountingReportHistory::with('currency')->find($report);
        // Validar acceso para el registro
        if (!auth()->user()->isAdmin()) {
            $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();
            if ($report && $report->queryAccess($user_profile['institution']['id'])) {
                return view('errors.403');
            }
        }
        $endDate = explode('/', $report->url)[1];
        $level   = explode('/', $report->url)[2];
        $zero    = explode('/', $report->url)[3];
        $date    = explode('-', $endDate)[0].'-'.explode('-', $endDate)[1];
        $this->setCurrency($report->currency);

        $institution_id = null;

        $is_admin = auth()->user()->isAdmin();

        if (!$is_admin && $user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        /**
         * [$level_1 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_1 = 'entryAccount.entries';

        /**
         * [$level_2 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_2 = 'children.entryAccount.entries';

        /**
         * [$level_3 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_3 = 'children.children.entryAccount.entries';

        /**
         * [$level_4 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_4 = 'children.children.children.entryAccount.entries';

        /**
         * [$level_5 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_5 = 'children.children.children.children.entryAccount.entries';

        /**
         * [$level_6 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_6 = 'children.children.children.children.children.entryAccount.entries';

        /**
        * Se realiza la consulta de cada cuenta y asiento que pertenezca a INGRESOS Y GASTOS
        */
        $records = AccountingAccount::with($level_1, $level_2, $level_3, $level_4, $level_5, $level_6)
            ->with([$level_1 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_2 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_3 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_4 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_5 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_6 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->whereBetween('group', [5, 6])
            ->where('subgroup', 0)
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')->get();

        /**
         * [$records con los registros de las cuentas]
         * @var array
         */
        $records = $this->formatDataInArray($records, $date, $endDate);

        /**
         * [$setting configuración general de la apliación]
         * @var Setting
         */
        $setting = Setting::all()->first();

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $lastOfThePreviousMonth = date('d', (mktime(0, 0, 0, explode('-', $date)[1], 1, explode('-', $date)[0])-1));
        $last                   = ($lastOfThePreviousMonth.'/'.(explode('-', $date)[1]-1).'/'.explode('-', $date)[0]);

        $institution            = Institution::find(1);

        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('report/stateOfResults/'.$report->id)]);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de estado de resultados');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.state_of_results', true, [
            'pdf'         => $pdf,
            'records'     => $records,
            'currency'    => $this->getCurrency(),
            'level'       => $level,
            'zero'        => $zero,
            'endDate'     => $endDate,
            'monthBefore' =>$last,
        ]);
    }

    /**
     * [pdf genera el reporte en pdf de estado de resultados]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $report [id de reporte y su informacion]
     */
    public function pdfSign($report)
    {
        $report  = AccountingReportHistory::with('currency')->find($report);
        // Validar acceso para el registro
        if (!auth()->user()->isAdmin()) {
            $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();
            if ($report && $report->queryAccess($user_profile['institution']['id'])) {
                return view('errors.403');
            }
        }
        $endDate = explode('/', $report->url)[1];
        $level   = explode('/', $report->url)[2];
        $zero    = explode('/', $report->url)[3];
        $date    = explode('-', $endDate)[0].'-'.explode('-', $endDate)[1];
        $this->setCurrency($report->currency);

        $institution_id = null;

        $is_admin = auth()->user()->isAdmin();

        if (!$is_admin && $user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        /**
         * [$level_1 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_1 = 'entryAccount.entries';

        /**
         * [$level_2 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_2 = 'children.entryAccount.entries';

        /**
         * [$level_3 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_3 = 'children.children.entryAccount.entries';

        /**
         * [$level_4 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_4 = 'children.children.children.entryAccount.entries';

        /**
         * [$level_5 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_5 = 'children.children.children.children.entryAccount.entries';

        /**
         * [$level_6 establece la consulta de ralación que se desean realizar]
         * @var string
         */
        $level_6 = 'children.children.children.children.children.entryAccount.entries';

        /**
        * Se realiza la consulta de cada cuenta y asiento que pertenezca a INGRESOS Y GASTOS
        */
        $records = AccountingAccount::with($level_1, $level_2, $level_3, $level_4, $level_5, $level_6)
            ->with([$level_1 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_2 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_3 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_4 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_5 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->with([$level_6 => function ($query) use ($endDate, $institution_id, $is_admin) {
                if ($institution_id) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true)
                        ->where('institution_id', $institution_id);
                } elseif ($is_admin) {
                    $query->where('from_date', '<=', $endDate)->where('approved', true);
                }
            }])
            ->whereBetween('group', [5, 6])
            ->where('subgroup', 0)
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')->get();

        /**
         * [$records con los registros de las cuentas]
         * @var array
         */
        $records = $this->formatDataInArray($records, $date, $endDate);

        /**
         * [$setting configuración general de la apliación]
         * @var Setting
         */
        $setting = Setting::all()->first();

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepositorySign();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $lastOfThePreviousMonth = date('d', (mktime(0, 0, 0, explode('-', $date)[1], 1, explode('-', $date)[0])-1));
        $last                   = ($lastOfThePreviousMonth.'/'.(explode('-', $date)[1]-1).'/'.explode('-', $date)[0]);

        $institution            = Institution::find(1);

        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('report/StateOfResultsSign/'.$report->id)]);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de estado de resultados');
        $pdf->setFooter();
        $sign = $pdf->setBody('accounting::pdf.state_of_results', true, [
            'pdf'         => $pdf,
            'records'     => $records,
            'currency'    => $this->getCurrency(),
            'level'       => $level,
            'zero'        => $zero,
            'endDate'     => $endDate,
            'monthBefore' => $last,
        ]);
        if($sign['status'] == 'true') {
            return response()->download($sign['file'], $sign['filename'], [], 'inline');
        }
        else {
            return response()->json(['result' => $sign['status'], 'message' => $sign['message']], 200);
        }
    }

    /**
     * [formatDataInArray sintetiza la información de una cuenta en un array con sus respectivas subcuentas]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Modules\Accounting\Models\AccountingAccount $records registro de una cuenta o subcuenta patrimonial
     * @param  int $level [contador que indica el nivel de profundidad de la recursividad
     *                       para obtener subcuentas de una cuenta]
     */
    public function formatDataInArray($records, $initD, $endD, $level = 1)
    {
        /**
         * [$parent información pertinente de la consultar]
         * @var array
         */
        $parent = [];

        /**
         * [$pos posición de la cuenta base]
         * @var integer
         */
        $pos = 0;

        /**
         * condición de parada del ultimo nivel
         */
        if ($level > 6) {
            return [];
        }

        $lastOfThePreviousMonth = date('d', (mktime(0, 0, 0, explode('-', $initD)[1], 1, explode('-', $initD)[0])-1));

        if (count($records) > 0) {
            foreach ($records as $account) {
                array_push($parent, [
                    // mes seleccionado
                    'code'         => $account->getCodeAttribute(),
                    'denomination' => $account->denomination,
                    'balance'      => $this->calculateValuesInEntries(
                        $account,
                        explode('-', $endD)[0].'-'.explode('-', $endD)[1].'-01',
                        $endD
                    ),
                    // acumulado de los meses anteriores
                    'beginningBalance' => $this->calculateValuesInEntries(
                        $account,
                        explode('-', $initD)[0].'-01-01',
                        explode('-', $endD)[0].'-'.(explode('-', $endD)[1]-1).'-'.$lastOfThePreviousMonth
                    ),
                    'level'         => $level,
                    'children'      => [],
                ]);
                $parent[$pos]['children'] = $this->formatDataInArray($account->children, $initD, $endD, $level+1);

                $pos++;
            }
            return $parent;
        }
        return [];
    }

    /**
     * [calculateValuesInEntries calculo de saldo de la cuenta tomando en cuenta todos sus subcuentas,
     *                             hasta llegar al ultimo nivel de parentela solo se sumaran los valores
     *                             de los asientos contables aprobados]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param Object $records registro de una cuenta o subcuenta patrimonial
     * @return Float resultado de realizar la operaciones de suma y resta
     */
    public function calculateValuesInEntries($account, $initD, $endD)
    {
        $initDay = (int)explode('-', $initD)[2];
        $initMonth = (int)explode('-', $initD)[1];
        $initYear = (int)explode('-', $initD)[0];

        $endDay = (int)explode('-', $endD)[2];
        $endMonth = (int)explode('-', $endD)[1];
        $endYear = (int)explode('-', $endD)[0];

        if ($initDay < 10) {
            $initDay = '0'.$initDay;
        }
        if ($initMonth < 10) {
            $initMonth = '0'.$initMonth;
        }
        if ($endDay < 10) {
            $endDay = '0'.$endDay;
        }
        if ($endMonth < 10) {
            $endMonth = '0'.$endMonth;
        }

        $initD = $initYear.'-'.$initMonth.'-'.$initDay;
        $endD  = $endYear.'-'.$endMonth.'-'.$endDay;

        /**
         * [$debit saldo total en el debe de la cuenta]
         * @var float
         */
        $debit = 0;

        /**
         * [$assets saldo total en el haber de la cuenta]
         * @var float
         */
        $assets = 0;

        /**
         * [$balanceChildren saldo total de la suma de los saldos de sus cuentas hijo]
         * @var float
         */
        $balanceChildren = 0;

        foreach ($account->entryAccount as $entryAccount) {
            if ($entryAccount->entries['from_date'] >= $initD && $entryAccount->entries['from_date'] <= $endD &&
                $entryAccount->entries['approved']) {
                if (!array_key_exists($entryAccount['entries']['currency']['id'], $this->getConvertions())) {
                    $this->setConvertions($this->calculateExchangeRates(
                        $this->getConvertions(),
                        $entryAccount['entries'],
                        $this->getCurrencyId()
                    ));
                }

                $debit += ($entryAccount['debit'] != 0)?
                            $this->calculateOperation(
                                $this->getConvertions(),
                                $entryAccount['entries']['currency']['id'],
                                $entryAccount['debit'],
                                $entryAccount['entries']['from_date'],
                                ($entryAccount['entries']['currency']['id'] == $this->getCurrencyId())??false
                            ):0;

                $assets += ($entryAccount['assets'] != 0)?
                            $this->calculateOperation(
                                $this->getConvertions(),
                                $entryAccount['entries']['currency']['id'],
                                $entryAccount['assets'],
                                $entryAccount['entries']['from_date'],
                                ($entryAccount['entries']['currency']['id'] == $this->getCurrencyId())??false
                            ):0;
            }
        }

        if (count($account->children) > 0) {
            foreach ($account->children as $child) {
                /**
                * llamada recursiva y acumulación
                */
                $balanceChildren += $this->calculateValuesInEntries($child, $initD, $endD);
            }
        }
        return (($debit - $assets) + $balanceChildren);
    }

    /**
     * [calculateOperation realiza la conversion de saldo]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  array   $convertions   [lista de tipos cambios para la moneda]
     * @param  integer $entry_id      [identificador del asiento]
     * @param  float   $value         [saldo del asiento]
     * @param  float   $date         [fecha del asiento]
     * @param  boolean $equalCurrency [bandera que indica si el tipo de moneda en el que esta el asiento es las misma
     *                                que la que se desea expresar]
     * @return float                  [resultdado de la operacion]
     */
    public function calculateOperation($convertions, $currency_id, $value, $date, $equalCurrency)
    {
        if ($equalCurrency) {
            return $value;
        }

        if ($currency_id && array_key_exists($currency_id, $convertions) && $convertions[$currency_id]) {
            foreach ($convertions[$currency_id] as $convertion) {
                if ($date >= $convertion['start_at'] && $date <= $convertion['end_at']) {
                    if ($convertion['operator'] == 'to') {
                        return ($value * $convertion['amount']);
                    } else {
                        return ($value / $convertion['amount']);
                    }
                }
            }
        }
        return -1;
    }

    /**
     * [calculateExchangeRates encuentra los tipos de cambio]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  array           $convertions [lista de conversiones]
     * @param  AccountingEntry $entry       [asiento contable]
     * @param  integer         $currency_id [identificador de la moneda a la cual se realizara la conversion]
     * @return array                        [lista de conversiones actualizada]
     */
    public function calculateExchangeRates($convertions, $entry, $currency_id)
    {
        $exchangeRate = ExchangeRate::where('active', true)
                            ->whereIn('to_currency_id', [$entry['currency']['id'], $currency_id])
                            ->whereIn('from_currency_id', [$entry['currency']['id'], $currency_id])
                             ->orderBy('end_at', 'DESC')->get();
        if (count($exchangeRate) != 0) {
            if (!array_key_exists($entry['currency']['id'], $convertions)) {
                $convertions[$entry['currency']['id']] = [];
                foreach ($exchangeRate as $recordExchangeRate) {
                    array_push(
                        $convertions[$entry['currency']['id']],
                        [
                            'amount'   => $recordExchangeRate->amount,
                            'operator' => ($currency_id == $recordExchangeRate->from_currency_id)?'from':'to',
                            'start_at' => $recordExchangeRate->start_at,
                            'end_at'   => $recordExchangeRate->end_at
                        ]
                    );
                }
            }
        }
        return $convertions;
    }

    public function getCheckBreak()
    {
        return $this->PageBreakTrigger;
    }
}
