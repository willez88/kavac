<?php

namespace Modules\Budget\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Budget\Models\BudgetAccount;
use Auth;

/**
 * @class BudgetAccountController
 * @brief Controlador de Cuentas Presupuestarias
 * 
 * Clase que gestiona las Cuentas Presupuestarias
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetAccountController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:budget.account.list', ['only' => 'index', 'vueList']);
        $this->middleware('permission:budget.account.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:budget.account.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:budget.account.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de cuentas presupuestarias
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function index()
    {
        /** @var object Objeto que contiene todos los registros de cuentas presupuestarias */
        $records = BudgetAccount::all();
        return view('budget::accounts.list');
    }

    /**
     * Muestra un formulario ara la creación de una cuenta presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function create()
    {
        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = [
            'route' => 'budget.accounts.store', 
            'method' => 'POST', 
            'role' => 'form',
            'class' => 'form-horizontal',
        ];

        /** @var array Arreglo de opciones a representar en la plantilla para su selección */
        $budget_accounts = template_choices(
            'Modules\Budget\Models\BudgetAccount', ['code', '-', 'denomination'], ['subspecific' => '00']
        );

        return view('budget::accounts.create-edit-form', compact('header', 'budget_accounts'));
    }

    /**
     * Crea una nueva cuenta presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required|digits:1',
            'item' => 'required|digits:2',
            'generic' => 'required|digits:2',
            'specific' => 'required|digits:2',
            'subspecific' => 'required|digits:2',
            'denomination' => 'required',
            'account_type' => 'required',
        ]);

        /** @var object Objeto que contiene los datos de la cuenta ya registrada si existe */
        $budgetAccount = BudgetAccount::where('group', request('group'))
                                      ->where('item', request('item'))
                                      ->where('generic', request('generic'))
                                      ->where('specific', request('specific'))
                                      ->where('subspecific', request('subspecific'))
                                      ->where('active', true)->first();

        /**
         * Si la cuenta a registrar ya existe en la base de datos y la nueva cuenta se indica como activa, 
         * se desactiva la cuenta anterior
         */
        if ($budgetAccount && $request->active!==null) {
            /** @var boolean define si la cuenta esta activa */
            $budgetAccount->active = false;
            $budgetAccount->save();
        }

        /** @var object Objeto con información de la cuenta de nivel superior, si existe */
        $parent = BudgetAccount::getParent(
            request('group'), request('item'), request('generic'), request('specific'), request('subspecific')
        );

        /**
         * Registra la nueva cuenta presupuestaria
         */
        BudgetAccount::create([
            'group' => $request->group,
            'item' => $request->item,
            'generic' => $request->generic,
            'specific' => $request->specific,
            'subspecific' => $request->subspecific,
            'denomination' => $request->denomination,
            'resource' => ($request->account_type=="resource"),
            'egress' => ($request->account_type=="egress"),
            'active' => ($request->active!==null),
            'original' => ($request->original!==null),
            'parent_id' => ($parent == false)?null:$parent->id
        ]);
        
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('budget.accounts.index');
    }

    /**
     * Muestra información de la cuenta presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return Response
     */
    public function show()
    {
        //return view('budget::show');
    }

    /**
     * Muestra el formulario para la edición de una cuenta presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador de la cuenta presupuestaria a modificar
     * @return Response
     */
    public function edit($id)
    {
        /** @var object Objeto con información de la cuenta presupuestaria a modificar */
        $budgetAccount = BudgetAccount::find($id);

        /** @var array Arreglo de opciones a implementar en el formulario */
        $header = [
            'route' => ['budget.accounts.update', $budgetAccount->id], 
            'method' => 'PUT', 
            'role' => 'form'
        ];

        /** @var array Arreglo de opciones a representar en la plantilla para su selección */
        $budget_accounts = template_choices(
            'Modules\Budget\Models\BudgetAccount', ['code', '-', 'denomination'], ['subspecific' => '00']
        );

        /** @var object Objeto con datos del modelo a modificar */
        $model = $budgetAccount;

        return view('budget::accounts.create-edit-form', compact('header', 'budget_accounts', 'model'));
    }

    /**
     * Actualiza los datos de la cuenta presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @param  integer $id      Identificador de la cuenta presupuestaria a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'group' => 'required|digits:1',
            'item' => 'required|digits:2',
            'generic' => 'required|digits:2',
            'specific' => 'required|digits:2',
            'subspecific' => 'required|digits:2',
            'denomination' => 'required',
            'account_type' => 'required',
        ]);

        /** @var object Objeto con información de la cuenta presupuestaria a modificar */
        $budgetAccount = BudgetAccount::find($id);
        $budgetAccount->fill($request->all());
        $budgetAccount->save();

        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('budget.accounts.index');
    }

    /**
     * Elimina una cuenta presupuestaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificador de la cuenta presupuestaria a eliminar
     * @return Response
     */
    public function destroy($id)
    {
        /** @var object Objeto con datos de la cuenta presupuestaria a eliminar */
        $budgetAccount = BudgetAccount::find($id);

        if ($budgetAccount) {
            if ($budgetAccount->restrictDelete()) {
                return response()->json(['error' => true, 'message' => 'El registro no se puede eliminar'], 200);
            }
            $budgetAccount->delete();
        }
        
        return response()->json(['record' => $budgetAccount, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene listado de registros
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function vueList()
    {
        /** @var array Arreglo con información de cuentas presupuestarias */
        $budgetAccounts = [];
        foreach (BudgetAccount::all() as $budgetAccount) {
            array_push($budgetAccounts, [
                'code' => $budgetAccount->code, 'denomination' => $budgetAccount->denomination,
                'original' => $budgetAccount->original?'SI':'NO', 'id' => $budgetAccount->id
            ]);
        }
        return response()->json(['records' => $budgetAccounts], 200);
    }

    /**
     * Obtiene un listado de cuentas de egreso
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  boolean $to_formulate Indica si las cuentas a retornar son para formulación, 
     *                               en cuyo caso incluye la inicialización de variables para cada cuenta
     * @return \Illuminate\Http\JsonResponse
     */
    public function egressAccounts($to_formulate = false)
    {
        /** @var array Arreglo de cuentas presupuestarias */
        $records = [];

        /** @var object Objeto que contiene los datos de las cuentas presupuestarias de egreso activas */
        $accounts = BudgetAccount::where(['active' => true, 'egress' => 'true'])->get();

        foreach ($accounts as $account) {
            /** @var array Arreglo con información de la cuenta presupuestaria */
            $account_data = [
                'id' => $account->id, 'code' => $account->code, 'denomination' => $account->denomination,
                'group' => $account->group, 'item' => $account->item, 'generic' => $account->generic, 
                'specific' => $account->specific, 'subspecific' => $account->subspecific, 
                'tax_id' => $account->tax_id
            ];
            if ($to_formulate) {
                /** 
                 * @var array Arreglo que agrega información extra a la cuenta presupuestaria en caso de que la misma 
                 * sea para una formulación de presupuesto
                 */
                $account_data = array_merge($account_data, [
                    'formulated' => false, 'locked' => ($account->specific==='00'),
                    'total_real_amount' => 0, 'total_estimated_amount' => 0, 'total_year_amount' => 0,
                    'jan_amount' => 0, 'feb_amount' => 0, 'mar_amount' => 0, 'apr_amount' => 0, 
                    'may_amount' => 0, 'jun_amount' => 0, 'jul_amount' => 0, 'aug_amount' => 0, 
                    'sep_amount' => 0, 'oct_amount' => 0, 'nov_amount' => 0, 'dec_amount' => 0
                ]);
            }
            array_push($records, $account_data);
        }

        return response()->json(['records' => $records], 200);
    }

    /**
     * Obtiene detalles de una cuenta presupuestaria
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  integer $id Identificar de la cuenta presupuestaria de la cual se requiere información
     * @return JSON        JSON con los datos de la cuenta presupuestaria
     */
    public function getDetail($id)
    {
        return response()->json([
            'result' => true, 'record' => BudgetAccount::find($id)
        ], 200);
    }

    /**
     * Determina el próximo valor disponible para la cuenta a ser agregada
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param [integer] $parent_id Identificador de la cuenta padre de la cual se va a generar el nuevo código
     * @return JSON                JSON con los datos del nuevo código generado
     */
    public function setChildrenAccount($parent_id)
    {
        /** @var object Objeto con información de la cuenta presupuestaria de nivel superior */
        $parent = BudgetAccount::find($parent_id);

        /** @var string Contiene el código del ítem */
        $item = $parent->item;
        /** @var string Contiene el código de la genérica */
        $generic = $parent->generic;
        /** @var string Contiene el código de la específica */
        $specific = $parent->specific;
        /** @var string Contiene el código de la sub específica */
        $subspecific = $parent->subspecific;

        if ($parent->item === "00") {
            /** @var object Contiene información de la cuenta presupuestaria por el código del ítem */
            $currentItem = BudgetAccount::where(['group' => $parent->group])->orderBy('item', 'desc')->first();
            /** @var integer Contiene el código inmediatamente disponible para su registro */
            $item = (strlen(intval($currentItem->item)) < 2|| intval($currentItem->item) < 99) 
                    ? (intval($currentItem->item) + 1) : $currentItem->item;
            /** @var string Determina la longitud de la cadena para agregar un cero a la izquierda en caso de requerirlo */
            $item = (strlen($item) === 1) ? "0$item" : $item;
        }
        else if ($parent->generic === "00") {
            /** @var object Contiene información de la cuenta presupuestaria por el código de la genérica */
            $currentGeneric = BudgetAccount::where(['group' => $parent->group, 'item' => $parent->item])
                                           ->orderBy('generic', 'desc')->first();
            /** @var integer Contiene el código inmediatamente disponible para su registro */
            $generic = (strlen(intval($currentGeneric->generic)) < 2 || intval($currentGeneric->generic) < 99) 
                       ? (intval($currentGeneric->generic) + 1) : $currentGeneric->generic;
            /** @var string Determina la longitud de la cadena para agregar un cero a la izquierda en caso de requerirlo */
            $generic = (strlen($generic) === 1) ? "0$generic" : $generic;
        }
        else if ($parent->specific === "00") {
            /** @var object Contiene información de la cuenta presupuestaria por el código de la específica */
            $currentSpecific = BudgetAccount::where([
                'group' => $parent->group, 'item' => $parent->item, 'generic' => $parent->generic
            ])->orderBy('specific', 'desc')->first();
            /** @var integer Contiene el código inmediatamente disponible para su registro */
            $specific = (strlen(intval($currentSpecific->specific)) < 2 || intval($currentSpecific->specific) < 99) 
                        ? (intval($currentSpecific->specific) + 1) : $currentSpecific->specific;
            /** @var string Determina la longitud de la cadena para agregar un cero a la izquierda en caso de requerirlo */
            $specific = (strlen($specific) === 1) ? "0$specific" : $specific;
        }
        else if ($parent->subspecific === "00") {
            /** @var object Contiene información de la cuenta presupuestaria por el código de la sub específica */
            $currentSubSpecific = BudgetAccount::where([
                'group' => $parent->group, 'item' => $parent->item, 'generic' => $parent->generic, 'specific' => $parent->specific
            ])->orderBy('subspecific', 'desc')->first();
            /** @var integer Contiene el código inmediatamente disponible para su registro */
            $subspecific = (
                strlen(intval($currentSubSpecific->subspecific)) < 2 || intval($currentSubSpecific->subspecific) < 99
            ) ? (intval($currentSubSpecific->subspecific) + 1) : $currentSubSpecific->subspecific;
            /** @var string Determina la longitud de la cadena para agregar un cero a la izquierda en caso de requerirlo */
            $subspecific = (strlen($subspecific) === 1) ? "0$subspecific" : $subspecific;
        }

        /** @var array Arreglo con información de la nueva cuenta presupuestaria de nivel inferior disponible */
        $newAccount = [
            'group' => $parent->group, 'item' => (string)$item, 'generic' => (string)$generic, 
            'specific' => (string)$specific, 'subspecific' => (string)$subspecific,
            'denomination' => $parent->denomination, 'resource' => $parent->resource, 'egress' => $parent->egress
        ];

        return response()->json(['result' => true, 'new_account' => $newAccount], 200);
    }
}
