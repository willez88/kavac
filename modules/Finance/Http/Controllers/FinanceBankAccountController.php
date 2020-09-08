<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Finance\Models\FinanceBank;
use Modules\Finance\Models\FinanceBankAccount;

/**
 * @class FinanceBankAccountController
 * @brief Controlador para las cuentas bancarias
 *
 * Clase que gestiona las cuentas bancarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class FinanceBankAccountController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json([
            'records' => FinanceBankAccount::with(['financeBankingAgency' => function ($query) {
                return $query->with('financeBank');
            }])->orderBy('ccc_number')->get()
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ccc_number' => ['required', 'max:20', 'unique:finance_bank_accounts,ccc_number'],
            'description' => ['required'],
            'opened_at' => ['required', 'date'],
            'finance_banking_agency_id' => ['required'],
            'finance_account_type_id' => ['required']
        ]);

        $financeBankAccount = FinanceBankAccount::create([
            'ccc_number' => $request->bank_code . $request->ccc_number,
            'description' => $request->description,
            'opened_at' => $request->opened_at,
            'finance_banking_agency_id' => $request->finance_banking_agency_id,
            'finance_account_type_id' => $request->finance_account_type_id
        ]);

        return response()->json(['record' => $financeBankAccount, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var object Datos de la cuenta bancaria */
        $bankAccount = FinanceBankAccount::find($id);

        $this->validate($request, [
            'ccc_number' => [
                'required', 'max:20', 'unique:finance_bank_accounts,ccc_number,' . substr($bankAccount->ccc_number, 4)
            ],
            'description' => ['required'],
            'opened_at' => ['required', 'date'],
            'finance_banking_agency_id' => ['required'],
            'finance_account_type_id' => ['required']
        ]);

        $bankAccount->ccc_number = $request->bank_code . $request->ccc_number;
        $bankAccount->description = $request->description;
        $bankAccount->opened_at = $request->opened_at;
        $bankAccount->finance_banking_agency_id = $request->finance_banking_agency_id;
        $bankAccount->finance_account_type_id = $request->finance_account_type_id;
        $bankAccount->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        /** @var object Datos de la cuenta bancaria */
        $financeBankAccount = FinanceBankAccount::find($id);
        $financeBankAccount->delete();
        return response()->json(['record' => $financeBankAccount, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene todas las cuentas bancarias asociadas a una entidad bancaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $bank_id                 Identificador de la entidad bancaria de la que se
     *                                          desean obtener las cuentas
     * @return \Illuminate\Http\JsonResponse    JSON con los datos de las cuentas bancarias asociadas
     *                                          al banco
     */
    public function getBankAccounts($bank_id)
    {
        /** @var object Datos de la entidad bancaria */
        $bank = FinanceBank::where('id', $bank_id)->with(['financeAgencies' => function ($query) {
            return $query->with('bankAccounts');
        }])->first();

        $accounts = [['id' => '', 'text' => 'Seleccione...']];
        foreach ($bank->financeAgencies as $agency) {
            foreach ($agency->bankAccounts as $bank_account) {
                $accounts[] = [
                    'id' => $bank_account->id,
                    'text' => $bank->code . $bank_account->ccc_number
                ];
            }
        }

        return response()->json(['result' => true, 'accounts' => $accounts], 200);
    }
}
