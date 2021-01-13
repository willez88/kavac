<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Traits\ModelsTrait;

/**
 * @class DashboardController
 * @brief Gestiona información del Panel de Control
 *
 * Controlador para gestionar el Panel de Control
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class DashboardController extends Controller
{
    use ModelsTrait;

    /**
     * Muestra la vista del panel de control
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    View    Devuelve la vista principal del panel de control si el usuario esta autenticado,
     *                    de lo contrario muestra la vista de acceso a la aplicación
     */
    public function index()
    {
        if (auth()->check()) {
            /** Si el usuario esta autenticado redirecciona a la página del panel de control */
            return view('dashboard.index');
        } else {
            /** Si el usuario no está autenticado muestra la página de acceso */
            return view('auth.login');
        }
    }
}
