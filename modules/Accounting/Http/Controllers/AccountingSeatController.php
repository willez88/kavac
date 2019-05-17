<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingSeatCategory;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingAccount;
use App\Models\Institution;
use Auth;
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
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.seating.list', ['only' => 'index','unapproved']);
        $this->middleware('permission:accounting.seating.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accounting.seating.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:accounting.seating.delete', ['only' => 'destroy']);
        $this->middleware('permission:accounting.seating.approve', ['only' => 'approve']);
    }
    /**
     * muestra la vista donde se mostraran los asientos contables aprobados
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @return view
     */
    public function index()
    {
        /** @var Object Objeto en el que se almacena el listado de instituciones activas en el sistema */
        $institutions = $this->getInstitutions();

        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $seating = AccountingSeat::orderBy('from_date','ASC')->first();
        
        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $yearOld = explode('-',$seating['from_date'])[0];

        /** @var array Arreglo que contendra las categorias */
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
        /**
         * se convierte array a JSON
         */
        $categories = json_encode($categories);
        return view('accounting::seating.index',compact('categories','yearOld','institutions'));
    }

    /**
     * Muestra un formulario para la creación de asientos contables
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @return Response
     */
    public function create()
    {
        /** @var Object Objeto en el que se almacena el listado de instituciones activas en el sistema */
        $institutions = $this->getInstitutions();

        /** @var JSON Objeto que almacena las cuentas pratrimoniales */
        $AccountingAccounts = $this->getAccountingAccount();
        /** @var array Arreglo que contendra las categorias */
        $categories = [];
        array_push($categories, [
            'id' => '',
            'text' => 'Seleccione...'
        ]);
        foreach (AccountingSeatCategory::all() as $category) {
            array_push($categories, [
                'id' => $category->id,
                'text' => $category->name,
            ]);
        }
        /**
         * se convierte array a JSON
         */
        $categories = json_encode($categories);

        return view('accounting::seating.create-edit-form',compact('AccountingAccounts','categories','institutions'));
    }

    /**
     * Crea una nuevo asiento contable y crea los registros de las cuentas asociadas
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        /**
         * se crear el asiento contable
         */
        $newSeating = new AccountingSeat();
        $newSeating->from_date = $request->data['date'];
        $newSeating->reference = $request->data['reference'];
        $newSeating->concept = $request->data['concept'];
        $newSeating->observations = $request->data['observations'];
        $newSeating->generated_by_id=($request->data['generated_by_id']!='')? $request->data['generated_by_id']: null;
        $newSeating->institution_id=(!is_null($request->data['institution_id']))? $request->data['institution_id']: null;
        $newSeating->department_id=(!is_null($request->data['departament_id']))? $request->data['departament_id']: null;
        $newSeating->tot_debit = $request->data['totDebit'];
        $newSeating->tot_assets = $request->data['totAssets'];
        $newSeating->save();

        /**
         * se crea el registro en la tabla pivote entre el asiento contable y las cuentas patrimoniales
         */
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
     * Muestra información de los asientos contables
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @return Response
     */
    public function show($id)
    {
        // return view('accounting::show');
    }

    /**
     * Muestra el formulario para la edición de asientos contables
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @param  integer $id Identificador del asiento contable a modificar
     * @return Response
     */
    public function edit($id)
    {
        /** @var Object Objeto en el que se almacena el listado de instituciones activas en el sistema */
        $institutions = $this->getInstitutions();
        
        /** @var Object Objeto que contendra el asiento contable a editar */
        $seating = AccountingSeat::with('accounting_accounts.account.account_converters.budget_account')->find($id);
        /** @var JSON Objeto que almacena las cuentas pratrimoniales */
        $AccountingAccounts = $this->getAccountingAccount();

        /**
         * se guarda en variables la información necesaria para la edición del asiento contable
         */ 
        $date = $seating->from_date;
        $reference = $seating->reference;
        $concept = $seating->concept;
        $observations = $seating->observations;
        $category = $seating->generated_by_id;

        /**
         * se valida si el asiento tiene alguna relación con una institución/departamento
         */ 
        if (is_null($seating->institution_id) && is_null($seating->departament_id)) {
            $institution_departament = '';
        }else if (!is_null($seating->institution_id) || !is_null($seating->departament_id)) {
            $institution_departament = (is_null($seating->institution_id)) ? 
                                            $seating->departament_id.'-departament':
                                            $seating->institution_id.'-institution';
        }

        /** @var array Arreglo que contendra las categorias */
        $categories = [];
        array_push($categories, [
            'id' => '',
            'text' => 'Seleccione...'
        ]);
        foreach (AccountingSeatCategory::all() as $cat) {
            array_push($categories, [
                'id' => $cat->id,
                'text' => $cat->name,
            ]);
        }
        /**
         * se convierte array a JSON
         */
        $categories = json_encode($categories);

        return view('accounting::seating.create-edit-form',compact('AccountingAccounts','seating','categories','category','date','reference','concept','observations','institutions','institution_departament'));
    }

    /**
     * Actualiza los datos del asiento contable
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @param  integer $id      Identificador del asiento contable a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        /**
         * se actualiza la información del registro del asiento contable
         */ 
        $seating = AccountingSeat::find($id);
        $seating->reference = $request->data['reference'];
        $seating->concept = $request->data['concept'];
        $seating->observations = $request->data['observations'];
        $seating->tot_debit = $request->data['totDebit'];
        $seating->tot_assets = $request->data['totAssets'];
        $seating->institution_id=(!is_null($request->data['institution_id']))? $request->data['institution_id']: null;
        $seating->department_id=(!is_null($request->data['departament_id']))? $request->data['departament_id']: null;
        $seating->save();

        foreach ($request->accountingAccounts as $account) {
            /**
             * Actualiza la relación de cuenta a ese asiento ya existe lo actualiza, de lo contrario crea el nuevo registro de cuenta
             */ 
            if ($account['id_seatAcc']) {
                /** @var Object Objeto que contiene el registro de cuanta patrimonial asociada al asiento a actualizar */
                $AccSeat = AccountingSeatAccount::find($account['id_seatAcc']);
                $AccSeat->accounting_account_id = $account['id'];
                $AccSeat->debit = $account['debit'];
                $AccSeat->assets = $account['assets'];
            }else{
                /** @var Object Objeto que contiene el nuevo registro de cuanta patrimonial asociada que se asociara al asiento */
                $AccSeat = new AccountingSeatAccount();
                $AccSeat->accounting_seat_id = $seating->id;
                $AccSeat->accounting_account_id = $account['id'];
                $AccSeat->debit = $account['debit'];
                $AccSeat->assets = $account['assets'];
            }
            $AccSeat->save();
        }
        return response()->json(['message'=>'Success'],200);
    }

    /**
     * Elimina un asiento contable
     *
     * @author Juan Rosas <JuanFBass17@gmail.com>
     * @param  integer $id Identificador del asiento contable a eliminar
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Object Objeto que contine el registro de asiento contable a eliminar */
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
        /** @var array Arreglo que contendra los registros */
        $records = [];
        /** @var array Arreglo que contendra los registros luego de aplicar el filtrado por categoria de origen */
        $FilterByOrigin = [];

        if ($request->typeSearch == 'reference') {
            foreach (AccountingSeat::with('accounting_accounts.account')->orderBy('from_date','ASC')->get() as $seating) {
                if (count(explode($request->data['reference'], $seating->reference)) > 1) {
                    array_push($records, $seating);
                }
            }
        }else if ($request->typeSearch == 'origin') {
            /**
             * realiza busqueda de todos los asientos, sino solo por una categoria de origen
             */
            $FilterByOrigin = ($request->data['category'] == 0) ?
                 AccountingSeat::with('accounting_accounts.account')->where('approved',true)->orderBy('from_date','ASC')->get() : 
                 AccountingSeat::with('accounting_accounts.account')->where('approved',true)->where('generated_by_id',$request->data['category'])->orderBy('from_date','ASC')->get();
            
            /**
             * Filtrado para unos meses o años en general
             */
            if ($request->filterDate == 'generic') {
                /** @var array Arreglo que contendra los registros restantes del primer filtrado general */
                $fltForYear = [];
                    /**
                     * todas las fechas
                     */
                    if ($request->data['year'] == 0 && $request->data['month'] == 0) {
                        $records = $FilterByOrigin;
                    }
                    else{
                        /**
                         * filtardo por año
                         */
                        if ($request->data['year'] == 0) { // todos los años
                            $fltForYear = $FilterByOrigin;
                        }else{
                            foreach ($FilterByOrigin as $record) {
                                if (explode('-',$record->from_date)[0] == $request->data['year']) {
                                    array_push($fltForYear, $record);
                                }
                            }
                        }
                        /**
                         * filtrado por mes
                         */
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
                /**
                 * Filtrado en un rango especifico de fechas
                 */
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
        /** @var array Arreglo que contendra los registros */
        $records = [];
        array_push($records, [
                'id' => '',
                'text' => 'Seleccione...'
            ]);
        /**
         * ciclo para almecenar y formatear en array las cuentas patrimoniales
         */
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
        /**
         * se convierte array a JSON
         */
        return json_encode($records);
    }


// controladores para la gestión de asientos contable no aprobados

    // Listado
    public function unapproved()
    {
        /** @var Object objeto que contendra los registros resultantes de la busqueda */
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
        /** @var Object Objeto que contendra el asiento al que se le cambiara el estado */
        $seating = AccountingSeat::find($id);
        $seating->approved = true;
        $seating->save();
        return response()->json(['message'=>'Success'], 200);
    }

    public function getInstitutions()
    {
        /** @var Object Objeto en el que se almacena el listado de instituciones activas en el sistema */
        $institutions = [];
        array_push($institutions, [
            'id' => '',
            'text' => 'Seleccione...'
        ]);
        foreach (Institution::with('departments')->where('active',true)->orderBy('name','ASC')->get() as $institution) {
            // se almacenan las instituciones y departamente
            array_push($institutions, [
                'id' => $institution->id.'-institution',
                'text' => $institution->acronym.' - '.$institution->name,
            ]);
            foreach ($institution->departments as $department) {
               array_push($institutions, [
                'id' => $department['id'].'-department',
                'text' => $department['acronym'].' - '.$department['name'],
            ]); 
            }
        }
        /**
         * se convierte array a JSON
         */
        return json_encode($institutions);
    }

}
