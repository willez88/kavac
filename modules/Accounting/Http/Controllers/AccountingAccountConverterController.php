<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingAccountConverter;
use Module;

/**
 * @class AccountingAccountConverterController
 * @brief Controlador para la conversión de cuentas presupuestales y patrimoniales
 *
 * Clase que gestiona la conversión entre cuentas presupuestales y patrimoniales
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AccountingAccountConverterController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /**
         *Establece permisos de acceso para cada método del controlador
         */
        $this->middleware('permission:accounting.converter.index', ['only' => 'index']);
        $this->middleware('permission:accounting.converter.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accounting.converter.edit', ['only' => ['update']]);
        $this->middleware('permission:accounting.converter.delete', ['only' => 'destroy']);
    }

    /**
     * [index Muestra la vista principal para mostrar las conversiones]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [view] [vista]
     */
    public function index()
    {
        /**
         * [$has_budget determina si esta instalado el modulo Budget]
         * @var [boolean]
         */
        $has_budget = (Module::has('Budget') && Module::isEnabled('Budget'));
        return view('accounting::account_converters.index', compact('has_budget'));
    }

    /**
     * [getAllRecordsAccountingVuejs registros de las cuentas patrimoniales al componente]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [response]
     */
    public function getAllRecordsAccountingVuejs()
    {
        return response()->json(['records'=>$this->getRecordsAccounting(true)]);
    }

    /**
     * [getAllRecordsBudgetVuejs registros de las cuentas presupuestales al componente]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [response]
     */
    public function getAllRecordsBudgetVuejs()
    {
        return response()->json(['records'=>$this->getRecordsBudget(true)]);
    }

    /**
     * [create Muestra un formulario para crear conversiones de cuentas]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [view]
     */
    public function create()
    {
        /**
         * [$has_budget determina si esta instalado el modulo Budget]
         * @var [boolean]
         */
        $has_budget = (Module::has('Budget') && Module::isEnabled('Budget'));

        if (!Module::has('Budget') || !Module::isEnabled('Budget')) {
            return view('accounting::account_converters.create', compact('has_budget'));
        }

        /**
         * [$accountingList contiene las cuentas patrimoniales]
         * @var [Json]
         */
        $accountingList = json_encode($this->getRecordsAccounting(false));

        /**
         * [$accountingList contiene las cuentas presupuestales]
         * @var [Json]
         */
        $budgetList = json_encode($this->getRecordsBudget(false));

        return view('accounting::account_converters.create', compact('has_budget', 'accountingList', 'budgetList'));
    }

    /**
     * [store Crea una nuevas conversiones]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [Request] $request [listado de cuentas a convertir]
     * @return [Response]
     */
    public function store(Request $request)
    {
        /**
         * Crea el registro de conversiones
         */
        AccountingAccountConverter::create([
            'accounting_account_id' => $request->accounting_id,
            'budget_account_id' => $request->budget_id,
            'active' => true,
        ]);

        /**
         * [$records_accounting contiene las cuentas patrimoniales disponibles]
         * @var [Json]
         */
        $records_accounting = $this->getRecordsAccounting(false);

        /**
         * [$records_busget contiene las cuentas presupuestales disponibles]
         * @var [Json]
         */
        $records_busget = $this->getRecordsBudget(false);

        return response()->json([
                                    'records_accounting'=> $records_accounting,
                                    'records_busget'=> $records_busget,
                                    'message'=>'Success'
                                ]);
    }

    /**
     * [edit Muestra el formulario para la edición de conversión de cuentas]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [integer] $id [Identificador de la conversión a modificar]
     * @return [view]
     */
    public function edit($id)
    {
        /**
         * [$has_budget determina si esta instalado el modulo Budget]
         * @var [boolean]
         */
        $has_budget = (Module::has('Budget') && Module::isEnabled('Budget'));

        if (!$has_budget) {
            dd($has_budget);
            return view('accounting::account_converters.edit', compact('has_budget'));
        }

        /**
         * [$account contine el registro de conversión a editar]
         * @var [Modules\Accounting\Models\AccountingAccountConverter]
         */
        $account = AccountingAccountConverter::find($id);

        /**
         * [$accountingAccounts contendra las cuentas patrimoniales]
         * @var array
         */
        $accountingAccounts = [];

        /**
         * [$accountingAccounts contendra las cuentas presupuestales]
         * @var array
         */
        $budgetAccounts = [];


        /**
         * [$records_accounting contiene las cuentas patrimoniales disponibles]
         * @var [Json]
         */
        $accountingAccounts = $this->getRecordsAccounting(false);

        /**
         * [$records_busget contiene las cuentas presupuestales disponibles]
         * @var [Json]
         */
        $budgetAccounts = $this->getRecordsBudget(false);

        /**
         * Cuenta patrimonial a editar
         */

        $aux = AccountingAccount::find($account->accounting_account_id);
        $aux['getCodeAttribute'] = $aux->getCodeAttribute();
        /**
         * agrega al array la cuenta patromonial que se editara
        */

        for ($i=1; $i < $accountingAccounts[0]['index']; $i++) {
            if (explode(' - ', $accountingAccounts[$i]['text'])[0] > "{$aux->getCodeAttribute}") {
                array_splice($accountingAccounts, $i, 0, '-');
                $accountingAccounts[$i] = [
                    'id' => $aux->id,
                    'text' => "{$aux->getCodeAttribute()} - {$aux->denomination}"
                ];
                break;
            }
        }

        /**
         * Cuenta Presupuestal a editar
         */

        $aux = \Modules\Budget\Models\BudgetAccount::find($account->budget_account_id);
        $aux['getCodeAttribute'] = $aux->getCodeAttribute();
        /**
         * agrega al array la cuenta presupuestal que se editara
        */
        for ($i=1; $i < $budgetAccounts[0]['index']; $i++) {
            if (explode(' - ', $budgetAccounts[$i]['text'])[0] > "{$aux->getCodeAttribute}") {
                array_splice($budgetAccounts, $i, 0, '-');
                $budgetAccounts[$i] = [
                    'id' => $aux->id,
                    'text' => "{$aux->getCodeAttribute()} - {$aux->denomination}"
                ];
                break;
            }
        }

        /**
         * [$accountingAccounts contiene las cuentas presupuestales]
         * @var [Json]
         */
        $accountingAccounts = json_encode($accountingAccounts);

        /**
         * [$budgetAccounts contiene las cuentas presupuestales]
         * @var [Json]
         */
        $budgetAccounts = json_encode($budgetAccounts);
        return view(
            'accounting::account_converters.edit',
            compact('has_budget', 'account', 'accountingAccounts', 'budgetAccounts')
        );
    }

    /**
     * [update Actualiza los datos de la conversión]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [Request] $request [Objeto con datos de la petición realizada]
     * @param  [integer] $id      [Identificador de la conversión a modificar]
     * @return [Response]
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'budget_account_id' => ['required'],
            'accounting_account_id' => ['required']
        ]);

        /**
         * Actualiza el registro de conversión a editar
         */
        $record = AccountingAccountConverter::find($id);

        $record->accounting_account_id = $request['accounting_account_id'];
        $record->budget_account_id = $request['budget_account_id'];
        $record->save();

        $request->session()->flash('message', ['type' => 'update']);
        $this->index();
    }

    /**
     * [destroy Elimina un conversión]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [integer] $id [Identificador de la conversión a eliminar]
     * @return [Response]
     */
    public function destroy($id)
    {
        /**
         * [$convertion registro de conversión a eliminar]
         * @var [Modules\Accounting\Models\AccountingAccountConverter]
         */
        $convertion = AccountingAccountConverter::find($id);

        if ($convertion) {
            $convertion->delete();
        }
        return response()->json(['records' => [], 'message' => 'Success'], 200);
    }

    /**
     * [getRecords registros en un rango de ids dado]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request [parametros de busqueda]
     * @return Response
     */
    public function getRecords(Request $request)
    {
        /**
         * [$records contendra registros]
         * @var array
         */
        $records = [];

        /**
         * [$init_id id de rango inicial de busqueda]
         * @var integer
         */
        $init_id = 0;

        /**
         * [$end_id id de rango final de busqueda]
         * @var integer
         */
        $end_id = 0;

        if (!$request->all) {
            $init_id = $request->init_id = ($request->init_id > $request->end_id)? $request->end_id : $request->init_id;
            $end_id = $request->end_id = ($request->init_id > $request->end_id) ? $request->init_id : $request->end_id;
        }

        if ($request->type == 'budget') {
            if ($request->all) {
                /**
                 * Se obtienen el primer y ultimo id de las cuentas presupuestales
                */
                $init_id = \Modules\Budget\Models\BudgetAccount::orderBy('created_at', 'ASC')
                                                                ->where('parent_id', null)->first()->id;
                $end_id = \Modules\Budget\Models\BudgetAccount::orderBy('created_at', 'DESC')->first()->id;
            }

            /**
             * [$query contine los registros de conversión a en un rango de ids]
             * @var [Modules\Accounting\Models\AccountingAccountConverter]
             */
            $query = AccountingAccountConverter::with('budgetAccount', 'accountingAccount')
                                            ->where('budget_account_id', '>=', $init_id)
                                            ->where('budget_account_id', '<=', $end_id)
                                            ->orderBy('id', 'ASC')->get();
        } elseif ($request->type == 'accounting') {
            if ($request->all) {
                /**
                 * Se obtienen el primer y ultimo id de las cuentas patrimoniales
                */
                $init_id = AccountingAccount::orderBy('created_at', 'ASC')->where('parent_id', null)->first()->id;
                $end_id = AccountingAccount::orderBy('created_at', 'DESC')->first()->id;
            }

            /**
             * [$query contine los registros de conversión a en un rango de ids]
             * @var [Modules\Accounting\Models\AccountingAccountConverter]
             */
            $query = AccountingAccountConverter::with('budgetAccount', 'accountingAccount')
                                            ->where('accounting_account_id', '>=', $init_id)
                                            ->where('accounting_account_id', '<=', $end_id)
                                            ->orderBy('id', 'ASC')->get();
        }

        $records = [];
        $cont = 0;

        foreach ($query as $r) {
            $records[$cont] = [
                'id'                 => $r['id'],
                'codeAccounting'     => $r['accountingAccount']->getCodeAttribute(),
                'accounting_account' => $r['accountingAccount']['denomination'],
                'codeBudget'         => $r['budgetAccount']->getCodeAttribute(),
                'budget_account'     => $r['budgetAccount']['denomination'],
            ];
            $cont++;
        }
        return response()->json(['records'=>$records, 'message'=>'Success',200]);
    }

    /**
     * Consulta los registros del modelo AccountingAccount que posean conversión
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request [array con listado de cuentas a convertir]
     * @param  boolean $allRecords booleano para determinar los registros deseados,
     *                             true= todo, false=solo sin conversiones
     * @return Array
     */
    public function getRecordsAccounting($allRecords)
    {
        /**
         * [$records contendra registros]
         * @var array
         */
        $records = [];
        $index = 0;
        array_push($records, [
            'id' => '',
            'text' =>   "Seleccione..."
        ]);

        /**
         * ciclo para almacenar en array cuentas patrimoniales disponibles para conversiones
        */

        if (!$allRecords) {
            foreach (AccountingAccount::doesnthave('accountConverters')
                    ->orderBy('group', 'ASC')
                    ->orderBy('subgroup', 'ASC')
                    ->orderBy('item', 'ASC')
                    ->orderBy('generic', 'ASC')
                    ->orderBy('specific', 'ASC')
                    ->orderBy('subspecific', 'ASC')
                    ->orderBy('denomination', 'ASC')
                    ->cursor() as $AccountingAccount) {
                array_push($records, [
                        'id' => $AccountingAccount->id,
                        'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
                    ]);
                $index++;
            }
        } else {
            foreach (AccountingAccount::with('accountConverters')
                    ->orderBy('group', 'ASC')
                    ->orderBy('subgroup', 'ASC')
                    ->orderBy('item', 'ASC')
                    ->orderBy('generic', 'ASC')
                    ->orderBy('specific', 'ASC')
                    ->orderBy('subspecific', 'ASC')
                    ->orderBy('denomination', 'ASC')
                    ->cursor() as $AccountingAccount) {
                array_push($records, [
                        'id' => $AccountingAccount->id,
                        'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
                    ]);
                $index++;
            }
        }

        $records[0]['index'] = $index;

        /**
         * se convierte array a JSON
         */
        return $records;
    }

    /**
     * [getRecordsBudget Consulta los registros del modelo BudgetAccount que posean conversión]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param [boolean] $allRecords [booleano para determinar los registros deseados]
     * @return [json]
     */
    public function getRecordsBudget($allRecords)
    {
        /**
         * [$records contendra registros]
         * @var null
         */
        $records = null;
        $index = 0;

        if (Module::has('Budget') && Module::isEnabled('Budget')) {
            $records = [];
            array_push($records, [
                'id' => '',
                'text' =>   "Seleccione..."
            ]);

            /**
             * ciclo para almacenar en array cuentas presupuestales disponibles para conversiones
            */

            if (!$allRecords) {
                foreach (\Modules\Budget\Models\BudgetAccount::doesnthave('accountConverters')
                    ->orderBy('group', 'ASC')
                    ->orderBy('item', 'ASC')
                    ->orderBy('generic', 'ASC')
                    ->orderBy('specific', 'ASC')
                    ->orderBy('subspecific', 'ASC')
                    ->orderBy('denomination', 'ASC')
                    ->cursor() as $AccountingAccount) {
                    array_push($records, [
                        'id' => $AccountingAccount->id,
                        'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
                    ]);
                    $index++;
                }
            } else {
                foreach (\Modules\Budget\Models\BudgetAccount::with('accountConverters')
                    ->orderBy('group', 'ASC')
                    ->orderBy('item', 'ASC')
                    ->orderBy('generic', 'ASC')
                    ->orderBy('specific', 'ASC')
                    ->orderBy('subspecific', 'ASC')
                    ->orderBy('denomination', 'ASC')
                    ->cursor() as $AccountingAccount) {
                    array_push($records, [
                        'id' => $AccountingAccount->id,
                        'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
                    ]);
                }
                $index++;
            }
        }

        $records[0]['index'] = $index;
        /**
         * se convierte array a JSON
         */
        return $records;
    }

    /**
     * [budgetToAccount cuenta patrimonial correspondiente a la presupuestal]
     * @author    Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [integer] $id [id de cuenta patrimonial]
     * @return [Response]     [cuenta patrimonial correspondiente a la presupuestal]
     */
    public function budgetToAccount($id)
    {
        /**
         * [$convertion registros relacionados]
         * @var [Modules\Accounting\Models\AccountingAccountConverter]
         */
        $convertion = AccountingAccountConverter::with('accountingAccount')->where('budget_account_id', $id)->first();
        return response()->json(['record'=> $convertion->accounting_account,'message'=>'Success'], 200);
    }

    /**
     * [accountToBudget cuenta presupuestal correspondiente a la patrimonial]
     * @author    Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [integer] $id [id de cuenta presupuestal]
     * @return [Response]     [cuenta presupuestal correspondiente a la patrimonial]
     */
    public function accountToBudget($id)
    {
        /**
         * [$convertion registros relacionados]
         * @var [Modules\Accounting\Models\AccountingAccountConverter]
         */
        $convertion = AccountingAccountConverter::with('budgetAccount')->where('accounting_account_id', $id)->first();
        return response()->json(['record'=> $convertion->budgetAccount,'message'=>'Success'], 200);
    }
}
