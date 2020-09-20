<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Finance\Models\FinanceBank;
use Modules\Finance\Models\FinanceCheckBook;

/**
 * @class FinanceCheckBookController
 * @brief Controlador para las chequeras
 *
 * Clase que gestiona las chequeras
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class FinanceCheckBookController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $banks = FinanceBank::with(['financeAgencies' => function ($queryAgencies) {
            return $queryAgencies->with(['bankAccounts' => function ($queryAccounts) {
                return $queryAccounts->with('financeCheckBooks');
            }]);
        }])->orderBy('name')->get()->filter(function ($bank) {
            foreach ($bank->financeAgencies as $agency) {
                foreach ($agency->bankAccounts as $account) {
                    foreach ($account->financeCheckBooks as $check_book) {
                        return $bank;
                    }
                }
            }
        });

        $financeCheckBooks = [];

        foreach ($banks as $bank) {
            foreach ($bank->financeAgencies as $agency) {
                foreach ($agency->bankAccounts as $account) {
                    $checkBookCode = '';
                    foreach ($account->financeCheckBooks as $check_book) {
                        if ($checkBookCode !== $check_book->code) {
                            $numbers = [];
                            foreach ($account->financeCheckBooks as $check) {
                                array_push($numbers, $check->number);
                            }
                            $checkBookCode = $check_book->code;
                            array_push($financeCheckBooks, [
                                'finance_bank' => $bank->name, 'code' => $checkBookCode, 'id' => $checkBookCode,
                                'checks' => $account->financeCheckBooks->count(),
                                'finance_bank_id' => $bank->id, 'finance_bank_account_id' => $account->id,
                                'numbers' => $numbers,
                                'cant_checks' => $account->financeCheckBooks->first()->number .
                                                 '...' . $account->financeCheckBooks->last()->number,
                            ]);
                        }
                    }
                }
            }
        }
        return response()->json(['records' => $financeCheckBooks], 200);
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
            'code' => ['required'],
            'finance_bank_account_id' => ['required'],
            'numbers' => ['required', 'array', 'min:1']
        ]);

        foreach ($request->numbers as $number) {
            FinanceCheckBook::create([
                'code' => $request->code,
                'finance_bank_account_id' => $request->finance_bank_account_id,
                'number' => $number
            ]);
        }

        return response()->json(['result' => true, 'message' => 'Success'], 200);
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
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $checksUsed = FinanceCheckBook::where(['code' => $id, 'used' => true])->get();

        if (!$checksUsed->isEmpty()) {
            return response()->json([
                'error' => true, 'message' => 'La chequera posee cheques emitidos y no puede ser eliminada'
            ], 200);
        }

        foreach (FinanceCheckBook::where('code', $id)->get() as $check) {
            $check->delete();
        }
        return response()->json(['message' => 'Success'], 200);
    }
}
