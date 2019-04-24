<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Accounting\Models\AccountingSeatCategory;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingAccount;

/**
 * @class AccountingSeatController
 * @brief Controlador de asientos contables
 * 
 * Clase que gestiona los asientos contable
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingSeatController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $categories = [];
        array_push($categories, [
                'id' => 0,
                'text' => 'Todos'
            ]);
        foreach (AccountingSeatCategory::all() as $category) {
            array_push($categories, [
                'id' => $category->id,
                'text' => $category->name,
            ]);
        }
        $categories = json_encode($categories);
        return view('accounting::seating.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $AccountingAccounts = $this->getAccountingAccount();
        return view('accounting::seating.create',compact('AccountingAccounts'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $newSeating = new AccountingSeat();
        $newSeating->from_date = $request->data['date'];
        $newSeating->reference = $request->data['reference'];
        $newSeating->concept = $request->data['concept'];
        $newSeating->observations = $request->data['observations'];
        $newSeating->tot_debit = $request->data['totDebit'];
        $newSeating->tot_assets = $request->data['totAssets'];
        $newSeating->save();

        foreach ($request->accountingAccounts as $account) {
            $newAccSeat = new AccountingSeatAccount();
            $newAccSeat->accounting_seat_id = $newSeating->id;
            $newAccSeat->accounting_account_id = $account['id'];
            $newAccSeat->debit = $account['debit'];
            $newAccSeat->assets = $account['assets'];
            $newAccSeat->save();
        }
        return response()->json(['message'=>'Success'],200);
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
        AccountingSeat::find($id)->delete();
        return response()->json(['message'=>'Success', 200]);
    }

    /**
     * consulta y filta los registros de asientos contables
     * @param Request $request 
     * @return Response
     */
    public function FilterRecords(Request $request)
    {
        $records = [];
        $FilterByOrigin = [];
        if ($request->typeSearch == 'reference') {
            foreach (AccountingSeat::with('accounting_accounts.account')->orderBy('from_date','ASC')->get() as $seating) {
                if (count(explode($request->data['reference'], $seating->reference)) > 1) {
                    array_push($records, $seating);
                }
            }
        }else if ($request->typeSearch == 'origin') {
            // todos los asientos o solo una categoria de origen
            $FilterByOrigin = ($request->data['category'] == 0) ?
                 AccountingSeat::with('accounting_accounts.account')->where('approved',true)->orderBy('from_date','ASC')->get() : 
                 AccountingSeat::with('accounting_accounts.account')->where('approved',true)->where('generated_by_id',$request->data['category'])->orderBy('from_date','ASC')->get();

                 // Filtrado para unos meses o años en general
            if ($request->filterDate == 'generic') {
                $fltForYear = [];
                        // todas las fechas
                    if ($request->data['year'] == 0 && $request->data['month'] == 0) {
                        $records = $FilterByOrigin;
                    }
                    else{
                        // filtardo por año
                        if ($request->data['year'] == 0) { // todos los años
                            $fltForYear = $FilterByOrigin;
                        }else{
                            foreach ($FilterByOrigin as $record) {
                                if (explode('-',$record->from_date)[0] == $request->data['year']) {
                                    array_push($fltForYear, $record);
                                }
                            }
                        }

                        // filtrado por mes
                        if ($request->data['month'] == 0) { // todos los meses
                            $records = $fltForYear;
                        }else{
                            foreach ($fltForYear as $record) {
                                if (explode('-',$record->from_date)[1] == $request->data['month']) {
                                    array_push($records, $record);
                                }
                            }
                        }
                    }
            } else {
                // Filtrado en un rango especifico de fechas
                $records = $FilterByOrigin->whereBetween("from_date",[$request->data['init'],$request->data['end']]);
            }
        }
        return response()->json(['records'=>$records,'message'=>'Success', 200]);
    }
    /**
     * Obtiene los registros de las cuentas patrimoniales
     * @author  Juan Rosas <JuanFBass17@gmail.com>
     * @return json [JSON con la información de las cuentas formateada]
    */
    public function getAccountingAccount()
    {
        $records = [];
        array_push($records, [
                'id' => '',
                'text' => 'Seleccione...'
            ]);
        foreach (AccountingAccount::orderBy('group','ASC')
                                    ->orderBy('subgroup','ASC')
                                    ->orderBy('item','ASC')
                                    ->orderBy('generic','ASC')
                                    ->orderBy('specific','ASC')
                                    ->orderBy('subspecific','ASC')
                                    ->get() as $account) {
            if ($account->active) {
                array_push($records, [
                    'id' => $account->id,
                    'text' => "{$account->getCode()} - {$account->denomination}"
                ]);
            }
        };
        return json_encode($records);
    }


// controladores para la gestión de asientos contable no aprobados

    // Listado
    public function unapproved()
    {
        $seating = AccountingSeat::with('accounting_accounts.account.account_converters.budget_account')->where('approved',false)->orderBy('from_date','ASC')->get();

        return view('accounting::seating.unapproved',compact('seating'));
    }
    /**
     * aprueba el asiento contable
     * @param Request $request
     * @return Response
     */
    public function approve($id)
    {
        $seating = AccountingSeat::find($id);
        $seating->approved = true;
        $seating->save();
        return response()->json(['message'=>'Success', 200]);
    }

    /**
     * elimina el asiento contable
     * @param Request $request
     * @return Response
     */
}
