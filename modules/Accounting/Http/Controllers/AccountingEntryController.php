<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingEntryCategory;
use Modules\Accounting\Models\AccountingEntryAccount;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Institution;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Profile;
use Modules\Accounting\Jobs\AccountingManageEntries;
use Auth;

/**
 * @class AccountingEntryCategoryController
 * @brief Controlador para la gestion los asientos contables
 *
 * Clase que gestiona los asientos contables
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AccountingEntryController extends Controller
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
        $this->middleware('permission:accounting.entries.list', ['only' => ['index','unapproved']]);
        $this->middleware('permission:accounting.entries.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:accounting.entries.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:accounting.entries.delete', ['only' => 'destroy']);
        $this->middleware('permission:accounting.entries.approve', ['only' => 'approve']);
    }
    /**
     * muestra la vista donde se mostraran los asientos contables aprobados
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return view
     */
    public function index()
    {
        /**
         * [$currency contendra la moneda manejada por defecto]
         * @var Currency
         */
        $currency     = Currency::where('default', true)->first();

        $institutions = json_encode($this->getInstitutionAvailables('Todas'));

        $currencies              = json_encode(template_choices(
            'App\Models\Currency',
            ['symbol', '-', 'name'],
            [],
            true
        ));

        /**
         * [$entries almacena el registro de asiento contable mas antiguo]
         * @var AccountingEntry
         */
        $entries = AccountingEntry::orderBy('from_date', 'ASC')->first();

        /**
         * [$yearOld determinara el año mas antiguo para el filtrado]
         * @var date
         */
        $yearOld = '';

        if ($entries && $entries->from_date !== null) {
            $yearOld = explode('-', $entries->from_date)[0];
        }

        /** si no existe asientos contables la fecha mas antigua es la actual*/
        if ($yearOld == '') {
            $yearOld = date('Y');
        }

        /**
         * [$categories contendra las categorias]
         * @var array
         */
        $categories = [];
        array_push($categories, [
            'id'      => 0,
            'text'    => 'Todas',
            'acronym' => ''
        ]);

        foreach (AccountingEntryCategory::all() as $category) {
            array_push($categories, [
                'id'      => $category->id,
                'text'    => $category->name,
                'acronym' => $category->acronym,
            ]);
        }

        /**
         * se convierte array a JSON
         */
        $categories = json_encode($categories);

        return view('accounting::entries.index', compact('categories', 'yearOld', 'currencies', 'institutions'));
    }

    /**
     * Muestra un formulario para la creación de asientos contables
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return Response
     */
    public function create()
    {
        /**
         * [$currency almacena la información del tipo de moneda por defecto]
         * @var Currency
         */
        $currency     = Currency::where('default', true)->orderBy('id', 'ASC')->first();

        $currencies   = json_encode(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));

        $institutions = json_encode($this->getInstitutionAvailables('Seleccione...'));

        /**
         * [$AccountingAccounts almacena las cuentas pratrimoniales]
         * @var json
         */
        $AccountingAccounts = $this->getAccountingAccount();

        /**
         * [$categories contendra las categorias]
         * @var array
         */
        $categories = [];
        array_push($categories, [
            'id'      => '',
            'text'    => 'Seleccione...',
            'acronym' => ''
        ]);
        foreach (AccountingEntryCategory::all() as $category) {
            array_push($categories, [
                'id'      => $category->id,
                'text'    => $category->name,
                'acronym' => $category->acronym,
            ]);
        }

        /**
         * se convierte array a JSON
         */
        $categories = json_encode($categories);
        $currency   = json_encode($currency);

        return view('accounting::entries.form', compact(
            'AccountingAccounts',
            'categories',
            'currency',
            'currencies',
            'institutions'
        ));
    }

    /**
     * Crea una nuevo asiento contable y crea los registros de las cuentas asociadas
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date'           => 'required|date',
            'concept'        => 'required|string',
            'observations'   => 'nullable',
            'category'       => 'required|integer',
            'institution_id' => 'required|integer',
            'currency_id'    => 'required|integer',
            'tot'            => 'required|confirmed',
        ], [
            'date.required'           => 'El campo fecha es obligatorio.',
            'date.date'               => 'El campo fecha no tiene el formato adecuado.',
            'concept.required'        => 'El campo concepto o descripción es obligatorio.',
            'category.required'       => 'El campo categoria es obligatorio.',
            'category.integer'        => 'El campo categoria no esta en el formato de entero.',
            'institution_id.required' => 'El campo institución es obligatorio.',
            'institution_id.integer'  => 'El campo institución no esta en el formato de entero.',
            'currency_id.required'    => 'El campo moneda es obligatorio.',
            'currency_id.integer'     => 'El campo moneda no esta en el formato de entero.',
            'tot.confirmed'           => 'El asiento no esta balanceado, Por favor verifique.',
        ]);

        AccountingManageEntries::dispatch($request->all());

        return response()->json(['message'=>'Success', 'reference' => ''], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        return response()->json(['records' => AccountingEntry::with(
            'accountingEntryCategory',
            'accountingAccounts.account.accountConverters.budgetAccount',
            'institution',
        )->find($id)], 200);
    }

    /**
     * Muestra el formulario para la edición de asientos contables
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $id Identificador del asiento contable a modificar
     * @return Response
     */
    public function edit($id)
    {
        /**
         * [$entry asiento contable a editar]
         * @var AccountingEntry
         */
        $entry = AccountingEntry::with('accountingAccounts.account.accountConverters.budgetAccount')->find($id);

        // Validar acceso para el registro
        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($entry && $entry->queryAccess($user_profile['institution']['id'])) {
            return view('errors.403');
        }

        $currencies = json_encode(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));
        $institutions = json_encode($this->getInstitutionAvailables('Seleccione...'));

        /**
         * [$AccountingAccounts cuentas pratrimoniales]
         * @var Json
         */
        $AccountingAccounts = $this->getAccountingAccount();

        /**
         * se guarda en variables la información necesaria para la edición del asiento contable
         */

        $date         = $entry->from_date;
        $reference    = $entry->reference;
        $concept      = $entry->concept;
        $observations = $entry->observations;
        $category     = $entry->accounting_entry_categories_id;
        $institution  = $entry->institution_id;
        $currency     = $entry->currency_id;

        /**
         * [$categories lista de categorias]
         * @var array
         */
        $categories = [];
        array_push($categories, [
            'id'      => '',
            'text'    => 'Seleccione...',
            'acronym' => ''
        ]);
        foreach (AccountingEntryCategory::all() as $cat) {
            array_push($categories, [
                'id'      => $cat->id,
                'text'    => $cat->name,
                'acronym' => $cat->acronym,
            ]);
        }

        /**
         * se convierte array a JSON
         */
        $categories = json_encode($categories);

        $data_edit = [
            'date'         => $date,
            'category'     => $category,
            'reference'    => $reference,
            'concept'      => $concept,
            'observations' => $observations,
            'institution'  => $institution,
            'currency'     => $currency
        ];
        $data_edit = json_encode($data_edit);

        return view('accounting::entries.form', compact(
            'AccountingAccounts',
            'entry',
            'categories',
            'data_edit',
            'currencies',
            'institutions'
        ));
    }

    /**
     * Actualiza los datos del asiento contable
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request Objeto con datos de la petición realizada
     * @param  integer $id      Identificador del asiento contable a modificar
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'date'           => 'required|date',
            'reference'      => 'required|string|unique:accounting_entries,reference,'.$id,
            'concept'        => 'required|string',
            'observations'   => 'nullable',
            'category'       => 'required|integer',
            'institution_id' => 'required|integer',
            'currency_id'    => 'required|integer',
            'tot'            => 'required|confirmed',
        ], [
            'date.required'           => 'El campo fecha es obligatorio.',
            'date.date'               => 'El campo fecha no tiene el formato adecuado.',
            'reference.required'      => 'El campo referencia es obligatorio.',
            'reference.unique'        => 'El campo referencia debe ser único.',
            'concept.required'        => 'El campo concepto o descripción es obligatorio.',
            'category.required'       => 'El campo categoria es obligatorio.',
            'category.integer'        => 'El campo categoria no esta en el formato de entero.',
            'institution_id.required' => 'El campo institución es obligatorio.',
            'institution_id.integer'  => 'El campo intitución no esta en el formato de entero.',
            'currency_id.required'    => 'El campo moneda es obligatorio.',
            'currency_id.integer'     => 'El campo moneda no esta en el formato de entero.',
            'tot.confirmed'           => 'El asiento no esta balanceado, Por favor verifique.',
        ]);

        // Validar acceso para el registro
        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        /**
         * [$entry informaciónd el asiento contable]
         * @var AccountingEntry
         */
        $entry = AccountingEntry::find($id);

        if ($entry && $entry->queryAccess($user_profile['institution']['id'])) {
            return response()->json(['message'=>'No tiene acceso para modificar el registro',
                'redirect' => route('errors.403')], 403);
        }

        /**
         * se actualiza la información del registro del asiento contable
         */
        AccountingManageEntries::dispatch($request->all());

        return response()->json(['message'=>'Success'], 200);
    }

    /**
     * Elimina un asiento contable
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $id Identificador del asiento contable a eliminar
     * @return Response
     */
    public function destroy($id)
    {
        // Validar acceso para el registro
        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($entry && $entry->queryAccess($user_profile['institution']['id'])) {
            return response()->json(['error' => true, 'message'=>'No tiene acceso para eliminar el registro.', 403]);
        }

        /** El registro de asiento contable a eliminar */
        AccountingEntryAccount::where('accounting_entry_id', $id)->delete();

        AccountingEntry::find($id)->delete();

        return response()->json(['message'=>'Success', 200]);
    }

    /**
     * [filterRecords consulta y filta los registros de asientos contables]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request
     * @param  integer $perPage [pagina anterior]
     * @param  integer $page    [pagina actual a mostrar]
     * @return Response
     */
    public function filterRecords(Request $request, $perPage = 10, $page = 1)
    {
        /**
         * [$records contendra los registros]
         * @var array
         */
        $records = [];

        /**
         * [$FilterByOrigin registros luego de aplicar el filtrado por categoria de origen]
         * @var array
         */
        $FilterByOrigin = [];

        /**
         * [$institution_id id de la institución para el filtrado]
         * @var null
         */
        $institution_id = null;

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile['institution']['id'] == $request->institution) {
            $institution_id = $request->institution;
        } elseif (auth()->user()->isAdmin() && $request->institution) {
            $institution_id = $request->institution;
        }

        if ($request->typeSearch == 'reference') {
            $allRecords = [];

            $search = (!$request->search)?$request->reference:$request->search;
            /**
             * Se realiza la consulta si selecciono una institución para el filtrado
            */
            if ($institution_id) {
                $allRecords = AccountingEntry::column('reference', $search)
                                                ->column('from_date', $search)
                                                ->column('reference', $search)
                                                ->column('concept', $search)
                                                ->where('institution_id', $institution_id);
            } else {
                if (auth()->user()->isAdmin()) {
                    $allRecords = AccountingEntry::column('reference', $search)
                                                    ->column('from_date', $search)
                                                    ->column('reference', $search)
                                                    ->column('concept', $search);
                }
            }
        } elseif ($request->typeSearch == 'origin') {
            /**
             * realiza busqueda de todos los asientos, de lo contrario solo por una categoria especifica
             * Se realiza la consulta si selecciono una institución o departamento para el filtrado
            */
            $allRecords = [];

            $search = ($request->search)?$request->search:'';

            $query = AccountingEntry::column('from_date', (($search)?$search:''))
                                    ->column('reference', (($search)?$search:''))
                                    ->column('concept', (($search)?$search:''));

            if ($request->search) {
                if ($institution_id) {
                    /**
                     * Se seleccionan los registros por institución
                    */
                    $allRecords = ($request->category == 0) ?
                                    $query->where('institution_id', $institution_id) :
                                    $query->where('institution_id', $institution_id)
                                    ->where('accounting_entry_categories_id', $request->category);
                } else {
                    $allRecords = ($request->category == 0) ?
                                    $query :
                                    $query->where('accounting_entry_categories_id', $request->category);
                }
            } else {
                if ($institution_id) {
                    /**
                     * Se seleccionan los registros por institución
                    */

                    $allRecords = ($request->category == 0) ?
                                    $query->where('institution_id', $institution_id) :

                                    $query->where('institution_id', $institution_id)
                                            ->where('accounting_entry_categories_id', $request->category);
                } else {
                    $allRecords = ($request->category == 0) ?
                                    $query :
                                    $query->where('accounting_entry_categories_id', $request->category);
                }
            }
        }
        $allRecords = $allRecords->where('approved', true)
                                ->orderBy('id', 'ASC')
                                ->orderBy('from_date', 'ASC')
                                ->orderBy('reference', 'ASC');
        /**
         * Filtrado para unos meses o años en general
         */

        if ($request->filterDate == 'generic') {
            /**
             * [$fltForYear contendra los registros restantes del primer filtrado general]
             * @var array
             */
            $fltForYear = [];
            /**
             * todas las fechas
             */
            if ($request->year == 0 && $request->month == 0) {
                $records = $allRecords;
            } else {
                /**
                 * filtardo por año
                 */
                if ($request->year == 0) { // todos los años
                    $fltForYear = $allRecords;
                } else {
                    foreach ($allRecords as $record) {
                        if (explode('-', $record->from_date)[0] == $request->year) {
                            array_push($fltForYear, $record);
                        }
                    }
                }
                /**
                 * filtrado por mes
                 */
                if ($request->month == 0) { // todos los meses
                    $records = $fltForYear;
                } else {
                    foreach ($fltForYear as $record) {
                        if (explode('-', $record->from_date)[1] == $request->month) {
                            array_push($records, $record);
                        }
                    }
                }
            }
        } else {
            /**
             * Filtrado en un rango especifico de fechas
             */
            $records = $allRecords->whereBetween("from_date", [$request->init,$request->end])
                                ->orderBy('reference', 'ASC');
        }


        $total = $allRecords->count();
        $records = $allRecords->offset(($page - 1) * $perPage)->limit($perPage)->get();
        $lastPage = max((int) ceil($total / $perPage), 1);

        return response()->json(
            [
                'records'  => $records,
                'total'    => $total,
                'lastPage' => $lastPage
            ],
            200
        );
    }


    /**
     * Obtiene los registros de las cuentas patrimoniales
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return json [JSON con la información de las cuentas formateada]
    */
    public function getAccountingAccount()
    {
        /**
         * [$records listado de registros]
         * @var array
         */
        $records = [];
        array_push($records, [
                'id'   => '',
                'text' => 'Seleccione...'
            ]);
        /**
         * ciclo para almecenar y formatear en array las cuentas patrimoniales
         */
        foreach (AccountingAccount::orderBy('group', 'ASC')
                                    ->orderBy('subgroup', 'ASC')
                                    ->orderBy('item', 'ASC')
                                    ->orderBy('generic', 'ASC')
                                    ->orderBy('specific', 'ASC')
                                    ->orderBy('subspecific', 'ASC')
                                    ->get() as $account) {
            if ($account->active) {
                array_push($records, [
                    'id'   => $account->id,
                    'text' => "{$account->getCodeAttribute()} - {$account->denomination}"
                ]);
            }
        };
        /**
         * se convierte array a JSON
         */
        return json_encode($records);
    }


    /**
     * [unapproved vista con listado de asientos contable no aprobados]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [type] [description]
     */
    public function unapproved()
    {
        /**
         * [$entries listado de los asientos contables no aprobados]
         * @var array
         */
        $entries = [];

        /**
         * [$user_profile informacion del perfil del usuario logueado]
         * @var Profile
         */
        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile['institution']['id']) {
            $entries = AccountingEntry::with('accountingAccounts.account.accountConverters.budgetAccount')
                        ->where('approved', false)->where('institution_id', $user_profile['institution']['id'])
                        ->orderBy('from_date', 'ASC')->get();
        } else {
            if (auth()->user()->isAdmin()) {
                $entries = AccountingEntry::with('accountingAccounts.account.accountConverters.budgetAccount')
                        ->where('approved', false)->orderBy('from_date', 'ASC')->get();
            }
        }

        return view('accounting::entries.listing', compact('entries'));
    }

    /**
     * [approve aprueba el asiento contable]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Integer $id identificador del asiento contable
     * @return Response
     */
    public function approve($id)
    {
        // Validar acceso para el registro
        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        /**
         * [$entry contendra el asiento al que se le cambiara el estado]
         * @var AccountingEntry
         */
        $entry           = AccountingEntry::find($id);

        if ($entry && $entry->queryAccess($user_profile['institution']['id'])) {
            return response()->json(['error' => true, 'message'=>'No tiene acceso para modificar el registro.', 403]);
        }

        $entry->approved = true;
        $entry->save();
        return response()->json(['message'=>'Success'], 200);
    }

    public function getInstitutionAvailables($text)
    {
        $institutions = [];
        $profile      = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($profile) {
            if (auth()->user()->hasRole('admin')) {
                $institutions            = template_choices('App\Models\Institution', 'name', [], true);
                $institutions[0]['text'] = $text;
            } else {
                array_push($institutions, [
                    'id'   => $profile->institution->id,
                    'text' => $profile->institution->name,
                ]);
            }
        } elseif (!$profile && auth()->user()->hasRole('admin')) {
            $institutions            = template_choices('App\Models\Institution', 'name', [], true);
            $institutions[0]['text'] = $text;
        }
        return $institutions;
    }
}
