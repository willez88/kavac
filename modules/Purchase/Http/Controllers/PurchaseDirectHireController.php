<?php
/** [descripción del namespace] */
namespace Modules\Purchase\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Purchase\Models\HistoryTax;
use Modules\Purchase\Models\TaxUnit;
use Modules\Purchase\Models\Department;

use Modules\Purchase\Models\PurchaseOrder;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\PurchasePivotModelsToRequirementItem;
use Modules\Purchase\Models\PurchaseSupplierObject;


/**
 * @class PurchaseDirectHireController
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PurchaseDirectHireController extends Controller
{
    use ValidatesRequests;
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
        return view('purchase::purchase_order.index', [
            'records' => PurchaseOrder::with('purchaseSupplier', 'currency', 'relatable')->orderBy('id', 'ASC')->get(),
        ]);
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
        $suppliers       = template_choices('Modules\Purchase\Models\PurchaseSupplier', ['rif','-', 'name'], [], true);

        $currencies      = template_choices('Modules\Purchase\Models\Currency', ['name'], [], true);

        $department_list = template_choices('App\Models\Department', 'name', [], true);

        $historyTax = HistoryTax::with('tax')->whereHas('tax', function ($query) {
            $query->where('active', true);
        })->where('operation_date', '<=', date('Y-m-d'))->orderBy('operation_date', 'DESC')->first();

        $taxUnit    = TaxUnit::where('active', true)->first();

        $purchase_supplier_objects = [];
        
        array_push($purchase_supplier_objects, 
            [
                'id' => '',
                'text' => 'Seleccione...',
            ],
        );

        foreach (PurchaseSupplierObject::all() as $record) {
            $type = $record->type;
            if ($type == 'B') {
                $type = 'Bienes';
            }else if ($type == 'O') {
                $type = 'Obras';
            }else if ($type == 'S') {
                $type = 'Servivios';
            }
            array_push($purchase_supplier_objects, 
                [
                    'id' => $record->id,
                    'text' => $type.' - '.$record->name,
                ],
            );
        }

        $requirements = PurchaseRequirement::with(
            'contratingDepartment',
            'userDepartment',
            'purchaseRequirementItems.warehouseProduct.measurementUnit',
            'purchaseBaseBudget.currency'
        )->where('requirement_status', 'PROCESSED')
        ->orderBy('id', 'ASC')->get();
        return view('purchase::purchase_order.direct_hire_form', [
            'requirements'    => $requirements,
            'currencies'                => json_encode($currencies),
            'tax'                       => json_encode($historyTax),
            'tax_unit'                  => json_encode($taxUnit),
            'department_list'           => json_encode($department_list),
            'purchase_supplier_objects' => json_encode($purchase_supplier_objects),
            'suppliers'                 => json_encode($suppliers),
        ]);
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
        //
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
        return view('purchase::show');
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
        return view('purchase::edit');
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
        //
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
    public function destroy($id)
    {
        //
    }
}
