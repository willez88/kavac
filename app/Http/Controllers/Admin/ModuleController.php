<?php

/** Controladores de uso exclusivo para usuarios administradores */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Module;

class ModuleController extends Controller
{
    /**
     * Muestra un listado de todos los módulos disponibles
     *
     * @method     index()
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     \Illuminate\Contracts\View\View           Devuelve la vista que muestra información de los módulos
     */
    public function index()
    {
        $modules = Module::all();

        $listModules = [];
        foreach ($modules as $module) {
            $requirements = [];
            if (count($module->getRequires()) > 0) {
                foreach ($module->getRequires() as $modName => $version) {
                    array_push($requirements, ['module' => $modName, 'versión' => $version]);
                }
            }

            $authors = [];
            if (!is_null($module->get('authors')) && count($module->get('authors')) > 0) {
                foreach ($module->get('authors') as $author) {
                    array_push($authors, ['name' => $author['name'], 'emails' => $author['email']]);
                }
            }

            array_push($listModules, [
                'alias' => $module->get('alias'),
                'name' => $module->get('name_es') ?? $module->getName(),
                'icon' => $module->icon["name"] ?? "fa fa-cubes",
                'logo' => ($module->get('logo'))
                          ? "assets/" . $module->get('name') . "/images/" . $module->get('logo')
                          : "images/default-avatar.png",
                'description' => $module->getDescription(),
                'requirements' => $requirements,
                'authors' => $authors
            ]);
        }

        return view('admin.setting-modules', compact('modules', 'listModules'));
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
     * @return     \Illuminate\Http\JsonResponse           Devuelve un JSON con el estatus de la instrucción a ejecutar
     */
    public function enable(Request $request)
    {
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
     * @return     \Illuminate\Http\JsonResponse           Devuelve un JSON con el estatus de la instrucción a ejecutar
     */
    public function disable(Request $request)
    {
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
     * @return     \Illuminate\Http\JsonResponse           Devuelve un JSON con los detalles del módulo
     */
    public function getDetails(Request $request)
    {
        $module = Module::findOrFail($request->module);

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
