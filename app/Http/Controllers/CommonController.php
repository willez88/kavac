<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * @class CommonController
 * @brief Gestiona información de común de la aplicación
 *
 * Controlador para gestionar datos comúnes en la aplicación
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CommonController extends Controller
{
    /**
     * Obtiene Datos de modelos relacionados
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request $request      Datos de la petición
     * @param  string                   $parent_model Nombre del modelo padre
     * @param  integer                  $parent_id    Identificador del elemento relacionado
     * @param  string                   $model        Nombre del modelo
     * @param  string                   $module_name  Nombre del módulo
     * @param  string                   $fk           Clave foránea
     * @return \Illuminate\Http\JsonResponse Datos con los registros relacionados
     */
    public function getSelectData(Request $request, $parent_model, $parent_id, $model, $module_name = null, $fk = null)
    {
        $model_name = ($model == 'User')
                      ? "App\\Models\\{$model}"
                      : ((!is_null($module_name))?"Modules\\{$module_name}":'App') . "\\Models\\{$model}";

        $fk = (is_null($fk))
              ? ((strpos($parent_model, '_id') === false)
              ? strtolower($parent_model) . '_id'
              : $parent_model)
              : $fk;

        return response()->json([
            'result' => true, 'records' => $model_name::where($fk, $parent_id)->orderBy('name')->get()
        ], 200);
    }
}
