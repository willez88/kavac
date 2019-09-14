<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\CodeSetting;
use App\Models\DocumentStatus;
use Modules\Budget\Models\BudgetModification;
use Modules\Budget\Models\BudgetModificationAccount;
use Modules\Budget\Models\BudgetSubSpecificFormulation;

class BudgetModificationController extends Controller
{
    use ValidatesRequests;

    public $header;

    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:budget.modificacions.list', ['only' => 'index', 'vueList']);
        /*$this->middleware('permission:budget.modificacions.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.modificacions.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.modificacions.delete', ['only' => 'destroy']);*/

        /** @var array Arreglo de opciones a implementar en el formulario */
        $this->header = [
            'route' => 'budget.modifications.store',
            'method' => 'POST',
            'role' => 'form',
            'class' => 'form-horizontal',
        ];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('budget::modifications.list');
    }

    /**
     * Muestra el formulario para crear un crédito adicional
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return Response
     */
    public function create($type)
    {
        $viewTemplate = ($type==="AC")
                        ? 'aditional_credits'
                        : (($type==='RE')
                          ? 'reductions'
                          : (($type==="TR")
                            ? 'transfers' : ''));

        return view("budget::$viewTemplate.create-edit-form", compact('type'));
    }

    /**
     * Registra información de la modificación presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        /** @var array Arreglo con las reglas de validación para el registro */
        $rules = [
            'approved_at' => 'required|date',
            'description' => 'required',
            'document' => 'required',
            'institution_id' => 'required',
            'budget_account_id' => 'required|array|min:1'
        ];

        /** @var array Arreglo con los mensajes para las reglas de validación */
        $messages = [
            'budget_account_id.required' => 'Las cuentas presupestarias son obligatorias.',
        ];

        /** @var object Contiene la configuración del código establecido para el registro */
        if (!is_null($request->type)) {
            switch ($request->type) {
                case 'AC':
                    $codeFilter = 'budget.aditional-credits';
                    break;
                case 'RE':
                    $codeFilter = 'budget.reductions';
                    break;
                case 'TR':
                    $codeFilter = 'budget.transfers';
                    break;
                default:
                    $codeFilter = '';
                    break;
            }
            /** @var object Contiene la configuración del código establecido para el registro */
            $codeSetting = CodeSetting::getSetting(BudgetModification::class, $codeFilter)->first();
        }

        if (!isset($codeSetting) || !$codeSetting) {
            $rules['code'] = 'required';
            $message['code.required'] = 'Debe configurar previamente el formato para el código a generar';
        }

        $this->validate($request, $rules, $messages);

        /** @var object Obtiene el registro del documento con estatus aprobado */
        $documentStatus = DocumentStatus::getStatus('AP');
        /** @var string Contiene el código generado para el registro a crear */
        $code = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            date((strlen($codeSetting->format_year) === 2) ? "y" : "Y"),
            BudgetModification::class,
            'code'
        );

        DB::transaction(function () use ($request, $code, $documentStatus) {
            $type = ($request->type==="AC") ? 'C' : (($request->type==="RE") ? 'R' : 'T');

            /** @var object Objeto que contiene los datos de la modificación presupuestaria creada */
            $budgetModification = BudgetModification::create([
                'type' => $type,
                'code' => $code,
                'approved_at' => $request->approved_at,
                'description' => $request->description,
                'document' => $request->document,
                'institution_id' => $request->institution_id,
                'document_status_id' => $documentStatus->id
            ]);

            foreach ($request->budget_account_id as $account) {

                /** @var object Obtiene la formulación correspondiente a la acción específica seleccionada */
                $formulation = BudgetSubSpecificFormulation::currentFormulation(
                    $account['from_specific_action_id']
                )->first();

                if ($formulation) {
                    BudgetModificationAccount::create([
                        'amount' => $account['from_amount'],
                        'operation' => ($type==="C") ? 'I' : 'D',
                        'budget_sub_specific_formulation_id' => $formulation->id,
                        'budget_account_id' => $account['from_account_id'],
                        'budget_modification_id' => $budgetModification->id
                    ]);
                }

                if (isset($account['to_account_id'])) {
                    /** @var object Obtiene la formulación correspondiente a la acción específica a donde transferir
                    los recursos */
                    $formulation_transfer = BudgetSubSpecificFormulation::currentFormulation(
                        $account['to_specific_action_id']
                    );

                    if ($formulation_transfer) {
                        BudgetModificationAccount::create([
                            'amount' => $account['to_amount'],
                            'operation' => 'I',
                            'budget_sub_specific_formulation_id' => $formulation_transfer->id,
                            'budget_account_id' => $account['to_account_id'],
                            'budget_modification_id' => $budgetModification->id
                        ]);
                    }
                }
            }
        });

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json([
            'result' => true, 'redirect' => route('budget.modifications.index')
        ], 200);
    }

    public function edit($type, BudgetModification $modification)
    {
        $viewTemplate = ($type==="AC")
                        ? 'aditional_credits'
                        : (($type==='RE')
                          ? 'reductions'
                          : (($type==="TR")
                            ? 'transfers' : ''));
        $model = $modification;

        return view("budget::$viewTemplate.create-edit-form", compact('type', 'model'));
    }

    public function update(Request $request, BudgetModification $modification)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        /** @var object Objeto con información de la modificación presupuestaria a eliminar */
        $budgetModification = BudgetModification::find($id);

        if ($budgetModification) {
            $budgetModification->delete();
        }

        return response()->json(['record' => $budgetModification, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los registros a mostrar en listados de componente Vue
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return json Json con datos de la perición realizada
     */
    public function vueList($type)
    {
        switch ($type) {
            case 'AC':
                $tp = 'C';
                break;
            case 'RE':
                $tp = 'R';
                break;
            case 'TR':
                $tp = 'T';
                break;
            default:
                $tp = '';
                break;
        }

        $records = ($tp) ? BudgetModification::where('type', $tp)->get() : [];
        return response()->json([
            'records' => $records
        ], 200);
    }
}
