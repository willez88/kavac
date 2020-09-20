<?php

namespace Modules\TechnicalSupport\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

/**
 * @class TechnicalSupportSettingController
 * @brief Controlador de la configuración del módulo de soporte técnico
 *
 * Clase que gestiona la configuración general del módulo de soporte técnico
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TechnicalSupportSettingController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:technicalsupport.setting', ['only' => 'index']);
    }

    /**
     * Muestra el formulario de configuración del módulo de soporte técnico.
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return  Renderable
     */
    public function index()
    {
        return view('technicalsupport::settings');
    }
}
