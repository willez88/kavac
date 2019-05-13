<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingSeatCategory;
use Auth;
/**
 * @class AccountingConfigurationCategoryController
 * @brief Controlador de categorias de origen para sientos contables
 * 
 * Clase que gestiona las categorias para asientos contables
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingConfigurationCategoryController extends Controller
{
    /**
     * Muestra un listado de categorias de origen
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @return view
     */
    public function index()
    {
        $categories = AccountingSeatCategory::orderBy('name')->get();
        return view('accounting::configuration.index', compact('categories'));
    }

    /**
     * Formulario para la creacion de categorias
     * @return Response
     */
    public function create()
    {
        // return view('accounting::create');
    }

    /**
     * Crea una nueva categorias de origen de asiento contable
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
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
     * Muestra información de las categorias
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @return Response
     */
    public function show($id)
    {
        // return view('accounting::show');
    }

    /**
     * Muestra el formulario para la edición de categorias de origen de asientos contables
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @param  integer $id Identificador de la cuenta patrimonial a modificar
     * @return Response
     */
    public function edit($id)
    {
        // return view('accounting::edit');
    }

    /**
     * Actualiza los datos de la categoria de origen
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
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
     * @author Juan Rosas <JuanFBass17@gmail.com>
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
