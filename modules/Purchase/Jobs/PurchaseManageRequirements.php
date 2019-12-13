<?php

namespace Modules\Purchase\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Purchase\Models\PurchaseRequirement;

use Modules\Warehouse\Models\WarehouseProduct;
use Modules\Warehouse\Models\Warehouse;
use App\Models\CodeSetting;
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
     * identificador que indica si se actualizara o se creara
     *
     * @var String $id
     */
    protected $id;


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
    public function __construct(array $data, integer $id = null)
    {
        $this->data = $data;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        if ($this->id) {
            $newEntries = PurchaseRequirement::find($this->id);
        } else {
            $data['code'] = $this->generateCodeAvailable();
            $requirement = PurchaseRequirement::create($data);

            foreach ($data['products'] as $prod) {
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
        $institution = get_institution();
        $codeSetting = CodeSetting::where('table', 'purchase_requirements')
                                    ->first();

        if (!$codeSetting) {
            $codeSetting = CodeSetting::where('table', 'purchase_requirements')
                                    ->first();
        }

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
