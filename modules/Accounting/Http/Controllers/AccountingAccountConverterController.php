<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Models\AccountingAccountConverter;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Budget\Models\BudgetAccount;

class AccountingAccountConverterController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $accountingAccounts = [];
        $budgetAccounts = [];

        foreach (AccountingAccount::with('account_converters')->orderBy('id','asc')->get() as $AccountingAccount) {
            // esi la cuenta tiene una converción activa no la cargara
            if (!$AccountingAccount->account_converters['active']) {
                /**
                    Se envia el campo id concatenado con el resto de informacion para
                    que en caso convertir varias cuentas en la vista no tenga que realizar busquedas para mostrar la informacion
                */

                array_push($accountingAccounts, [
                    'id' => "{$AccountingAccount->id}?{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}",
                    'text' => "{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}"
                ]);
            }
        }
        foreach (BudgetAccount::with('account_converters')->orderBy('id','asc')->get() as $BudgetAccount) {
            // esi la cuenta tiene una converción activa no la cargara
            if (!$BudgetAccount->account_converters['active']) {
                /**
                    Se envia el campo id concatenado con el resto de informacion para
                    que en caso convertir varias cuentas en la vista no tenga que realizar busquedas para mostrar la informacion
                */
                array_push($budgetAccounts, [
                    'id' => "{$BudgetAccount->id}?{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}",
                    'text' => "{$BudgetAccount->getCodeAttribute()} - {$BudgetAccount->denomination}"
                ]);
            }
        }
        $accountingAccounts = json_encode($accountingAccounts);
        $budgetAccounts = json_encode($budgetAccounts);

        return view('accounting::account_converters.index',compact('budgetAccounts','accountingAccounts'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('accounting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
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
        return view('accounting::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
