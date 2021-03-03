<?php

/** Controladores de uso exclusivo para usuarios administradores */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module;

/**
 * @class ModuleController
 * @brief Controlador para la gestión de los módulos de la aplicación
 *
 * Clase que gestiona los módulos de la aplicación
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ModuleController extends Controller
{
    /**
     * Muestra un listado de todos los módulos disponibles
     *
     * @method     index()
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     View           Devuelve la vista que muestra información de los módulos
     */
    public function index()
    {
        $listModules = info_modules();

        return view('admin.setting-modules', compact('listModules'));
    }

    /**
     * Habilita el módulo seleccionado por el usuario
     *
     * @method     enable(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request          $request    Objeto con información de la petición solicitada
     *
     * @return     JsonResponse           Devuelve un JSON con el estatus de la instrucción a ejecutar
     */
    public function enable(Request $request)
    {
        /** @var Module Objeto con información de un módulo */
        $module = Module::findOrFail($request->module);
        $module->enable();

        return response()->json(['result' => true], 200);
    }

    /**
     * Deshabilita el módulo seleccionado por el usuario
     *
     * @method     disable(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request          $request    Objeto con información de la petición solicitada
     *
     * @return     JsonResponse           Devuelve un JSON con el estatus de la instrucción a ejecutar
     */
    public function disable(Request $request)
    {
        /** @var Module Objeto con información de un módulo */
        $module = Module::findOrFail($request->module);
        $module->disable();

        return response()->json(['result' => true], 200);
    }

    /**
     * Obtiene los detalles de un módulo seleccionado
     *
     * @method     getDetails(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request          $request    [description]
     *
     * @return     JsonResponse           Devuelve un JSON con los detalles del módulo
     */
    public function getDetails(Request $request)
    {
        /** @var Module Objeto con información de un módulo */
        $module = Module::findOrFail($request->module);

        /** @var array Arreglo con detalles del módulo */
        $details = [
            'version' => $module->get("version") ?? "0",
            'name' => $module->get("name_es") ?? $module->getName(),
            'description' => $module->getDescription() ?? 'N/A',
            'icon' => '',
            'logo' => ($module->get('logo'))
                      ? "assets/" . $module->get('name') . "/images/" . $module->get('logo')
                      : "images/default-avatar.png",
            'status' => '', //Instalado o desinstalado
            'link' => '',
            'authors' => $module->get('authors') ?? [],
            'requirements' => $module->getRequires() ?? [],
            'enabled' => $module->isEnabled()
        ];

        return response()->json(['result' => true, 'details' => $details], 200);
    }
}
