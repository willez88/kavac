<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

/**
 * @class DepartmentController
 * @brief Gestiona información de Departamentos
 *
 * Controlador para gestionar Departamentos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class DepartmentController extends Controller
{
    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        $this->data[0] = [
            'id' => '',
            'text' => 'Seleccione...'
        ];
    }

    /**
     * Listado con todos los departamentos registrados
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    JsonResponse     JSON con información de respuesta a la petición
     */
    public function index()
    {
        return response()->json(['records' => Department::with(['parent', 'childrens'])->get()], 200);
    }

    /**
     * Registra un nuevo departamento
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     *
     * @return    JsonResponse     JSON con información de respuesta a la petición
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'institution_id' => ['required']
        ]);

        /** @var integer Establece la jerarquía del departamento */
        $hierarchy = 0;

        if (!is_null($request->parent_id) || !empty($request->parent_id)) {
            /** @var Department Departamento asociado */
            $dto = Department::where('parent_id', $request->parent_id)->first();
            if ($dto) {
                $hierarchy = (integer)$dto->hierarchy + 1;
            }
        }

        /** @var Department Objeto con información del departamento registrado */
        $department = Department::create([
            'name' => $request->name,
            'acronym' => ($request->acronym)?$request->acronym:null,
            'hierarchy' => $hierarchy,
            'issue_requests' => $request->issue_requests ?? false,
            'active' => $request->active ?? false,
            'administrative' => $request->administrative ?? false,
            'parent_id' => ($request->parent_id)?$request->parent_id:null,
            'institution_id' => $request->institution_id
        ]);

        return response()->json(['record' => $department, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza los datos de un departamento
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request       $request       Objeto con datos de la petición
     * @param     Department    $department    Objeto con información del departamento a modificar
     *
     * @return    JsonResponse     JSON con información de respuesta a la petición
     */
    public function update(Request $request, Department $department)
    {
        $this->validate($request, [
            'name' => ['required'],
            'institution_id' => ['required']
        ]);

        $hierarchy = 0;

        if (!is_null($request->parent_id) || !empty($request->parent_id)) {
            $dto = Department::where('parent_id', $request->parent_id)->first();
            if ($dto) {
                $hierarchy = (integer)$dto->hierarchy + 1;
            }
        }

        $department->name = $request->name;
        $department->acronym = ($request->acronym)?$request->acronym:null;
        $department->hierarchy = (string)$hierarchy;
        $department->issue_requests = $request->issue_requests ?? false;
        $department->active = $request->active ?? false;
        $department->administrative = $request->administrative ?? false;
        $department->parent_id = ($request->parent_id)?$request->parent_id:null;
        $department->institution_id = $request->institution_id;
        $department->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina un departamento
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Department    $department    Objeto con información del departamento a eliminar
     *
     * @return    JsonResponse     JSON con información de respuesta a la petición
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return response()->json(['record' => $department, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene un listado de departamentos
     *
     * @method getDepartments
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request        Objeto con los datos de la petición
     * @param  integer  $institution_id Identificador de la organización
     *
     * @return JsonResponse     JSON con información de respuesta a la petición
     */
    public function getDepartments(Request $request, $institution_id)
    {
        return response()->json(
            template_choices(Department::class, 'name', ['institution_id' => $institution_id], true)
        );
    }
}
