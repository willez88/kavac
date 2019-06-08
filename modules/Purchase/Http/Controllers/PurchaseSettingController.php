<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\CodeSetting;

class PurchaseSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
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
     * @return Response
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
