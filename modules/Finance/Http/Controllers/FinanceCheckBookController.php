<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
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
        $banks = FinanceBank::with(['finance_agencies' => function($queryAgencies) {
            return $queryAgencies->with(['bank_accounts' => function($queryAccounts) {
                return $queryAccounts->with('finance_check_books');
            }]);
        }])->orderBy('name')->get()->filter(function($bank) {
            foreach ($bank->finance_agencies as $agency) {
                foreach ($agency->bank_accounts as $account) {
                    foreach ($account->finance_check_books as $check_book) {
                        return $bank;
                    }
                }
            }
        });

        $financeCheckBooks = [];

        foreach ($banks as $bank) {
            foreach ($bank->finance_agencies as $agency) {
                foreach ($agency->bank_accounts as $account) {
                    $checkBookCode = '';
                    foreach ($account->finance_check_books as $check_book) {
                        if ($checkBookCode !== $check_book->code) {
                            $numbers = [];
                            foreach ($account->finance_check_books as $check) {
                                array_push($numbers, $check->number);
                            }
                            $checkBookCode = $check_book->code;
                            array_push($financeCheckBooks, [
                                'finance_bank' => $bank->name, 'code' => $checkBookCode, 'id' => $checkBookCode,
                                'checks' => $account->finance_check_books->count(),
                                'finance_bank_id' => $bank->id, 'finance_bank_account_id' => $account->id,
                                'numbers' => $numbers,
                                'cant_checks' => $account->finance_check_books->first()->number . 
                                                 '...' . $account->finance_check_books->last()->number,
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
     * @return \Illuminate\View\View
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
            'code' => 'required',
            'finance_bank_account_id' => 'required',
            'numbers' => 'required|array|min:1'
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
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
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
