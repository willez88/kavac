<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;

class PurchaseSettingController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:purchase.setting.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:purchase.setting.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:purchase.setting.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:purchase.setting.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var object Contiene los registros de configuraciones de códigos */
        $codeSettings = CodeSetting::where('module', 'purchase')->get();
        /** @var object Contiene información sobre la configuración de código para la requisición */
        $rqCode = $codeSettings->where('table', 'purchase_requirements')->first();
        /** @var object Contiene información sobre la configuración de código para la cotización */
        $quCode = $codeSettings->where('table', 'purchase_quotions')->first();
        /** @var object Contiene información sobre la configuración de código para la acta */
        $miCode = $codeSettings->where('table', 'purchase_minutes')->first();
        /** @var object Contiene información sobre la configuración de código para la orden de compra */
        $buCode = $codeSettings->where('table', 'purchase_buy_orders')->first();
        /** @var object Contiene información sobre la configuración de código para la orden de servicio */
        $soCode = $codeSettings->where('table', 'purchase_service_orders')->first();
        /** @var object Contiene información sobre la configuración de código para el reintegro */
        $reCode = $codeSettings->where('table', 'purchase_refunds')->first();

        return view('purchase::settings', compact('rqCode', 'quCode', 'miCode', 'buCode', 'soCode', 'reCode'));
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        /** Reglas de validación para la configuración de códigos */
        $request->validate([
            'requirements_code' => [new CodeSettingRule],
            'quotions_code' => [new CodeSettingRule],
            'minutes_code' => [new CodeSettingRule],
            'buy_orders_code' => [new CodeSettingRule],
            'service_orders_code' => [new CodeSettingRule],
            'refunds_code' => [new CodeSettingRule],
        ]);

        /** @var array Arreglo con información de los campos de códigos configurados */
        $codes = $request->input();
        /** @var boolean Define el estatus verdadero para indicar que no se ha registrado información */
        $saved = false;
        
        foreach ($codes as $key => $value) {
            /** @var string Define el modelo al cual hace referencia el código */
            $model = '';

            if ($key !== '_token' && !is_null($value)) {
                list($table, $field) = explode("_", $key);
                list($prefix, $digits, $sufix) = CodeSetting::divideCode($value);

                $tableName = explode(".", $table);
                $tbName = '';
                foreach ($tableName as $tb) {
                    $tbName .= $tb . '_';
                }
                if ($key === "buy.orders_code") {
                    dd($tbName);
                }

                CodeSetting::updateOrCreate([
                    'module' => 'purchase',
                    'table' => 'purchase_' . trim($tbName, "_"),
                    'field' => $field,
                    'type' => (isset($type)) ? $type : null
                ], [
                    'format_prefix' => $prefix,
                    'format_digits' => $digits,
                    'format_year' => $sufix,
                    'model' => $model,
                ]);
                /** @var boolean Define el estatus verdadero para indicar que se ha registrado información */
                $saved = true;
            }
        }
        
        if ($saved) {
            $request->session()->flash('message', ['type' => 'store']);
        }
        
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\View\View
     */
    public function destroy()
    {
    }
}
