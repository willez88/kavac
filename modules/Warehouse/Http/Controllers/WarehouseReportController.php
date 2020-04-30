<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Pdf\WarehouseReport as ReportRepository;
use Modules\Warehouse\Models\WarehouseInventoryProductRequest;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;
use Modules\Warehouse\Models\WarehouseInventoryProduct;
use Modules\Warehouse\Models\WarehouseInventoryRule;
use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\WarehouseReport;
use Modules\Warehouse\Models\Warehouse;
use App\Models\Institution;
use Carbon\Carbon;

/**
 * @class WarehouseReportController
 * @brief Controlador de los reportes de productos registrados en almacén
 *
 * Clase que gestiona los reportes de productos registrados en almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseReportController extends Controller
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
        //$this->middleware('permission:warehouse.report.', ['only' => 'create']);
    }

    /**
     * Muestra un listado de los reportes generados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('warehouse::reports.create');
    }

    public function requestProducts()
    {
        return view('warehouse::reports.warehouse-report-request-products');
    }

    public function stocks()
    {
        return view('warehouse::reports.warehouse-report-stocks');
    }

    public function inventoryProducts()
    {
        return view('warehouse::reports.warehouse-report-products');
    }

    public function vueList(Request $request)
    {
        if ($request->current == "inventory-products") {
            $fields = WarehouseInventoryProduct::with(
                [
                    'currency',
                    'warehouseProduct',
                    'warehouseInventoryRule',
                    'warehouseProductValues' => function ($query) {
                        $query->with('warehouseProductAttribute');
                    },
                    'warehouseInstitutionWarehouse' => function ($query) {
                        $query->with('warehouse');
                    },
                ]
            )->orderBy('warehouse_product_id');
            if ($request->warehouse_product_id > 0) {
                $fields = $fields->where(
                    'warehouse_product_id',
                    $request->warehouse_product_id
                );
            }
            if ($request->institution_id > 0) {
                $institutionsWarehouses = DB::table('warehouse_institution_warehouses')
                    ->where('institution_id', $request->institution_id)
                    ->select('id')->get()->pluck('id')->toArray();
                $fields = $fields->whereIn(
                    'warehouse_institution_warehouse_id',
                    $institutionsWarehouses
                );
            }
            if ($request->warehouse_id > 0) {
                $institutionsWarehouses = DB::table('warehouse_institution_warehouses')
                        ->where('warehouse_id', $request->warehouse_id)
                        ->select('id')->get()->pluck('id')->toArray();
                $fields = $fields->whereIn(
                    'warehouse_institution_warehouse_id',
                    $institutionsWarehouses
                );
            }
            if ($request->type_search == "date") {
                if (!is_null($request->start_date)) {
                    if (!is_null($request->end_date)) {
                        $fields = $fields->whereBetween(
                            "created_at",
                            [
                                $request->start_date,
                                $request->end_date
                            ]
                        );
                    } else {
                        $fields = $fields->whereBetween(
                            "created_at",
                            [
                                $request->start_date,
                                now()
                            ]
                        );
                    }
                }
            }
            if ($request->type_search == "mes") {
                if (!is_null($request->mes_id)) {
                    if (!is_null($request->year)) {
                        $fields = $fields->whereMonth(
                            'created_at',
                            $request->mes_id
                        )->whereYear('created_at', $request->year);
                    } else {
                        $fields = $fields->whereMonth(
                            'created_at',
                            $request->mes_id
                        );
                    }
                }
            }
        } elseif ($request->current == "request-products") {
            $fields = WarehouseInventoryProductRequest::with(
                [
                    'warehouseInventoryProduct' => function ($query) {
                        $query->with(
                            [
                                'currency',
                                'warehouseProduct',
                                'warehouseInventoryRule',
                                'warehouseProductValues' => function ($query) {
                                    $query->with('warehouseProductAttribute');
                                },
                                'warehouseInstitutionWarehouse' => function ($query) {
                                    $query->with('warehouse');
                                },
                            ]
                        );
                    },
                    'warehouseRequest' => function ($query) {
                        $query->with(
                            'institution',
                            'department',
                            'budgetSpecificAction'
                        );
                    }
                ]
            );
            /*
            Revisar filtros
                whereHas
            */
        } elseif ($request->current == "stocks") {
            $fields = WarehouseInventoryRule::with(
                [
                    'warehouseInventoryProduct' => function ($query) {
                        $query->with('WarehouseProduct');
                    }
                ]
            );
        }
        return response()->json(['records' => $fields->get()], 200);
    }

    public function create(Request $request)
    {
        if ($request->current == "inventory-products") {
            $fields = WarehouseInventoryProduct::with(
                [
                    'currency',
                    'warehouseProduct',
                    'warehouseInventoryRule',
                    'warehouseProductValues' => function ($query) {
                        $query->with('warehouseProductAttribute');
                    },
                    'warehouseInstitutionWarehouse' => function ($query) {
                        $query->with('warehouse');
                    },
                ]
            )->orderBy('warehouse_product_id');
            if ($request->warehouse_product_id > 0) {
                $fields = $fields->where(
                    'warehouse_product_id',
                    $request->warehouse_product_id
                );
            }
            if ($request->institution_id > 0) {
                $institutionsWarehouses = DB::table('warehouse_institution_warehouses')
                    ->where('institution_id', $request->institution_id)
                    ->select('id')->get()->pluck('id')->toArray();
                $fields = $fields->whereIn(
                    'warehouse_institution_warehouse_id',
                    $institutionsWarehouses
                );
            }
            if ($request->warehouse_id > 0) {
                $institutionsWarehouses = DB::table('warehouse_institution_warehouses')
                        ->where('warehouse_id', $request->warehouse_id)
                        ->select('id')->get()->pluck('id')->toArray();
                $fields = $fields->whereIn(
                    'warehouse_institution_warehouse_id',
                    $institutionsWarehouses
                );
            }
            if ($request->type_search == "date") {
                if (!is_null($request->start_date)) {
                    if (!is_null($request->end_date)) {
                        $fields = $fields->whereBetween(
                            "created_at",
                            [
                                $request->start_date,
                                $request->end_date
                            ]
                        );
                    } else {
                        $fields = $fields->whereBetween(
                            "created_at",
                            [
                                $request->start_date,
                                now()
                            ]
                        );
                    }
                }
            }
            if ($request->type_search == "mes") {
                if (!is_null($request->mes_id)) {
                    if (!is_null($request->year)) {
                        $fields = $fields->whereMonth(
                            'created_at',
                            $request->mes_id
                        )->whereYear('created_at', $request->year);
                    } else {
                        $fields = $fields->whereMonth(
                            'created_at',
                            $request->mes_id
                        );
                    }
                }
            }
        } elseif ($request->current == "request-products") {
            $fields = WarehouseInventoryProductRequest::with(
                [
                    'warehouseInventoryProduct' => function ($query) {
                        $query->with(
                            [
                                'currency',
                                'warehouseProduct',
                                'warehouseInventoryRule',
                                'warehouseProductValues' => function ($query) {
                                    $query->with('warehouseProductAttribute');
                                },
                                'warehouseInstitutionWarehouse' => function ($query) {
                                    $query->with('warehouse');
                                },
                            ]
                        );
                    },
                    'warehouseRequest' => function ($query) {
                        $query->with(
                            'institution',
                            'department',
                            'budgetSpecificAction'
                        );
                    }
                ]
            );
            /*
            Revisar filtros
                whereHas
            */
        } elseif ($request->current == "stocks") {
            $fields = WarehouseInventoryRule::with(
                [
                    'warehouseInventoryProduct' => function ($query) {
                        $query->with('WarehouseProduct');
                    }
                ]
            );
        }
        /*************************************************/
        $institution = Institution::where('default', true)
            ->where('active', true)->first();
        $pdf = new ReportRepository();
        $filename = 'warehouse-report-' . Carbon::now() . '.pdf';

        $codeSetting = CodeSetting::where('table', 'warehouse_reports')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('warehouse.setting.index')], 200);
        }

        $code = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );
        
        $report = WarehouseReport::create([
            'code'           => $code,
            'type_report'    => $request->current,
            'institution_id' => $institution->id,
            'filename'       => $filename
        ]);
        
        /*
         *  Definicion de las caracteristicas generales de la página
         */
        $body = ($report->type_report == 'stocks')
                    ? 'warehouse::pdf.warehouse-report-stocks'
                    : 'warehouse::pdf.warehouse-report-product';
        $pdf->setConfig(
            [
                'institution' => $institution,
                'urlVerify'   => 'www.google.com',
                'orientation' => 'L',
                'filename'    => $filename
            ]
        );

        $pdf->setHeader("Reporte de Almacén");
        $pdf->setFooter();
        $pdf->setBody(
            $body,
            true,
            [
                'pdf'    => $pdf,
                'fields' => $fields
            ]
        );
        $url = '/warehouse/report/show/' . $filename;
        return response()->json(['result' => true, $redirect => $url], 200);
    }

    public function show($code)
    {
        $report = WarehouseReport::where('code', $code)->first();
        $pdf = new ReportRepository();
        $pdf->show($report->filename);
    }
}
