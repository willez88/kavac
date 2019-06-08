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
     * Define la configuración de la clase
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.setting.index', ['only' => 'index']);
    }

    /**
     * Muestra la vista la configuración del modulo
     * @return view
     */
    public function index()
    {
        /** @var object Objeto en el que se almacenan los registro de las categorias de asientos contables */
        $categories = AccountingSeatCategory::orderBy('name','ASC')->get();

        /** @var object Objeto en el que se almacenan la información de la moneda por defecto en la aplicación */
        // $currency_default = Currency::with('exchange_rate_currency_base.currency')->where('default',true)->first();
        // $currencies = [];

        // foreach (Currency::where('default',false)->orderBy('name','ASC')->get() as $currency) {
        //     $exist = false;
        //     foreach ($currency_default->exchange_rate_currency_base as $exchange_rate) {
        //         if ($currency->id == $exchange_rate->currency_id) {
        //             $exist = true;
        //         }
        //     }
        //     if (!$exist) {
        //         $curr = new AccountingCurrencyExchangeRate();
        //         $curr->currency_id = $currency->id;
        //         $curr->currency_base_id = $currency_default->id;
        //         $curr->value = 1;
        //         $curr->date = date("Y").'-'.date("m").'-'.date("d");
        //         $curr->save();
        //     }
        // }

        // $currency_default = Currency::with('exchange_rate_currency_base.currency')->where('default',true)->first();

        return view('accounting::setting.index', compact('categories'));
        // return view('accounting::setting.index', compact('categories','currency_default'));
    }
}
