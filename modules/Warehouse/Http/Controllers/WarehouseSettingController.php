<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use App\Models\Setting;

class WarehouseSettingController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:warehouse.setting', ['only' => 'index']);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $model_setting = Setting::where('active', true)->first();
        $header = [
            'route' => 'warehouse.setting.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];

        return view('warehouse::settings', compact('model_setting', 'header'));
    }

    public function store(Request $request)
    {
        $setting = Setting::updateOrCreate(
            ['active' => true],
            [
                'multi_warehouse' => ($request->multi_warehouse!==null),
            ]
        );
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('warehouse.setting.index');
    }

    public function vueSetting()
    {
        $setting = Setting::where('active',true)->first();

        return response()->json(['record' => $setting], 200);
    }


}
