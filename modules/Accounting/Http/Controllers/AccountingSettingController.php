<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Models\AccountingSeatCategory;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\AccountingCurrencyExchangeRate;
use Auth;
/**
 * @class AccountingConfigurationCategoryController
 * @brief Controlador de categorias de origen para sientos contables
 * 
 * Clase que gestiona las categorias para asientos contables
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $categories = AccountingSeatCategory::orderBy('name','ASC')->get();
        $currency_default = Currency::with('exchange_rate_currency_base.currency')->where('default',true)->first();
        $currencies = [];

        foreach (Currency::where('default',false)->orderBy('name','ASC')->get() as $currency) {
            $exist = false;
            foreach ($currency_default->exchange_rate_currency_base as $exchange_rate) {
                if ($currency->id == $exchange_rate->currency_id) {
                    $exist = true;
                }
            }
            if (!$exist) {
                $curr = new AccountingCurrencyExchangeRate();
                $curr->currency_id = $currency->id;
                $curr->currency_base_id = $currency_default->id;
                $curr->value = 1;
                $curr->date = date("Y").'-'.date("m").'-'.date("d");
                $curr->save();
            }
        }

        $currency_default = Currency::with('exchange_rate_currency_base.currency')->where('default',true)->first();

        return view('accounting::setting.index', compact('categories','currency_default'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('accounting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
