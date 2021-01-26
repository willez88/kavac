<?php

namespace Modules\Purchase\Http\Controllers;

use App\Models\CodeSetting;

use App\Repositories\UploadDocRepository;

use Illuminate\Http\Request;

use Illuminate\Contracts\Support\Renderable;

use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Purchase\Models\PurchaseQuotation;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\PurchaseBaseBudget;
use Modules\Purchase\Models\PurchasePivotModelsToRequirementItem;
use Modules\Purchase\Models\Pivot;

use Modules\Purchase\Models\Document;
use Modules\Purchase\Models\HistoryTax;
use Modules\Purchase\Models\TaxUnit;

use Response;

class PurchaseQuotationController extends Controller
{
	use ValidatesRequests;

	/**
	 * Muestra vista de principal de cotizacion
	 * @return Renderable
	 */
	public function index()
	{
		return view('purchase::quotation.index', [
			'records' => PurchaseQuotation::with('purchaseSupplier', 'currency', 'relatable')
			->orderBy('id', 'ASC')->get()
		]);
	}

	/**
	 * Muestra vista de formulario de cotizacion
	 * @return Renderable
	 */
	public function create()
	{
		$suppliers  = template_choices('Modules\Purchase\Models\PurchaseSupplier', ['rif','-', 'name'], [], true);

		$currencies = template_choices('Modules\Purchase\Models\Currency', ['name'], [], true);

		$historyTax = HistoryTax::with('tax')->whereHas('tax', function ($query) {
			$query->where('active', true);
		})->where('operation_date', '<=', date('Y-m-d'))->orderBy('operation_date', 'DESC')->first();

		$taxUnit    = TaxUnit::where('active', true)->first();

		$record_base_budgets = PurchaseBaseBudget::with(
			'currency',
			'purchaseRequirement.contratingDepartment',
			'purchaseRequirement.userDepartment',
			'relatable.purchaseRequirementItem.purchaseRequirement'
		)->where('status', 'WAIT_QUOTATION')->orderBy('id', 'ASC')->get();

		return view('purchase::quotation.form', [
			'record_base_budgets' => $record_base_budgets,
			'currencies'   => json_encode($currencies),
			'tax'          => json_encode($historyTax),
			'tax_unit'     => json_encode($taxUnit),
			'suppliers'    => json_encode($suppliers),
		]);
	}

	/**
	 * Metodo para registrar informacion de cotizacion
	 * @param  Request $request
	 * @return JsonResponse
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'purchase_supplier_id' => 'required|integer',
			'currency_id'          => 'required|integer',
			'file_1'               => 'required|mimes:pdf',
			'file_2'               => 'required|mimes:pdf',
			'file_3'               => 'required|mimes:pdf',
			'base_budget_list'     => 'required',
		], [
			'file_1.required'                 => 'El archivo de acta de inicio es obligatorio.',
			'file_1.mimes'                    => 'El archivo de acta de inicio debe ser de tipo pdf.',
			'file_2.required'                 => 'El archivo de invitación de las empresas es obligatorio.',
			'file_2.mimes'                    => 'El archivo de invitación de las empresas debe ser de tipo pdf.',
			'file_3.required'                 => 'El archivo de proforma / Cotización es obligatorio.',
			'file_3.mimes'                    => 'El archivo de proforma / Cotización debe ser de tipo pdf.',
			'purchase_supplier_id.required'   => 'El campo proveedor es obligatorio.',
			'purchase_supplier_id.integer'    => 'El campo proveedor debe ser numerico.',
			'currency_id.required'            => 'El campo de tipo de moneda es obligatorio.',
			'currency_id.integer'             => 'El campo de tipo de moneda debe ser numerico.',
			'base_budget_list'                => 'Debe seleccionar almenos un requerimiento.',
		]);

		$code = $this->generateCodeAvailable();
		$purchase_quotation = PurchaseQuotation::create([
			'code'                    => $code,
			'status'                  => 'QUOTED',
			'purchase_supplier_id'    => $request->purchase_supplier_id,
			'currency_id'             => $request->currency_id,
			'subtotal'                => $request->subtotal,
		]);


		/////// Se guardan los archivos  ///////
		$names_file = ['file_1','file_2','file_3',];
		foreach ($names_file as $name_file_in_request) {
			$document = new UploadDocRepository();
			$name = $request[$name_file_in_request]->getClientOriginalName();
			$docs = Document::where('file', ($name))->get()->count();

			$document->uploadDoc(
				$request[$name_file_in_request],
				'documents',
				PurchaseQuotation::class,
				$purchase_quotation->id,
				null
			);
		}

		foreach (json_decode($request['base_budget_list'], true) as $record) {
			$base_budget = PurchaseBaseBudget::with('purchaseRequirement')->find($record['id']);
			$base_budget->status = 'QUOTED';
			$base_budget->save();

			Pivot::create([
				'relatable_type'  => PurchaseBaseBudget::class,
				'relatable_id' 	  => $base_budget->id,
				'recordable_type' => PurchaseQuotation::class,
				'recordable_id'   => $purchase_quotation->id,
			]);
			// $purchase_quotation->purchase_base_budget_id = $base_budget->id;
			// $purchase_quotation->save();

			foreach ($record['relatable'] as $item) {
				$asd = PurchasePivotModelsToRequirementItem::create([
					'purchase_requirement_item_id' => $item['purchase_requirement_item_id'],
					'relatable_type'               => PurchaseQuotation::class,
					'relatable_id'                 => $purchase_quotation->id,
					'unit_price'                   => $item['unit_price']
				]);
			}
		}
		return response()->json(['message' => 'Success'], 200);
	}

	/**
	 * Show the specified resource.
	 * @return Renderable
	 */
	public function show()
	{
		return view('purchase::show');
	}

	/**
	 * Show the form for editing the specified resource.
	 * @return Renderable
	 */
	public function edit($id)
	{
		
	}

	/**
	 * Update the specified resource in storage.
	 * @param  Request $request
	 * @return Renderable
	 */
	public function update(Request $request)
	{
	}

	/**
	 * Metodo para eliminar informacion de cotizacion
	 * @return Renderable
	 */
	public function destroy($id)
	{
		$record = PurchaseQuotation::with('relatable')->find($id);
		$document = new UploadDocRepository();
		$docs = Document::where('documentable_type', PurchaseQuotation::class)
				->where('documentable_id', $id)->get();

		foreach ($record['relatable'] as $relatable) {
			$requirement = PurchaseRequirement::with('purchaseBaseBudget')
							->where('id', $relatable['purchase_requirement_item_id'])->first();
			if ($requirement && $requirement['purchaseBaseBudget'] && $requirement['purchaseBaseBudget']['status'] == 'QUOTED') {
				$base_budget = PurchaseBaseBudget::find($requirement['purchaseBaseBudget']['id']);
				$base_budget->status = 'WAIT_QUOTATION';
				$base_budget->save();
			}
			$pivot = PurchasePivotModelsToRequirementItem::find($relatable['id']);
			$pivot->delete();
		}

		foreach ($docs as $doc) {
			$document->deleteDoc($doc->file, 'documents');
			$doc->delete();
		}

		$record->delete();

		return response()->json(['message' => 'Success'], 200);
	}

	/**
	 * [generateCodeAvailable genera el código disponible]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @return string código que se asignara
	 */
	public function generateCodeAvailable()
	{
		$codeSetting = CodeSetting::where('table', 'purchase_quotations')->first();

		if (!$codeSetting) {
			$codeSetting = CodeSetting::where('table', 'purchase_quotations')->first();
		}

		if ($codeSetting) {
			$code  = generate_registration_code(
				$codeSetting->format_prefix,
				strlen($codeSetting->format_digits),
				(strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
				PurchaseQuotation::class,
				$codeSetting->field
			);
		} else {
			$code = 'error al generar código de referencia';
		}

		return $code;
	}
}
