<?php

/** Revisar */
namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Jobs\AssetGenerateReport;

use Modules\Asset\Models\AssetReport;
use App\Models\CodeSetting;

/**
 * @class      AssetReportController
 * @brief      Controlador de los reportes generados en el módulo de bienes
 *
 * Clase que gestiona los reportes generados en el módulo de bienes
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class AssetReportController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.report.create', ['only' => 'create']);
    }

    /**
     * Muestra un listado de las solicitudes de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @return    Renderable
     */
    public function index()
    {
        return view('asset::reports.create');
    }

    /**
     * Valida y registra un nuevo reporte de bienes institucionales
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     \Illuminate\Http\Request         $request    Datos de la petición
     * @return    \Illuminate\Http\JsonResponse    Objeto con los registros a mostrar
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'type_report' => ['required']
        ]);

        $codeSetting = CodeSetting::where('table', 'asset_reports')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('asset.setting.index')], 200);
        }

        $code = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );

        /**
         * Objeto asociado al modelo AssetReport
         *
         * @var Object $report
         */
        $report = AssetReport::create([
            'code'                       => $code,
            'type_report'                => $request->input('type_report'),
            'type_search'                => $request->input('type_search'),

            'asset_status_id'            => $request->input('asset_status_id'),
            'asset_type_id'              => $request->input('asset_type_id'),
            'asset_category_id'          => $request->input('asset_category_id'),
            'asset_subcategory_id'       => $request->input('asset_subcategory_id'),
            'asset_specific_category_id' => $request->input('asset_specific_category_id'),

            'institution_id'             => $request->input('institution_id'),
            'department_id'              => $request->input('department_id'),
            'mes'                        => $request->input('mes_id'),
            'year'                       => $request->input('year'),
            'start_date'                 => $request->input('start_date'),
            'end_date'                   => $request->input('end_date'),
        ]);
        if ($request->input('operation') == 'open') {
            /**
             * Si selecciona la opción (abrir documento)
             *
             * Special Requirements: Abrir documento al finalizar
             */
        } elseif ($request->input('operation') == 'download') {
            /**
             * Si selecciona la opción (descargar documento)
             *
             * Special Requirements: Forzar descarga del documento
             */
        };

        if (is_null($report)) {
            $message = [
                'type'  => 'other',
                'title' => 'Alerta',
                'icon'  => 'screen-error',
                'class' => 'growl-danger',
                'text'  => 'No se pudo completar la operación'
            ];
            return response()->json(['result' => false, 'message' => $message], 200);
        } else {
            $body = ($report->type_report == 'general')
                    ? 'asset::pdf.asset_general'
                    : 'asset::pdf.asset_detallado';
            AssetGenerateReport::dispatch($report, $body);
            return response()->json(['result' => true], 200);
        }
    }

    /**
     * Obtiene la información de un reporte registrado
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     * @param     String    $code_report    Identificador único del reporte
     * @return    void
     */
    public function show($code_report)
    {
        $report = AssetReport::where('code', $code_report)->with('document')->first();
        $pdf    = new ReportRepository();
        $pdf->show($report->document->file);
    }
}
