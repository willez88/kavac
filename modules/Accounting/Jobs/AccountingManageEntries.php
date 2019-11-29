<?php

namespace Modules\Accounting\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\AccountingEntryAccount;
use Modules\Accounting\Models\AccountingEntryCategory;
use Modules\Accounting\Models\Institution;

use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;

class AccountingManageEntries implements ShouldQueue
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
        $created_at = now();

        $newEntries = AccountingEntry::where('reference', $this->data['reference'])->first();

        /**
         * Para actualizar
         */
        if ($newEntries) {
            $newEntries->concept= $this->data['concept'];
            $newEntries->observations = $this->data['observations'];
            $newEntries->accounting_entry_categories_id = ($this->data['category']!='')? $this->data['category']: null;
            $newEntries->institution_id = $this->data['institution_id'];
            $newEntries->currency_id = $this->data['currency_id'];
            $newEntries->tot_debit = $this->data['totDebit'];
            $newEntries->tot_assets = $this->data['totAssets'];
        } else {
            /**
             * Para crear
             */
            $newEntries = AccountingEntry::create([
                'from_date'                      => $this->data['date'],
                'reference'                      => ($this->data['reference'])??$this->generateReferenceCodeAvailable(),
                'concept'                        => $this->data['concept'],
                'observations'                   => $this->data['observations'],
                'accounting_entry_categories_id' => ($this->data['category']!='')? $this->data['category']: null,
                'institution_id'                 => $this->data['institution_id'],
                'currency_id'                    => $this->data['currency_id'],
                'tot_debit'                      => $this->data['totDebit'],
                'tot_assets'                     => $this->data['totAssets'],
                'created_at'                     => $created_at
            ]);
            $newEntries->save();
        }

        foreach ($this->data['accountingAccounts'] as $account) {
            /**
             * Se actualiza o crea la relación de cuenta a ese asiento si ya existe existe lo actualiza,
             * de lo contrario crea el nuevo registro de cuenta
             */
            if ($account['entryAccountId']) {
                /**
                 * [$record contiene el registro de cuanta patrimonial asociada al asiento a actualizar]
                 * @var AccountingEntryAccount
                 */
                $record = AccountingEntryAccount::find($account['entryAccountId']);
                $record->accounting_account_id = $account['id'];
                $record->debit = $account['debit'];
                $record->assets = $account['assets'];
                $record->save();
            } else {
                AccountingEntryAccount::create([
                    'accounting_entry_id' => $newEntries->id,
                    'accounting_account_id' => $account['id'],
                    'debit' => $account['debit'],
                    'assets' => $account['assets'],
                ]);
            }
        }
    }

    /**
     * [getInstitution obtiene la informacion de una institución]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  int|null $id [identificador unico de la institución]
     * @return Institution     [informacion de la institución]
     */
    public function getInstitution($id = null)
    {
        if ($id) {
            return Institution::find($id);
        }
        return Institution::first();
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
}
