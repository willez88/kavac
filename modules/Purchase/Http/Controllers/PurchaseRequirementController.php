<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Purchase\Jobs\PurchaseManageRequirements;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\PurchaseRequirementItem;
use Modules\Purchase\Models\PurchaseSupplierType;

use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\Warehouse;

use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;
use App\Models\FiscalYear;
use App\Models\MeasurementUnit;
use Auth;

class PurchaseRequirementController extends Controller
{
    use ValidatesRequests;

    protected $supplier_objects;
    protected $fiscal_years;

    public function __construct()
    {
        $supplier_objects = [
            ['id' => '',          'text' => 'Seleccione...'],
            ['id' => 'Bienes',    'text' => []],
            ['id' => 'Obras',     'text' => []],
            ['id' => 'Servicios', 'text' => []]
        ];

        foreach (PurchaseSupplierType::all() as $so) {
            $type = ($so->type === 'B') ? 'Bienes' : (($so->type === 'O') ? 'Obras' : 'Servicios');

            for ($i=1; $i < count($supplier_objects); $i++) {
                if ($type == $supplier_objects[$i]['id'] && is_array($supplier_objects[$i]['text'])) {
                    $supplier_objects[$i]['text'][$so->id] = $so->name;
                }
            }
        }

        $this->supplier_objects = $supplier_objects;
        $this->fiscal_years     = FiscalYear::where('active', true)->first();
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $requirements = PurchaseRequirement::with(
            'contratingDepartment',
            'userDepartment',
            'purchaseSupplierType',
            'fiscalYear'
        )->orderBy('code', 'ASC')->get();
        return view('purchase::requirements.index', ['requirements' => $requirements]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $currency                = template_choices('App\Models\Currency', 'name', [], true);
        $institutions            = template_choices('App\Models\Institution', 'name', [], true);
        $measurement_units       = template_choices('App\Models\MeasurementUnit', 'name', [], true);
        $purchase_supplier_types = template_choices('Modules\Purchase\Models\PurchaseSupplierType', 'name', [], true);
        $warehouses              = template_choices('Modules\Warehouse\Models\Warehouse', 'name', [], true);

        $supplier_objects = $this->supplier_objects;
        $acc = [
            ['id' => '',          'text' => 'Seleccione...'],
            ['id' => 'Bienes',    'text' => 'producto 1'],
            ['id' => 'Obras',     'text' => 'producto 2'],
            ['id' => 'Servicios', 'text' => 'producto 3']
        ];
        $department = [
            ['id' => '',           'text' => 'Seleccione...'],
            ['id' => 'warehouse',  'text' => 'Almacen'],
            ['id' => 'accounting', 'text' => 'Contabilidad'],
        ];

        $date = date('d-m-Y');
        
        return view('purchase::requirements.form', [
                                                    'supplier_objects'        => json_encode($supplier_objects),
                                                    'date'                    => json_encode($date),
                                                    'institutions'            => json_encode($institutions),
                                                    'purchase_supplier_types' => json_encode($purchase_supplier_types),
                                                    'measurement_units'       => json_encode($measurement_units),
                                                    'fiscal_years'            => $this->fiscal_years,
                                                ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description'               => 'required|string',
            'institution_id'            => 'required|integer',
            'contracting_department_id' => 'required|integer',
            'user_department_id'        => 'required|integer',
            'purchase_supplier_type_id' => 'required|integer'
        ], [
            'description'                        => 'El campo descripcióm es obligatorio.',
            'institution_id.required'            => 'El campo institución es obligatorio.',
            'institution_id.integer'             => 'El campo institución no esta en el formato de entero.',
            'contracting_department_id.required' => 'El campo unidad contratante es obligatorio.',
            'contracting_department_id.integer'  => 'El campo unidad contratante no esta en el formato de entero.',
            'user_department_id.required'        => 'El campo unidad usuaria es obligatorio.',
            'user_department_id.integer'         => 'El campo unidad usuaria no esta en el formato de entero.',
            'purchase_supplier_type_id.required' => 'El campo tipo es obligatorio.',
            'purchase_supplier_type_id.integer'  => 'El campo tipo no esta en el formato de entero.'
        ]);

        PurchaseManageRequirements::dispatch($request->all());
        return response()->json(['message'=>'success'], 200);
    }

    /**
     * [generateReferenceCodeAvailable genera el código disponible]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return string [código que se asignara]
     */
    public function generateReferenceCodeAvailable()
    {
        $institution = $this->getInstitution();
        $codeSetting = CodeSetting::where('table', $institution->id.'_'.$institution->acronym.'_accounting_entries')
                                    ->first();

        if (!$codeSetting) {
            $codeSetting = CodeSetting::where('table', 'accounting_entries')
                                    ->first();
        }

        if ($codeSetting) {
            $code  = generate_registration_code(
                $codeSetting->format_prefix,
                strlen($codeSetting->format_digits),
                (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                AccountingEntry::class,
                $codeSetting->field
            );
        } else {
            $code = 'error al generar código de referencia';
        }

        return $code;
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $requirement_edit        = PurchaseRequirement::with('purchaseRequirementItems', 'fiscalYear')->find($id);
        $institutions            = template_choices('App\Models\Institution', 'name', [], true);
        $department_list         = template_choices('App\Models\Department', 'name', [], true);
        $measurement_units       = template_choices('App\Models\MeasurementUnit', 'name', [], true);
        $purchase_supplier_types = template_choices('Modules\Purchase\Models\PurchaseSupplierType', 'name', [], true);
        $warehouses              = template_choices('Modules\Warehouse\Models\Warehouse', 'name', [], true);


        $supplier_objects = $this->supplier_objects;
        $acc = [
            ['id' => '',          'text' => 'Seleccione...'],
            ['id' => 'Bienes',    'text' => 'producto 1'],
            ['id' => 'Obras',     'text' => 'producto 2'],
            ['id' => 'Servicios', 'text' => 'producto 3']
        ];
        $department = [
            ['id' => '',           'text' => 'Seleccione...'],
            ['id' => 'warehouse',  'text' => 'Almacen'],
            ['id' => 'accounting', 'text' => 'Contabilidad'],
        ];


        
        $date = date('d-m-Y');
        
        return view('purchase::requirements.form', [
                                                    'supplier_objects'        => json_encode($supplier_objects),
                                                    'date'                    => json_encode($date),
                                                    'institutions'            => json_encode($institutions),
                                                    'department_list'         => json_encode($department_list),
                                                    'purchase_supplier_types' => json_encode($purchase_supplier_types),
                                                    'measurement_units'       => json_encode($measurement_units),
                                                    'requirement_edit'        => $requirement_edit,
                                                    'fiscal_years'            => $this->fiscal_years,
                                                ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'description'               => 'required|string',
            'institution_id'            => 'required|integer',
            'contracting_department_id' => 'required|integer',
            'user_department_id'        => 'required|integer',
            'purchase_supplier_type_id' => 'required|integer'
        ], [
            'description'                        => 'El campo descripcióm es obligatorio.',
            'institution_id.required'            => 'El campo institución es obligatorio.',
            'institution_id.integer'             => 'El campo institución no esta en el formato de entero.',
            'contracting_department_id.required' => 'El campo unidad contratante es obligatorio.',
            'contracting_department_id.integer'  => 'El campo unidad contratante no esta en el formato de entero.',
            'user_department_id.required'        => 'El campo unidad usuaria es obligatorio.',
            'user_department_id.integer'         => 'El campo unidad usuaria no esta en el formato de entero.',
            'purchase_supplier_type_id.required' => 'El campo tipo es obligatorio.',
            'purchase_supplier_type_id.integer'  => 'El campo tipo no esta en el formato de entero.'
        ]);

        PurchaseManageRequirements::dispatch($request->all(), $id);
        return response()->json(['message'=>'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        foreach (PurchaseRequirementItem::where('purchase_requirement_id', $id)->get() as $record) {
            $record->delete();
        }
        $record = PurchaseRequirement::find($id);
        if ($record) {
            $record->delete();
        }
        return response()->json(['message'=>'success'], 200);
    }

    /**
     * [baseBudget description]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [type] [description]
     */
    public function baseBudget()
    {
        $requirements = PurchaseRequirement::with(
            'contratingDepartment',
            'userDepartment',
            'purchaseSupplierType',
            'fiscalYear',
            'purchaseRequirementItems.measurementUnit'
        )->where('requirement_status', 'WAIT')->orderBy('code', 'ASC')->get();
        return view('purchase::requirements.base_budget', ['requirements' => $requirements]);
    }

    public function getRequirementItems($id)
    {
        $items = PurchaseRequirementItem::where('purchase_requirement_id', $id)->get();
        return response()->json(['items'=>$items], 200);
    }
}
