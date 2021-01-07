<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

/**
 * @class ProfileController
 * @brief Gestiona información de Perfiles de usuario
 *
 * Controlador para gestionar Perfiles de usuario
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ProfileController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    /**
     * Registra un nuevo perfil de usuario
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     *
     * @return    JsonResponse          JSON con el resultado del registro
     */
    public function store(Request $request)
    {
        Profile::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name ?? null,
                'image_id' => $request->image_id ?? null,
            ]
        );
        return response()->json(['result' => true], 200);
    }
}
