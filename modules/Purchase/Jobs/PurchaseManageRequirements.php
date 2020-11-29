<?php

namespace Modules\Purchase\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Purchase\Models\PurchaseBaseBudget;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\PurchaseRequirementItem;
use Modules\Purchase\Models\PurchasePivotModelsToRequirementItem;

use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\Warehouse;
use App\Models\Institution;
use App\Models\CodeSetting;
use App\Models\MeasurementUnit;
use App\Rules\CodeSetting as CodeSettingRule;
use App\Models\FiscalYear;

class PurchaseManageRequirements implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	/**
	 * Objeto que contiene la información asociada a la solicitud
	 *
	 * @var Object $asset
	 */
	protected $data;

	/**
	 * Variable que contiene el tiempo de espera para la ejecución del trabajo,
	 * si no se quiere limite de tiempo, se define en 0
	 *
	 * @var Integer $timeout
	 */
	public $timeout = 0;

	/**
	 * Crea una nueva instancia del trabajo
	 *
	 * @return void
	 */
	public function __construct(array $data)
	{
		$this->data = $data;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()
	{
		$data = $this->data;

		if ($data['action'] == 'update') {
			$requirement = PurchaseRequirement::find($data['id_edit']);

			foreach ($data['toDelete'] as $toDeleteId) {
				PurchaseRequirementItem::find($toDeleteId)->delete();
			}

			foreach ($data['products'] as $prod) {
				$p = PurchaseRequirementItem::find($prod['id']);
				if ($p) {
					$p['purchase_requirement_id']   = $requirement->id;
					$p['technical_specifications']  = $prod['technical_specifications'];
					$p['quantity']                  = $prod['quantity'];
					$p->save();
				} else {
					$prod['purchase_requirement_id'] = $requirement->id;
					$warehouseProd = WarehouseProduct::find($prod['id']);
					PurchaseRequirementItem::create([
						'name'                     => $warehouseProd->name,
						'description'              => $warehouseProd->description,
						'technical_specifications' => $prod['technical_specifications'],
						'quantity'                 => $prod['quantity'],
						'warehouse_product_id'     => $prod['id'],
						'purchase_requirement_id'  => $requirement->id
					]);
				}
			}
		} elseif ($data['action'] == 'create') {
			$data['code'] = $this->generateCodeAvailable();
			$baseBudget = PurchaseBaseBudget::create([
				'subtotal' => 0,
			]);
			$data['purchase_base_budget_id'] = $baseBudget->id;

			$requirement = PurchaseRequirement::create($data);

			foreach ($data['products'] as $prod) {
				$prod['purchase_requirement_id'] = $requirement->id;
				$warehouseProd = WarehouseProduct::find($prod['id']);
				$item = PurchaseRequirementItem::create([
					'name'                     => $warehouseProd->name,
					'description'              => $warehouseProd->description,
					'technical_specifications' => $prod['technical_specifications'],
					'quantity'                 => $prod['quantity'],
					'warehouse_product_id'     => $prod['id'],
					'purchase_requirement_id'  => $requirement->id
				]);

				PurchasePivotModelsToRequirementItem::create([
					'relatable_type'               => PurchaseBaseBudget::class,
					'relatable_id'                 => $baseBudget->id,
					'purchase_requirement_item_id' => $item->id,
					'unit_price'                   => 0,
				]);
			}
		}
	}
	
	/**
	 * [generateCodeAvailable genera el código disponible]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @return string [código que se asignara]
	 */
	public function generateCodeAvailable()
	{
		$codeSetting = CodeSetting::where('table', 'purchase_requirements')
									->first();

		if ($codeSetting) {
			$code  = generate_registration_code(
				$codeSetting->format_prefix,
				strlen($codeSetting->format_digits),
				(strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
				PurchaseRequirement::class,
				$codeSetting->field
			);
		} else {
			$code = 'error al generar código de referencia';
		}

		return $code;
	}
}
