<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingSeatCategory;
use Auth;
/**
 * @class AccountingSettingCategoryController
 * @brief Controlador de configuración de categorias de origen de asientos contables
 * 
 * Clase que gestiona las categorias de origen de asientos contables
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingSettingCategoryController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.setting.category.store', ['only' => ['store']]);
        $this->middleware('permission:accounting.setting.category.update', ['only' => ['update']]);
        $this->middleware('permission:accounting.setting.category.delete', ['only' => 'destroy']);
    }

    /**
     * Crea una nueva categorias de origen de asiento contable
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'acronym' => 'required|string',
        ]);
        /** @var object Objeto para almacenar la información para el nuevo registro */
        $category = new AccountingSeatCategory();

        $category->name = $request->name;
        $category->acronym = $request->acronym;
        $category->save();

        return response()->json(['records'=>AccountingSeatCategory::orderBy('name')->get(), 'message'=>'Success'],200);
    }

    /**
     * Actualiza los datos de la categoria de origen
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @param  integer $id      Identificador de la categoria de origen a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'acronym' => 'required|string',
        ]);
        /** @var Object Objeto que contine el registro de conversión a editar */
        $category = AccountingSeatCategory::find($id);

        $category->name = $request->name;
        $category->acronym = $request->acronym;
        $category->save();

        return response()->json(['records'=>AccountingSeatCategory::orderBy('name')->get(), 'message'=>'Success'],200);
    }

    /**
     * Elimina una categoria de origen de asiento contable
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $id Identificador de la categoria de origen a eliminar
     * @return Response
     */
    public function destroy($id)
    {
        $category = AccountingSeatCategory::with('accounting_seats')->find($id);
        if ($category) {
            /**
             * validar si no esta relacionada con algun asiento es permitido eliminarla
             */
            if (count($category->accounting_seats) > 0) {
                return response()->json(['error' => true, 'message' => 'El registro no se puede eliminar'],200);
            }
            $category->delete();
        }
        return response()->json(['record'=>$category, 'message'=>'Success'],200);
    }
}
