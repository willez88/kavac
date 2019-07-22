<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingSeatAccount; 
use Modules\Accounting\Models\AccountingAccount;
use Auth;
/**
 * @class AccountingAccountController
 * @brief Controlador de Cuentas patrimoniales
 * 
 * Clase que gestiona las Cuentas patrimoniales
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingAccountController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.account.list', ['only' => 'index']);
        $this->middleware('permission:accounting.account.create', ['only' => ['store']]);
        $this->middleware('permission:accounting.account.edit', ['only' => ['update']]);
        $this->middleware('permission:accounting.account.delete', ['only' => 'destroy']);
    }
    
    /**
     * Muestra un listado de cuentas patrimoniales
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return view
     */
    public function index()
    {
        $accounts_list = $this->getAccounts();
        return response()->json(['records'=>$accounts_list],200);
    }

    /**
     * Crea una nueva cuenta patrimonial
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'group' => 'required|digits:1',
            'subgroup' => 'required|digits:1',
            'item' => 'required|digits:1',
            'generic' => 'required|digits:2',
            'specific' => 'required|digits:2',
            'subspecific' => 'required|digits:2',
            'denomination' => 'required',
            'active' => 'required',
        ]);
        /** @var object Objeto que contiene los datos de la cuenta ya registrada si existe */
        $AccountingAccount = AccountingAccount::where('group', request('group'))
                              ->where('subgroup', request('subgroup'))
                              ->where('item', request('item'))
                              ->where('generic', request('generic'))
                              ->where('specific', request('specific'))
                              ->where('subspecific', request('subspecific'))->first();

        /**
         * Si la cuenta a registrar ya existe en la base de datos solo se actualiza el atributo active y la denominación
         * De lo contrario se crea la nueva cuenta
         */
        if ($AccountingAccount) {
            $AccountingAccount->denomination = $request->denomination;
            $AccountingAccount->active = $request->active;
            $AccountingAccount->save();
            $request->session()->flash('message', ['type' => 'update']);
        }else{

            /**
             * Registra la nueva cuenta patrimonial
             */
            AccountingAccount::create([
                'group' => $request->group,
                'subgroup' => $request->subgroup,
                'item' => $request->item,
                'generic' => $request->generic,
                'specific' => $request->specific,
                'subspecific' => $request->subspecific,
                'denomination' => $request->denomination,
                'active' => $request->active,
            ]);
            // $request->session()->flash('message', ['type' => 'store']);
        }
        
        return response()->json(['records'=>$this->getAccounts(), 'message'=>'Success']);
    }

    /**
     * Actualiza los datos de la cuenta patrimonial
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @param  integer $id      Identificador de la cuenta patrimonial a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'group' => 'required|digits:1',
            'subgroup' => 'required|digits:1',
            'item' => 'required|digits:1',
            'generic' => 'required|digits:2',
            'specific' => 'required|digits:2',
            'subspecific' => 'required|digits:2',
            'denomination' => 'required',
            'active' => 'required',
        ]);
        /** @var object Objeto con información de la cuenta patrimonial a modificar */
        $AccountingAccount = AccountingAccount::find($id);

        /**
         * Actualiza el registro de la cuenta
         */

        $AccountingAccount->group = $request->group;
        $AccountingAccount->subgroup = $request->subgroup;
        $AccountingAccount->item = $request->item;
        $AccountingAccount->generic = $request->generic;
        $AccountingAccount->specific = $request->specific;
        $AccountingAccount->subspecific = $request->subspecific;
        $AccountingAccount->denomination = $request->denomination;
        $AccountingAccount->active = $request->active;
        $AccountingAccount->save();
        
        // $request->session()->flash('message', ['type' => 'update']);

        return response()->json(['records'=>$this->getAccounts(), 'message'=>'Success']);
    }

    /**
     * Elimina una cuenta patrimonial
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $id Identificador de la cuenta patrimonial a eliminar
     * @return Response
     */
    public function destroy($id)
    {
        /** @var object Objeto con datos de la cuenta presupuestaria a eliminar */
        $AccountingAccount = AccountingAccount::with('account_converters')->find($id);

        if ($AccountingAccount) {
            if (!is_null($AccountingAccount->account_converters) || !is_null(AccountingSeatAccount::where('accounting_account_id', $id)->first())) {
                return response()->json(['error' => true, 'message' => 'El registro no se puede eliminar'],200);
            }
            $AccountingAccount->delete();
        }
        return response()->json(['records' => $AccountingAccount, 'message' => 'Success'], 200);
    }

    /**
    * Se obtiene el próximo codigo disponible para la cuenta que sera creada
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param [integer] $parent_id Identificador de la cuenta padre de la cual se va a generar el nuevo código
     * @return json [JSON con los datos del nuevo código generado]
    */

    public function getChildrenAccount($parent_id)
    {
        /** @var object Objeto con información de la cuenta presupuestaria de nivel superior */
        $parent = AccountingAccount::find($parent_id);

        /** @var string Contiene el código del subgroup */
        $subgroup = $parent->subgroup;
        /** @var string Contiene el código del ítem */
        $item = $parent->item;
        /** @var string Contiene el código del generic */
        $generic = $parent->generic;
        /** @var string Contiene el código del speific */
        $specific = $parent->specific;
        /** @var string Contiene el código del subspecific */
        $subspecific = $parent->subspecific;

        if ($parent->subgroup === "0") {
            $currentSubgroup = AccountingAccount::where(['group' => $parent->group])->orderBy('subgroup', 'desc')->first();
            $subgroup = (strlen(intval($currentSubgroup->subgroup)) < 2 || intval($currentSubgroup->subgroup) < 9) 
                    ? (intval($currentSubgroup->subgroup) + 1) : $currentSubgroup->subgroup;
        }
        else if ($parent->item === "0") {
            $currentItem = AccountingAccount::where(['group' => $parent->group, 'subgroup' => $parent->subgroup])->orderBy('item', 'desc')->first();
            $item = (strlen(intval($currentItem->item)) < 2 || intval($currentItem->item) < 9) 
                    ? (intval($currentItem->item) + 1) : $currentItem->item;
        }
        else if ($parent->generic === "00") {
            $currentGeneric = AccountingAccount::where(['group' => $parent->group, 'subgroup' => $parent->subgroup, 'item' => $parent->item])->orderBy('generic', 'desc')->first();
            $generic = (strlen(intval($currentGeneric->generic)) < 2 || intval($currentGeneric->generic) < 99) 
                       ? (intval($currentGeneric->generic) + 1) : $currentGeneric->generic;
            $generic = (strlen($generic) === 1) ? "0$generic" : $generic;
        }
        else if ($parent->specific === "00") {
            $currentSpecific = AccountingAccount::where([
                'group' => $parent->group, 'subgroup' => $parent->subgroup, 'item' => $parent->item, 'generic' => $parent->generic
            ])->orderBy('specific', 'desc')->first();
            $specific = (strlen(intval($currentSpecific->specific)) < 2 || intval($currentSpecific->specific) < 99) 
                        ? (intval($currentSpecific->specific) + 1) : $currentSpecific->specific;
            $specific = (strlen($specific) === 1) ? "0$specific" : $specific;
        }
        else if ($parent->subspecific === "00") {
            $currentSubSpecific = AccountingAccount::where([
                'group' => $parent->group, 'subgroup' => $parent->subgroup, 'item' => $parent->item, 'generic' => $parent->generic, 'specific' => $parent->specific
            ])->orderBy('subspecific', 'desc')->first();
            $subspecific = (strlen(intval($currentSubSpecific->subspecific)) < 2 || intval($currentSubSpecific->subspecific) < 99) 
                        ? (intval($currentSubSpecific->subspecific) + 1) : $currentSubSpecific->subspecific;
            $subspecific = (strlen($subspecific) === 1) ? "0$subspecific" : $subspecific;
        }

        $account = [
            'group' => (string)$parent->group, 'subgroup' => (string)$subgroup, 'item' => (string)$item, 'generic' => (string)$generic, 
            'specific' => (string)$specific, 'subspecific' => (string)$subspecific,
            'denomination' => $parent->denomination, 'active' => $parent->active
        ];
        return response()->json(['account'=> $account, 'message' => 'Success'], 200);
    }

    /**
     * obtiene los registros de las cuentas patrimoniales
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return Array con la información de las cuentas formateada
    */
    public function getAccounts()
    {
        /** @var array arreglo que almacenara la lista de cuentas patrimoniales*/
        $records = [];
        /**
         * se realiza la busqueda de manera ordenada en base al codigo
         */
        foreach (AccountingAccount::orderBy('group','ASC')
                                    ->orderBy('subgroup','ASC')
                                    ->orderBy('item','ASC')
                                    ->orderBy('generic','ASC')
                                    ->orderBy('specific','ASC')
                                    ->orderBy('subspecific','ASC')
                                    ->get() as $AccountingAccount) {
          /** @var array arreglo con datos de las cuentas patrimoniales*/
            array_push($records, [
                'id' => $AccountingAccount->id,
                'code' =>   $AccountingAccount->getCode(),
                'denomination' => $AccountingAccount->denomination,
                'active'=> $AccountingAccount->active,
                'text'=>"{$AccountingAccount->getCode()} - {$AccountingAccount->denomination}",
            ]);
        }
        return $records;
    }

}
