<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Budget\Models\BudgetCompromise;
use App\Models\DocumentStatus;
use App\Models\CodeSetting;
use App\Models\Tax;
use Modules\Budget\Models\BudgetSpecificAction;
use DB;

class BudgetCompromiseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('budget::compromises.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('budget::compromises.create-edit-form');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'compromised_at' => ['required', 'date'],
            'description' => ['required'],
            ''
        ]);

        $codeSetting = CodeSetting::where("model", BudgetCompromise::class)->first();

        if (!$codeSetting) {
            return response()->json(['result' => false, 'message' => [
                'type' => 'custom', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
            ]], 200);
        }

        $code = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) === 2) ? date("y", mktime(0, 0, 0, 1, 1, $year)) : $year,
            BudgetCompromise::class,
            'code'
        );

        $compromisedYear = explode("-", $request->compromised_at)[0];

        DB::transaction(function () use ($request, $code, $compromisedYear) {
            /** @var Object Estado inicial del compromiso establecido a elaborado */
            $documentStatus = DocumentStatus::where('action', 'EL')->first();

            $compromise = BudgetCompromise::create([
                'document_number' => $request->source_document,
                'institution_id' => $request->institution_id,
                'compromised_at' => $request->compromised_at,
                'description' => $request->description,
                'code' => $code,
                'document_status_id' => $documentStatus->id
            ]);

            foreach ($request->accounts as $account) {
                $spac = BudgetSpecificAction::find($accounts['specific_action_id']);
                $formulation = $spac->subSpecificFormulations()->where('year', $compromisedYear)->first();
                $tax = Tax::find($account['account_tax_id']);
                $taxHistory = $tax->histories()->orderBy('operation_date', 'desc')->first();
                $taxAmount = ($account['amount'] * (($taxHistory)?$taxHistory->percentage:0)) / 100;
                $compromise->budgetCompromiseDetails()->create([
                    'description' => $account['description'],
                    'amount' => $account['amount'],
                    'tax_amount' => $taxAmount,
                    'tax_id' => $account['account_tax_id'],
                    'budget_account_id' => $account['account_id'],
                    'budget_sub_specific_formulation_id' => $formulation->id
                ]);
            }
        });
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        //return view('budget::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('budget::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Renderable
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
     * @param      integer               $institution_id    Identificador de la institución
     * @param      string                $year              Año de ejercicio económico
     *
     * @return     \Illuminate\Http\JsonResponse    Devuelve un JSON con la información de registros por comprometer
     */
    public function getDocumentSources($institution_id, $year)
    {
        /** @var object Obtiene todos los registros de fuentes de documentos que aún no han sido comprometidos */
        $compromises = BudgetCompromise::where(['compromised_at' => null, 'institution_id' => $institution_id])->with([
            'budgetCompromiseDetails',
            'sourceable',
            'budgetStages' => function ($budgetStages) {
                return $budgetStages->where('type', 'PRE');
            }
        ])->get();
        return response(['records' => $compromises], 200);
    }
}
