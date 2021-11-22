<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Purchase\Jobs\PurchaseManageRequirements;

use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\PurchaseRequirementItem;
use Modules\Purchase\Models\PurchaseSupplierObject;

use Modules\Purchase\Models\Department;

use Modules\Warehouse\Models\WarehouseProduct;

use App\Models\CodeSetting;

class PurchaseRequirementController extends Controller
{
	use ValidatesRequests;

	protected $supplier_objects;
	protected $currencies;

	public function __construct()
	{
		$supplier_objects = [
			['id' => '',          'text' => 'Seleccione...'],
			['id' => 'Bienes',    'text' => []],
			['id' => 'Obras',     'text' => []],
			['id' => 'Servicios', 'text' => []]
		];

		foreach (PurchaseSupplierObject::all() as $so) {
			$type = ($so->type === 'B') ? 'Bienes' : (($so->type === 'O') ? 'Obras' : 'Servicios');

			for ($i=1; $i < count($supplier_objects); $i++) {
				if ($type == $supplier_objects[$i]['id'] && is_array($supplier_objects[$i]['text'])) {
					$supplier_objects[$i]['text'][$so->id] = $so->name;
				}
			}
		}

		$this->supplier_objects = $supplier_objects;
		$this->currencies       = template_choices('App\Models\Currency', 'name', [], true);
	}

	/**
	 * Display a listing of the resource.
	 * @return Renderable
	 */
	public function index()
	{
		$requirements = PurchaseRequirement::with(
			'contratingDepartment',
			'userDepartment'
		)->orderBy('code', 'ASC')->get();

		$codeAvailable = (CodeSetting::where('table', 'purchase_requirements')->first())?true:false;


		return view(
			'purchase::requirements.index',
			[
				'requirements' => $requirements,
				'codeAvailable'=> $codeAvailable
			]
		);
	}

	/**
	 * create the form for creating a new resource.
	 * @return Renderable
	 */
	public function create()
	{
		$institutions              = template_choices('App\Models\Institution', 'name', [], true);
		$measurement_units         = template_choices('App\Models\MeasurementUnit', 'name', [], true);

		$supplier_objects = $this->supplier_objects;

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

		$date = date('Y-m-d');

		return view(
			'purchase::requirements.form', 
			[
				'supplier_objects'          => json_encode($supplier_objects),
				'date'                      => json_encode($date),
				'institutions'              => json_encode($institutions),
				'purchase_supplier_objects' => json_encode($purchase_supplier_objects),
				'measurement_units'         => json_encode($measurement_units),
			]);
	}

	/**
	 * Store a newly created resource in storage.
	 * @param  Request $request
	 * @return JsonResponse
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'description'                 => 'required|string',
			'institution_id'              => 'required|integer',
			'contracting_department_id'   => 'required|integer',
			'user_department_id'          => 'required|integer',
			'purchase_supplier_object_id' => 'required|integer'
		], [
			'description'                          => 'El campo descripcióm es obligatorio.',
			'institution_id.required'              => 'El campo institución es obligatorio.',
			'institution_id.integer'               => 'El campo institución no esta en el formato de entero.',
			'contracting_department_id.required'   => 'El campo unidad contratante es obligatorio.',
			'contracting_department_id.integer'    => 'El campo unidad contratante no esta en el formato de entero.',
			'user_department_id.required'          => 'El campo unidad usuaria es obligatorio.',
			'user_department_id.integer'           => 'El campo unidad usuaria no esta en el formato de entero.',
			'purchase_supplier_object_id.required' => 'El campo tipo es obligatorio.',
			'purchase_supplier_object_id.integer'  => 'El campo tipo no esta en el formato de entero.'
		]);

		$data = $request->all();
		$data['action'] = 'create';
		PurchaseManageRequirements::dispatch($data);
		return response()->json(['message'=>'success'], 200);
	}

	/**
	 * [generateReferenceCodeAvailable genera el código disponible]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @return string código que se asignara
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
	 * @return JsonResponse
	 */
	public function show($id)
	{
		return response()->json(['records'=> PurchaseRequirement::with(
			'contratingDepartment',
			'userDepartment',
			'purchaseSupplierObject',
			'purchaseRequirementItems.warehouseProduct.measurementUnit'
		)->find($id)], 200);
	}

	/**
	 * edit the form for editing the specified resource.
	 * @return Renderable
	 */
	public function edit($id)
	{
		$requirement_edit        = PurchaseRequirement::with(
			'contratingDepartment',
			'userDepartment',
			'purchaseRequirementItems.warehouseProduct.measurementUnit'
		)->find($id);
		$institutions            = template_choices('App\Models\Institution', 'name', [], true);
		$department_list         = template_choices('App\Models\Department', 'name', [], true);
		$measurement_units       = template_choices('App\Models\MeasurementUnit', 'name', [], true);
		
		$supplier_objects = $this->supplier_objects;

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

		$warehouses = template_choices(
			'Modules\Warehouse\Models\Warehouse',
			['name', 'measurement_unit_id'],
			[],
			true
		);

		$date = date('Y-m-d');

		return view(
			'purchase::requirements.form', 
			[
				'supplier_objects'          => json_encode($supplier_objects),
				'date'                      => json_encode($date),
				'institutions'              => json_encode($institutions),
				'department_list'           => json_encode($department_list),
				'purchase_supplier_objects' => json_encode($purchase_supplier_objects),
				'measurement_units'         => json_encode($measurement_units),
				'requirement_edit'          => $requirement_edit,
			]);
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return JsonResponse
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'description'               => 'required|string',
			'institution_id'            => 'required|integer',
			'contracting_department_id' => 'required|integer',
			'user_department_id'        => 'required|integer',
			'purchase_supplier_object_id' => 'required|integer'
		], [
			'description'                        => 'El campo descripcióm es obligatorio.',
			'institution_id.required'            => 'El campo institución es obligatorio.',
			'institution_id.integer'             => 'El campo institución no esta en el formato de entero.',
			'contracting_department_id.required' => 'El campo unidad contratante es obligatorio.',
			'contracting_department_id.integer'  => 'El campo unidad contratante no esta en el formato de entero.',
			'user_department_id.required'        => 'El campo unidad usuaria es obligatorio.',
			'user_department_id.integer'         => 'El campo unidad usuaria no esta en el formato de entero.',
			'purchase_supplier_object_id.required' => 'El campo tipo es obligatorio.',
			'purchase_supplier_object_id.integer'  => 'El campo tipo no esta en el formato de entero.'
		]);

		$data = $request->all();
		$data['id_edit'] = $id;
		$data['action'] = 'update';
		PurchaseManageRequirements::dispatch($data);
		return response()->json(['message'=>'success'], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 * @return JsonResponse
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

	public function getRequirementItems($id)
	{
		$items = PurchaseRequirementItem::where('purchase_requirement_id', $id)->get();
		return response()->json(['items'=>$items], 200);
	}

	public function getWarehouseProducts()
	{
		$records = [];
		foreach (WarehouseProduct::with('measurementUnit')->orderBy('id', 'ASC')->get() as $record) {
			array_push($records, [
				'id' => $record->id,
				'text' => $record->name,
				'measurement_unit' => $record->measurement_unit['name']
			]);
		}
		return $records;
	}
}
