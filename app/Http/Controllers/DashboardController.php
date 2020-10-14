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
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class DashboardController extends Controller
{
    use ModelsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
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
