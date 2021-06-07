<?php
/** [descripción del namespace] */
namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Sale\Models\PeriodicCostAttribute;

/**
 * @class PeriodicCostAttributeController
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PeriodicCostAttributeController extends Controller
{
    /**
     * [descripción del método]
     *
     * @method    index
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function index()
    {
        return response()->json(['records' => []], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    create
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function create()
    {
        return view('sale::create');
    }

    /**
     * [descripción del método]
     *
     * @method    store
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     object    Request    $request    Objeto con información de la petición
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'sale_type_good_id' => ['required'],
        ]);

        $id = $request->input('periodic_cost_id');

        $attribute = PeriodicCostAttribute::create([
            'name' => $request->input('name'),
            'sale_type_good_id' => $request->input('periodic_cost_id'),
        ]);

        return response()->json(['records' => PeriodicCostAttribute::where('periodic_cost_id', '=', $id)->get()], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    show
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * [descripción del método]
     *
     * @method    edit
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function edit($id)
    {
        return view('sale::edit');
    }

    /**
     * [descripción del método]
     *
     * @method    update
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     object    Request    $request         Objeto con datos de la petición
     * @param     integer   $id        Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'sale_type_good_id' => ['required'],
        ]);

        $id = $request->input('periodic_cost_id');

        $attribute = PeriodicCostAttribute::create([
            'name' => $request->input('name'),
            'periodic_cost_id' => $request->input('periodic_cost_id'),
        ]);

        return response()->json(['records' => PeriodicCostAttribute::where('periodic_cost_id', '=', $id)->get()], 200);
    }

    /**
     * [descripción del método]
     *
     * @method    destroy
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function destroy(PeriodicCostAttribute $attribute)
    {
        $attribute->delete();
        return response()->json(['record' => $attribute, 'message' => 'Success'], 200);
    }
}
