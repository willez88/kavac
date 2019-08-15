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
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingSettingController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
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
        return view('accounting::setting.index');
    }
}
