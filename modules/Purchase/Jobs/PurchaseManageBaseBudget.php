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

class PurchaseManageBaseBudget implements ShouldQueue
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
        if ($data['action'] == 'create') {
            $baseBudget = PurchaseBaseBudget::create([
                'currency_id' => $data['currency_id'],
                'subtotal'    => $data['subtotal'],
                'tax_id'      => $data['tax_id'],
            ]);
            foreach ($data['list'] as $requirement) {
                $rq = PurchaseRequirement::find($requirement['id']);
                $rq->requirement_status      = 'PROCESSED';
                $rq->purchase_base_budget_id = $baseBudget['id'];
                $rq->save();

                foreach ($requirement['purchase_requirement_items'] as $item) {
                    PurchasePivotModelsToRequirementItem::create([
                        'purchase_requirement_item_id' => $item['id'],
                        'relatable_type'               => PurchaseBaseBudget::class,
                        'relatable_id'                 => $baseBudget['id'],
                        'unit_price'                   => $item['unit_price']
                    ]);
                }
            }
        } elseif ($data['action'] == 'update') {
            $baseBudget = PurchaseBaseBudget::find($data['id_edit']);
            $baseBudget->currency_id = $data['currency_id'];
            $baseBudget->subtotal    = $data['subtotal'];
            $baseBudget->tax_id      = $data['tax_id'];
            $baseBudget->save();

            foreach ($data['list_to_delete'] as $requirement) {
                // trae requerimiento
                $rq = PurchaseRequirement::find($requirement['id']);

                if ($rq) {
                    $rq->requirement_status      = 'WAIT';
                    $rq->purchase_base_budget_id = null;
                    $rq->save();
                }
                foreach ($requirement['purchase_requirement_items'] as $item) {
                    $r = PurchasePivotModelsToRequirementItem::where('purchase_requirement_item_id', $item['id'])
                                                                ->fisrt();
                    if ($r) {
                        $r->delete();
                    }
                }
            }

            foreach ($data['list'] as $requirement) {
                $rq = PurchaseRequirement::find($requirement['id']);
                $rq->requirement_status = 'PROCESSED';
                $rq->purchase_base_budget_id = $baseBudget['id'];
                $rq->save();

                foreach ($requirement['purchase_requirement_items'] as $item) {
                    PurchasePivotModelsToRequirementItem::updateOrcreate([
                        'purchase_requirement_item_id' => $item['id'],
                        'relatable_type'               => PurchaseBaseBudget::class,
                        'relatable_id'                 => $baseBudget['id'],
                    ], [
                        'unit_price'                   => $item['unit_price']
                    ]);
                }
            }
        }
    }
}
