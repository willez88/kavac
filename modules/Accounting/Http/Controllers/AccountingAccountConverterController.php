<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingAccountConverter;
use Modules\Accounting\Models\AccountingAccount;
use Module;
use Auth;
/**
 * @class AccountingAccountConverterController
 * @brief Controlador para la conversión de cuentas presupuestales y patrimoniales
 * 
 * Clase que gestiona la conversión entre cuentas presupuestales y patrimoniales
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
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
     * Muestra la vista principal para mostrar las conversiones
     * @brief se consulta y formatea las cuentas patrimoniales y presupuestales
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return view
     */
    public function index()
    {
        /** @var boolean determina si esta instalado el modulo Budget */
        $has_budget = (Module::has('Budget') && Module::enabled('Budget'));
        return view('accounting::account_converters.index',compact('has_budget'));
    }

    /**
     * funcion que retorna los registros de las cuentas patrimoniales al componente
     * @brief se consulta y formatea los registros cuentas patrimoniales
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return response
     */
    public function getAllRecordsAccounting_vuejs()
    {
        return response()->json(['records'=>$this->getRecordsAccounting(true)]);
    }
    /**
     * funcion que retorna los registros de las cuentas presupuestales al componente
     * @brief se consulta y formatea los registros cuentas presupuestales
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return response
     */
    public function getAllRecordsBudget_vuejs()
    {
        return response()->json(['records'=>$this->getRecordsBudget(true)]);
    }

    /**
     * Muestra un formulario para crear conversiones de cuentas
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return Response
     */
    public function create()
    {
        $has_budget = (Module::has('Budget') && Module::enabled('Budget'));

        if (!Module::has('Budget') || !Module::enabled('Budget')) {
            return view('accounting::account_converters.create',compact('has_budget'));
        }

        /** @var JSON Objeto que contiene las cuentas patrimoniales */
        $accountingList = json_encode($this->getRecordsAccounting(false));

        /** @var JSON Objeto que contiene las cuentas patrimoniales */
        $budgetList = json_encode($this->getRecordsBudget(false));

        return view('accounting::account_converters.create',compact('has_budget', 'accountingList','budgetList'));
    }

    /**
     * Crea una nuevas conversiones
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request array con listado de cuentas a convertir
     * @return Response
     */
    public function store(Request $request)
    {
		foreach ($request->records as $convertion) {
            /** @var Crea el registro de conversiones */
	        AccountingAccountConverter::create([
                'accounting_account_id' => $convertion['accounting']['id'],
                'budget_account_id' => $convertion['budget']['id'],
                'active' => true,
            ]);
        }
		return response()->json(['message'=>'Success']);
    }

    /**
     * Muestra el formulario para la edición de conversión de cuentas
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $id Identificador de la conversión a modificar
     * @return Response
     */
    public function edit($id)
    {
        /** @var boolean determina si esta instalado el modulo Budget */
        $has_budget = (Module::has('Budget') && Module::enabled('Budget'));

        if (!$has_budget) {
            dd($has_budget);
            return view('accounting::account_converters.edit',compact('has_budget'));
        }

        /** @var Object Objeto que contine el registro de conversión a editar */
        $account = AccountingAccountConverter::find($id);

        /** @var array Arreglo que contendra las cuentas patrimoniales */
        $accountingAccounts = [];

        /** @var array Arreglo que contendra las cuentas presupuestales */
        $budgetAccounts = [];

        array_push($accountingAccounts, [
                    'id' => '',
                    'text' =>   "Seleccione..."
                ]);

        /** Cuentas Presupuestales */
        foreach (AccountingAccount::with('account_converters')->orderBy('id','ASC')->get() as $AccountingAccount) {
            /**
             * agrega al array la cuenta patromonial que se editara
             */
            if ($AccountingAccount->id == $account->accounting_account_id) {
                array_push($accountingAccounts, [
                    'id' => $AccountingAccount->id,
                    'text' =>   "{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}"
                ]);
            }
            /**
             * agrega al array el resto de cuentas disponibles que no tienen conversion activa
             */
            if (!$AccountingAccount->account_converters['active']) {
                array_push($accountingAccounts, [
                    'id' => $AccountingAccount->id,
                    'text' =>   "{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}"
                ]);
            }
        }

        array_push($budgetAccounts, [
            'id' => '',
            'text' =>   "Seleccione..."
        ]);

        /** Cuentas Presupuestales */

        foreach (\Modules\Budget\Models\BudgetAccount::with('account_converters')->orderBy('id','ASC')->get() as $BudgetAccount) {
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
            if (!$BudgetAccount->account_converters['active']) {
                array_push($budgetAccounts, [
                    'id' => $BudgetAccount->id,
                    'text' =>   "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}"
                ]);
            }
        }
        /**
         * se convierte array a JSON
         */
        $accountingAccounts = json_encode($accountingAccounts);
        /**
         * se convierte array a JSON
         */
        $budgetAccounts = json_encode($budgetAccounts);
        
        return view('accounting::account_converters.edit',compact('has_budget', 'account', 'accountingAccounts', 'budgetAccounts'));
    }

    /**
     * Actualiza los datos de la conversión
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @param  integer $id      Identificador de la conversión a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'budget_account_id' => 'required',
            'accounting_account_id' => 'required'
        ]);

        /** @var Object Objeto que contine el registro de conversión a editar */
        AccountingAccountConverter::where('id', $id)
          ->update($request->all());

        $request->session()->flash('message', ['type' => 'update']);
        $this->index();
    }

    /**
     * Elimina un conversión
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $id Identificador de la conversión a eliminar
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Object Objeto que contine el registro de conversión a eliminar */
        $convertion = AccountingAccountConverter::find($id);

        if ($convertion) {
            $convertion->delete();
        }
        return response()->json(['records' => [], 'message' => 'Success'], 200);
    }

    /**
     * consulta los registros en un rango de ids dado
     * @param Request $request
     * @return Response
     */
    public function getRecords(Request $request)
    {
        /** @var array Arreglo que contendra registros */
		$records = [];
        if($request->type == 'budget'){
            /** @var Object Objeto que contine los registros de conversión a en un rango de ids */
			$records = AccountingAccountConverter::with('budget_account','accounting_account')
											->where('budget_account_id','>=',$request->init_id)
											->where('budget_account_id','<=',$request->end_id)
											->orderBy('id','ASC')->get();

		}else if($request->type == 'accounting'){
            /** @var Object Objeto que contine los registros de conversión a en un rango de ids */
			$records = AccountingAccountConverter::with('budget_account','accounting_account')
											->where('accounting_account_id','>=',$request->init_id)
											->where('accounting_account_id','<=',$request->end_id)
											->orderBy('id','ASC')->get();
		}
		return response()->json(['records'=>$records, 'message'=>'Success',200]);
    }

    /**
     * Consulta los registros del modelo AccountingAccount que posean conversión
     * @param Request $request [array con listado de cuentas a convertir]
     * @param boolean $allRecords [booleano para determinar los registros deseados]
     * @return json
     */
    public function getRecordsAccounting($allRecords)
    {
        /** @var array Arreglo que contendra registros */
        $records = [];
        array_push($records, [
            'id' => '',
            'text' =>   "Seleccione..."
        ]);

        /**
         * ciclo para almacenar en array cuentas patrimoniales disponibles para conversiones
        */
        foreach (AccountingAccount::with('account_converters')->orderBy('id','ASC')->get() as $AccountingAccount) {
            if (!$allRecords) {
                if (!$AccountingAccount->account_converters['active']) {
                    array_push($records, [
                        'id' => $AccountingAccount->id,
                        'text' =>   "{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}"
                    ]);
                }
            }else{
                array_push($records, [
                    'id' => $AccountingAccount->id,
                    'text' =>   "{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}",
                ]);
            }
        }
        /**
         * se convierte array a JSON
         */
        return $records;
    }

    /**
     * Consulta los registros del modelo BudgetAccount que posean conversión
     * @param Request $request [array con listado de cuentas a convertir]
     * @param boolean $allRecords [booleano para determinar los registros deseados]
     * @return json
     */
    public function getRecordsBudget($allRecords)
    {
        /** @var array Arreglo que contendra registros */
        $records = null;
        
        /**
         * ciclo para almacenar en array cuentas presupuestales disponibles para conversiones
        */
        if (Module::has('Budget') && Module::enabled('Budget')) {
            $records = [];
            array_push($records, [
                'id' => '',
                'text' =>   "Seleccione..."
            ]);
            
            foreach (\Modules\Budget\Models\BudgetAccount::with('account_converters')->orderBy('id','ASC')->get() as $BudgetAccount) {
                if (!$allRecords) {
                    if (!$BudgetAccount->account_converters['active']) {
                        array_push($records, [
                            'id' => $BudgetAccount->id,
                            'text' =>   "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}"
                        ]);
                    }
                }else{
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
     * retorna la cuenta patrimonial correspondiente a la presupuestal
     * @param int $id
     * @return Response
     */
    public function budgetToAccount($id)
    {
        $convertion = AccountingAccountConverter::with('accounting_account')->where('budget_account_id',$id)->first();
        return response()->json(['record'=> $convertion->accounting_account,'message'=>'Success'], 200);
    }

    /**
     * retorna la cuenta presupuestal correspondiente a la patrimonial
     * @param int $id
     * @return Response
     */
    public function accountToBudget($id)
    {
        $convertion = AccountingAccountConverter::with('budget_account')->where('accounting_account_id',$id)->first();
        return response()->json(['record'=> $convertion->budget_account,'message'=>'Success'], 200);
    }
}
