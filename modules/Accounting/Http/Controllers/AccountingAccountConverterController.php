<?php

namespace Modules\Accounting\Http\Controllers;

use Auth;
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
        $has_budget = (Module::has('Budget') && Module::enabled('Budget'));
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
        $has_budget = (Module::has('Budget') && Module::enabled('Budget'));

        if (!Module::has('Budget') || !Module::enabled('Budget')) {
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
        foreach ($request->records as $convertion) {
            /**
             * Crea el registro de conversiones
             */
            AccountingAccountConverter::create([
                'accounting_account_id' => $convertion['accounting']['id'],
                'budget_account_id' => $convertion['budget']['id'],
                'active' => true,
            ]);
        }
        return response()->json(['message'=>'Success']);
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
        $has_budget = (Module::has('Budget') && Module::enabled('Budget'));

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

        array_push($accountingAccounts, [
                    'id' => '',
                    'text' =>   "Seleccione..."
                ]);

        /**
         * Cuentas patrimoniales
         */
        foreach (AccountingAccount::with('accountConverters')->orderBy('id', 'ASC')->get() as $AccountingAccount) {
            /**
             * agrega al array la cuenta patromonial que se editara
             */
            if ($AccountingAccount->id == $account->accounting_account_id) {
                array_push($accountingAccounts, [
                    'id' => $AccountingAccount->id,
                    'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
                ]);
            }
            /**
             * agrega al array el resto de cuentas disponibles que no tienen conversion activa
             */
            if (!$AccountingAccount->accountConverters['active']) {
                array_push($accountingAccounts, [
                    'id' => $AccountingAccount->id,
                    'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
                ]);
            }
        }

        array_push($budgetAccounts, [
            'id' => '',
            'text' =>   "Seleccione..."
        ]);

        /** Cuentas Presupuestales */
        foreach (\Modules\Budget\Models\BudgetAccount::with('accountConverters')
                                                        ->orderBy('id', 'ASC')->get() as $BudgetAccount) {
            /**
             * agrega al array la cuenta presupuestal que posee la conversión
             */
            if ($BudgetAccount->id == $account->budget_account_id) {
                array_push($budgetAccounts, [
                    'id' => $BudgetAccount->id,
                    'text' =>   "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}"
                ]);
            }
            /**
             * agrega al array solo las cuentas presupuestales que estan disponibles para relacionarse en la conversión
             */
            if (!$BudgetAccount->accountConverters['active']) {
                array_push($budgetAccounts, [
                    'id' => $BudgetAccount->id,
                    'text' =>   "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}"
                ]);
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
            'budget_account_id' => 'required',
            'accounting_account_id' => 'required'
        ]);

        /**
         * Actualiza el registro de conversión a editar
         */
        AccountingAccountConverter::where('id', $id)
          ->update($request->all());

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
             * [$records contine los registros de conversión a en un rango de ids]
             * @var [Modules\Accounting\Models\AccountingAccountConverter]
             */
            $records = AccountingAccountConverter::with('budgetAccount', 'accountingAccount')
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
             * [$records contine los registros de conversión a en un rango de ids]
             * @var [Modules\Accounting\Models\AccountingAccountConverter]
             */
            $records = AccountingAccountConverter::with('budgetAccount', 'accountingAccount')
                                            ->where('accounting_account_id', '>=', $init_id)
                                            ->where('accounting_account_id', '<=', $end_id)
                                            ->orderBy('id', 'ASC')->get();
        }
        return response()->json(['records'=>$records, 'message'=>'Success',200]);
    }

    /**
     * Consulta los registros del modelo AccountingAccount que posean conversión
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request [array con listado de cuentas a convertir]
     * @param  boolean $allRecords [booleano para determinar los registros deseados]
     * @return Array
     */
    public function getRecordsAccounting($allRecords)
    {
        /**
         * [$records contendra registros]
         * @var array
         */
        $records = [];
        array_push($records, [
            'id' => '',
            'text' =>   "Seleccione..."
        ]);

        /**
         * ciclo para almacenar en array cuentas patrimoniales disponibles para conversiones
        */
        foreach (AccountingAccount::with('accountConverters')
                                        ->orderBy('id', 'ASC')
                                        ->get() as $AccountingAccount) {
            if (!$allRecords) {
                if (!$AccountingAccount->accountConverters['active']) {
                    array_push($records, [
                        'id' => $AccountingAccount->id,
                        'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
                    ]);
                }
            } else {
                array_push($records, [
                    'id' => $AccountingAccount->id,
                    'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}",
                ]);
            }
        }
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

        if (Module::has('Budget') && Module::enabled('Budget')) {
            $records = [];
            array_push($records, [
                'id' => '',
                'text' =>   "Seleccione..."
            ]);

            /**
             * ciclo para almacenar en array cuentas presupuestales disponibles para conversiones
            */
            foreach (\Modules\Budget\Models\BudgetAccount::with('accountConverters')
                                                            ->orderBy('id', 'ASC')
                                                            ->get() as $BudgetAccount) {
                if (!$allRecords) {
                    if (!$BudgetAccount->accountConverters['active']) {
                        array_push($records, [
                            'id' => $BudgetAccount->id,
                            'text' =>   "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}"
                        ]);
                    }
                } else {
                    array_push($records, [
                        'id' => $BudgetAccount->id,
                        'text' =>   "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}",
                    ]);
                }
            }
        }
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
