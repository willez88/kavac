<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\InstitutionSector;
use Illuminate\Http\Request;

/**
 * @class InstitutionSectorController
 * @brief Gestiona información de los sectores de Instituciones
 *
 * Controlador para gestionar sectores de Instituciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class InstitutionSectorController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:institution.sector.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:institution.sector.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:institution.sector.delete', ['only' => 'destroy']);
        $this->middleware('permission:institution.sector.list', ['only' => 'index']);
    }

    /**
     * Muesta todos los registros de los sectores de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => InstitutionSector::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra un nuevo sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
        ]);


        $institutionSector = InstitutionSector::create([
            'name' => $request->name
        ]);

        return response()->json(['record' => $institutionSector, 'message' => 'Success'], 200);
    }

    /**
     * Muestra información acerca del sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function show(InstitutionSector $institutionSector)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de un sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\Response
     */
    public function edit(InstitutionSector $institutionSector)
    {
        //
    }

    /**
     * Actualiza la información del sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, InstitutionSector $institutionSector)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
        ]);

        $institutionSector->name = $request->name;
        $institutionSector->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Elimina el sector de institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \App\Models\InstitutionSector  $institutionSector
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(InstitutionSector $institutionSector)
    {
        $institutionSector->delete();
        return response()->json(['record' => $institutionSector, 'message' => 'Success'], 200);
    }
}
