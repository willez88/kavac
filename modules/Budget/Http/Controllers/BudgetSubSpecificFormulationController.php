<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;

use App\Models\CodeSetting;
use Modules\Budget\Models\DocumentStatus;
use Modules\Budget\Models\BudgetSubSpecificFormulation;
use Modules\Budget\Models\BudgetAccountOpen;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Imports\DataImport;

/**
 * @class BudgetSubSpecificFormulationController
 * @brief Controlador de formulaciones de presupuesto por sub específicas
 *
 * Clase que gestiona las formulaciones de presupuesto por sub específicas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetSubSpecificFormulationController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:budget.formulation.list', ['only' => 'index', 'vueList', 'show']);
        $this->middleware('permission:budget.formulation.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.formulation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.formulation.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de formulaciones de presupuesto registradas
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $records = BudgetSubSpecificFormulation::all();
        return view('budget::formulations.list');
    }

    /**
     * Muestra el formulario para el registro de datos de la formulación de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('budget::formulations.create-edit-form');
    }

    /**
     * Guarda información para una formulación de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'institution_id' => 'required',
            'specific_action_id' => 'required',
            'currency_id' => 'required',
            'formulated_accounts.*' => 'required'
        ]);

        $year = date("Y");

        $documentStatus = DocumentStatus::where('action', 'EL')->first();
        $codeSetting = CodeSetting::where("model", BudgetSubSpecificFormulation::class)->first();

        if (!$codeSetting) {
            return response()->json(['result' => false, 'message' => [
                'type' => 'custom', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
            ]], 200);
        }

        $validateStore = BudgetSubSpecificFormulation::validateStore([
            'budget_specific_action_id' => $request->specific_action_id,
            'currency_id' => $request->currency_id, 'year' => $year,
            'institution_id' => $request->institution_id
        ]);
        if (!$validateStore) {
            return response()->json(['result' => false, 'message' => [
                'type' => 'custom', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'danger',
                'text' => 'Ya existe una formulación con los datos suministrados'
            ]], 200);
        }

        $code = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) === 2) ? date("y") : $year,
            BudgetSubSpecificFormulation::class,
            'code'
        );

        DB::transaction(function () use ($request, $code, $year, $documentStatus) {
            $formulation = BudgetSubSpecificFormulation::create([
                'code' => $code, 'year' => $year,
                'total_formulated' => (float)$request->formulated_accounts[0]['total_year_amount'],
                'budget_specific_action_id' => $request->specific_action_id,
                'currency_id' => $request->currency_id,
                'institution_id' => $request->institution_id,
                'document_status_id' => $documentStatus->id
            ]);

            foreach ($request->formulated_accounts as $formulated_account) {
                $f_acc = (object)$formulated_account;
                BudgetAccountOpen::create([
                    'jan_amount' => (float)$f_acc->jan_amount, 'feb_amount' => (float)$f_acc->feb_amount,
                    'mar_amount' => (float)$f_acc->mar_amount, 'apr_amount' => (float)$f_acc->apr_amount,
                    'may_amount' => (float)$f_acc->may_amount, 'jun_amount' => (float)$f_acc->jun_amount,
                    'jul_amount' => (float)$f_acc->jul_amount, 'aug_amount' => (float)$f_acc->aug_amount,
                    'sep_amount' => (float)$f_acc->sep_amount, 'oct_amount' => (float)$f_acc->oct_amount,
                    'nov_amount' => (float)$f_acc->nov_amount, 'dec_amount' => (float)$f_acc->dec_amount,
                    'total_year_amount' => (float)$f_acc->total_year_amount,
                    'total_real_amount' => (float)$f_acc->total_real_amount,
                    'total_estimated_amount' => (float)$f_acc->total_estimated_amount,
                    'budget_account_id' => $f_acc->id,
                    'budget_sub_specific_formulation_id' => $formulation->id
                ]);
            }
        });

        return response()->json(['result' => true], 200);
    }

    /**
     * Muestra información de una formulación de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $formulation = BudgetSubSpecificFormulation::find($id);
        return view('budget::formulations.show', compact('formulation'));
    }

    /**
     * Muestra el formulario de modificación para una formulación de presupuesto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $formulation = BudgetSubSpecificFormulation::find($id);
        return view('budget::formulations.create-edit-form', compact("formulation"));
    }

    /**
     * Actualiza la información de una formulación presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  Request $request
     * @param  integer $id Identificador del registro a actualizar
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $formulation = BudgetSubSpecificFormulation::find($id);

        if (isset($request->assigned) && $request->assigned) {
            $formulation->assigned = $request->assigned;
            $documentStatus = DocumentStatus::where('action', 'AP')->first();
            $formulation->document_status_id = $documentStatus->id;
            $formulation->save();

            $request->session()->flash('message', [
                'type' => 'other', 'icon' => 'screen-ok',
                'text' => 'La formulación de presupuesto fue asignada y no puede ser modificada'
            ]);
        } elseif ($formulation->assigned) {
            $request->session()->flash('message', [
                'type' => 'other', 'icon' => 'screen-ok',
                'text' => 'La formulación de presupuesto ya se encuentra asignada y no puede ser modificada'
            ]);
        } else {
            $this->validate($request, [
                'institution_id' => 'required',
                'specific_action_id' => 'required',
                'currency_id' => 'required',
                'formulated_accounts.*' => 'required'
            ]);

            DB::transaction(function () use ($request, $formulation) {
                $formulation->total_formulated = (float)$request->formulated_accounts[0]['total_year_amount'];
                $formulation->budget_specific_action_id = $request->specific_action_id;
                $formulation->currency_id = $request->currency_id;
                $formulation->institution_id = $request->institution_id;
                $formulation->save();

                $formulation->accountOpens()->delete();

                foreach ($request->formulated_accounts as $formulated_account) {
                    $f_acc = (object)$formulated_account;
                    BudgetAccountOpen::create([
                        'jan_amount' => (float)$f_acc->jan_amount, 'feb_amount' => (float)$f_acc->feb_amount,
                        'mar_amount' => (float)$f_acc->mar_amount, 'apr_amount' => (float)$f_acc->apr_amount,
                        'may_amount' => (float)$f_acc->may_amount, 'jun_amount' => (float)$f_acc->jun_amount,
                        'jul_amount' => (float)$f_acc->jul_amount, 'aug_amount' => (float)$f_acc->aug_amount,
                        'sep_amount' => (float)$f_acc->sep_amount, 'oct_amount' => (float)$f_acc->oct_amount,
                        'nov_amount' => (float)$f_acc->nov_amount, 'dec_amount' => (float)$f_acc->dec_amount,
                        'total_year_amount' => (float)$f_acc->total_year_amount,
                        'total_real_amount' => (float)$f_acc->total_real_amount,
                        'total_estimated_amount' => (float)$f_acc->total_estimated_amount,
                        'budget_account_id' => $f_acc->id,
                        'budget_sub_specific_formulation_id' => $formulation->id
                    ]);
                }
            });

            return response()->json(['result' => true], 200);
        }

        return redirect()->back();
    }

    /**
     * Elimina un registro en particular
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $budgetFormulation = BudgetSubSpecificFormulation::find($id);

        if ($budgetFormulation) {
            $budgetFormulation->delete();
        }

        return response()->json(['record' => $budgetFormulation, 'message' => 'Success'], 200);
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
            'records' => BudgetSubSpecificFormulation::with('currency', 'institution')->with('specific_action')->get()
        ], 200);
    }

    /**
     * Obtiene los registros de presupuestos formulados
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $id Identificador de la formulación a consultar
     * @return \Illuminate\Http\JsonResponse        Devuelve un JSON con la información consultada
     */
    public function getFormulation($id)
    {
        $formulation = BudgetSubSpecificFormulation::where('id', $id)
                       ->with(['currency', 'account_opens', 'specific_action' => function ($specifiAction) {
                           return $specifiAction->with(['specificable' => function ($specificable) {
                               return $specificable->with('department');
                           }]);
                       }])->first();

        return response()->json(['result' => true, 'formulation' => $formulation], 200);
    }

    /**
     * Obtiene la disponibilidad de las cuentas aperturadas
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $specific_action_id      Identificador de la acción específica
     * @param  integer $account_id              Identificador de la cuenta presupuestaria
     * @return \Illuminate\Http\JsonResponse    Devuelve un JSON con la disponibilidad de la cuenta consultada
     */
    public function getAvailabilityOpenedAccounts($specific_action_id, $account_id)
    {
        $account_data = ['account_id' => $account_id, 'available' => 'Sin apertura'];

        $formulation = BudgetSubSpecificFormulation::currentFormulation($specific_action_id)
                                                   ->with(['account_opens' => function ($account) use ($account_id) {
                                                       /** Devuelve, si existe, la cuenta formulada */
                                                       return $account->where('budget_account_id', $account_id)
                                                                      ->first();
                                                   }, 'modification_accounts' => function ($account) use ($account_id) {
                                                       /**
                                                        * Devuelve, si existen, las cuentas agregadas o modificadas
                                                        * mediante la asignación de créditos adicionales, reducciones
                                                        * o traspasos
                                                        */
                                                       return $account->where('budget_account_id', $account_id)->get();
                                                   }])->first();

        $available = 0;
        foreach ($formulation->modification_accounts as $modified_account) {
            # calculo de saldo para cada una de las cuentas
        }

        if ($available > 0) {
            $account_data['available'] = $available;
        }

        return response()->json(['result' => true, 'account' => $account_data], 200);
    }

    /**
     * Importa datos de una formulación a partir de un archivo de hoja de cálculo
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse Devuelve los registros a importar
     */
    public function importFormulation()
    {
        $headings = (new HeadingRowImport)->toArray(request()->file('file'));
        $records = Excel::toArray(new DataImport, request()->file('file'))[0];
        $msg = '';

        if (count($headings) < 1 || $headings[0] < 1) {
            $msg = 'El archivo no contiene las cabeceras de los datos a importar.';
        } elseif (count($headings) === 1 && $headings[0] >= 1) {
            $validHeads = [
                'codigo', 'total_real', 'total_estimado', 'total_anho', 'ene', 'feb', 'mar',
                'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic'
            ];
            foreach ($validHeads as $vh) {
                if (!in_array($vh, $headings[0][0])) {
                    $msg = "El archivo no contiene una de las cabeceras requeridas.";
                    break;
                }
            }
        } elseif (count($records) < 1) {
            $msg = "El archivo no contiene registros a ser importados.";
        }

        foreach ($records as $record) {
            $rec = (object)$record;

            if (!is_null($rec->total_real) && !is_numeric($rec->total_real)) {
            }
        }
        if (!empty($msg)) {
            return response()->json(['result' => false, 'message' => $msg], 200);
        }

        return response()->json([
            'result' => true,
            'records' => Excel::toArray(new DataImport, request()->file('file'))[0]
        ], 200);
    }
}
