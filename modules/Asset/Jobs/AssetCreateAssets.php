<?php

namespace Modules\Asset\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Asset\Models\Asset;

class AssetCreateAssets implements ShouldQueue
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
     * Ejecuta el trabajo de registrar los bienes institucionales
     *
     * @return void
     */
    public function handle()
    {
        $quantity = ($this->data['quantity'])?$this->data['quantity']:1;
        $created_at = now();

        while ($quantity > 0) {
            $quantity--;
            $asset = Asset::create([
                'asset_type_id'              => $this->data['asset_type_id'],
                'asset_category_id'          => $this->data['asset_category_id'],
                'asset_subcategory_id'       => $this->data['asset_subcategory_id'],
                'asset_specific_category_id' => $this->data['asset_specific_category_id'],
                'specifications'             => $this->data['specifications'],
                'asset_condition_id'         => $this->data['asset_condition_id'],
                'asset_acquisition_type_id'  => $this->data['asset_acquisition_type_id'],
                'acquisition_date'           => $this->data['acquisition_date'],
                'asset_status_id'            => $this->data['asset_status_id'],
                'serial'                     => $this->data['serial'],
                'marca'                      => $this->data['marca'],
                'model'                      => $this->data['model'],
                'value'                      => $this->data['value'],
                'currency_id'                => $this->data['currency_id'],
                'institution_id'             => $this->data['institution_id'],
                'asset_use_function_id'      => $this->data['asset_use_function_id'],
                'parish_id'                  => $this->data['parish_id'],
                'address'                    => $this->data['address'],
                'created_at'                 => $created_at
            ]);
            $asset->inventory_serial = $asset->getCode();
            $asset->save();
        }
    }
}
