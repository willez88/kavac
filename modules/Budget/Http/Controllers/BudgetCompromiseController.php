<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Budget\Models\BudgetCompromise;
use Modules\Budget\Models\BudgetStage;

class BudgetCompromiseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('budget::compromises.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('budget::compromises.create-edit-form');
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
        return view('budget::edit');
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
    public function destroy()
    {
    }

    /**
     * Obtiene los registros a mostrar en listados de componente Vue
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse Devuelve un JSON con la información de las formulaciones
     */
    public function vueList()
    {
        return response()->json([
            'records' => BudgetCompromise::with(
                'budgetCompromiseDetails',
                'budgetStages',
                'documentStatus'
            )->orderBy('compromised_at')->get()
        ], 200);
    }

    /**
     * Obtiene las fuentes de documentos que aún no han sido comprometidos, solo (PRE)comprometidos y/o (PRO)gramados
     *
     * @method     getDocumentSources
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     \Illuminate\Http\JsonResponse    Devuelve un JSON con la información de registros por comprometer
     */
    public function getDocumentSources()
    {
        /** @var object Obtiene todos los registros de fuentes de documentos que aún no han sido comprometidos */
        $compromises = BudgetStage::where('type', 'PRE')->orWhere('type', 'PRO')->with([
            'budgetCompromise' => function ($budgetCompromise) {
                return $budgetCompromise->whereNull('compromised_at');
            }
        ]);
        return response(['records' => $compromises], 200);
    }
}
