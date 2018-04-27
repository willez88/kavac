<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Budget\Models\BudgetAccount;

class BudgetAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $records = BudgetAccount::all();
        return view('budget::accounts.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'budget.accounts.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
        return view('budget::accounts.create-edit-form', compact('header'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        //return view('budget::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        //return view('budget::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        $budgetAccount = BudgetAccount::find($id);

        if ($budgetAccount) {
            $budgetAccount->delete();
        }
        
        return response()->json(['record' => $budgetAccount, 'message' => 'Success'], 200);
    }

    public function vueList()
    {
        return response()->json(['records' => BudgetAccount::all()], 200);
    }
}
