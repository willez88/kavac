<?php

/** Controladores de uso exclusivo para usuarios administradores */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

/**
 * @class LogController
 * @brief Controlador de Eventos Log
 *
 * Clase que gestiona los eventos de log
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class LogController extends Controller
{
    /**
     * Método que genera eventos logs a partir de errores ocasionados en el FrontEnd
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function frontEnd(Request $request)
    {
        /** @var string Vista que genera el error */
        $view = $request->v;
        /** @var integer Línea que genera el error */
        $line = $request->l;
        /** @var string Mensaje o descripción del evento de error generado */
        $log  = $request->lg;
        /** @var string Nombre de la función que generó el log. Esta variable es opcional */
        $function = (isset($request->f)) ? " en la función [{$request->f}]" : '';
        Log::channel('front_end')->error("Error generado por la vista [{$view}] en la línea [$line]$function: {$log}");

        return response()->json(['result' => true], 200);
    }
}
