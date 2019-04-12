<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingAccountConverter;
use Modules\Budget\Models\BudgetAccount;
use Auth;
/**
 * @class AccountingAccountConverterController
 * @brief Controlador para la conversión de cuentas presupuestales y patrimoniales
 * 
 * Clase que gestiona la conversión entre cuentas presupuestales y patrimoniales
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingAccountConverterController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.converter.index', ['only' => 'index']);
        $this->middleware('permission:accounting.converter.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accounting.converter.edit', ['only' => ['update']]);
        $this->middleware('permission:accounting.converter.delete', ['only' => 'destroy']);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $accountingList = $this->getRecordsAccounting(true);
        $budgetList = $this->getRecordsBudget(true);
        return view('accounting::account_converters.index',compact('accountingList','budgetList'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $accountingList = $this->getRecordsAccounting(false);
        $budgetList = $this->getRecordsBudget(false);
        return view('accounting::account_converters.create',compact('accountingList','budgetList'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request [array con listado de cuentas a convertir]
     * @return Response
     */
    public function store(Request $request)
    {
		foreach ($request->records as $convertion) {
	        $newConvertion = new AccountingAccountConverter();
			$newConvertion->accounting_account_id = $convertion['accounting']['id'];
			$newConvertion->budget_account_id = $convertion['budget']['id'];
			$newConvertion->active = true;
			$newConvertion->save();
        }
		return response()->json(['message'=>'Success']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('accounting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $account = AccountingAccountConverter::find($id);
        $accountingAccounts = [];
        $budgetAccounts = [];

        array_push($accountingAccounts, [
                    'id' => '',
                    'text' =>   "Seleccione..."
                ]);
        array_push($budgetAccounts, [
                    'id' => '',
                    'text' =>   "Seleccione..."
                ]);

        foreach (AccountingAccount::with('account_converters')->orderBy('id','ASC')->get() as $AccountingAccount) {
            if ($AccountingAccount->id == $account->accounting_account_id) {
                array_push($accountingAccounts, [
                    'id' => $AccountingAccount->id,
                    'text' =>   "{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}"
                ]);
            }
            if (!$AccountingAccount->account_converters['active']) {
                array_push($accountingAccounts, [
                    'id' => $AccountingAccount->id,
                    'text' =>   "{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}"
                ]);
            }
        }
        foreach (BudgetAccount::with('account_converters')->orderBy('id','ASC')->get() as $BudgetAccount) {
            if ($BudgetAccount->id == $account->budget_account_id) {
                array_push($budgetAccounts, [
                    'id' => $BudgetAccount->id,
                    'text' =>   "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}"
                ]);
            }
            if (!$BudgetAccount->account_converters['active']) {
                array_push($budgetAccounts, [
                    'id' => $BudgetAccount->id,
                    'text' =>   "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}"
                ]);
            }
        }
        $accountingAccounts = json_encode($accountingAccounts);
        $budgetAccounts = json_encode($budgetAccounts);
        return view('accounting::account_converters.edit',compact('account', 'accountingAccounts', 'budgetAccounts'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'budget_id' => 'required',
            'accounting_id' => 'required'
        ]);

		$convertion = AccountingAccountConverter::find($id);
		$convertion->budget_account_id = $request->budget_id;
		$convertion->accounting_account_id = $request->accounting_id;
		$convertion->save();

        $request->session()->flash('message', ['type' => 'update']);
        $this->index();
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
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
		$records = [];
        if($request->type == 'budget'){
			$records = AccountingAccountConverter::with('budget_account','accounting_account')
											->where('budget_account_id','>=',$request->init_id)
											->where('budget_account_id','<=',$request->end_id)
											->orderBy('id','ASC')->get();

		}else if($request->type == 'accounting'){
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
        $records = [];
        array_push($records, [
            'id' => '',
            'text' =>   "Seleccione..."
        ]);
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

        return json_encode($records);
    }

    /**
     * Consulta los registros del modelo BudgetAccount que posean conversión
     * @param Request $request [array con listado de cuentas a convertir]
     * @param boolean $allRecords [booleano para determinar los registros deseados]
     * @return json
     */
    public function getRecordsBudget($allRecords)
    {
        $records = [];
        array_push($records, [
            'id' => '',
            'text' =>   "Seleccione..."
        ]);
        foreach (BudgetAccount::with('account_converters')->orderBy('id','ASC')->get() as $BudgetAccount) {
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

        return json_encode($records);
    }

}
