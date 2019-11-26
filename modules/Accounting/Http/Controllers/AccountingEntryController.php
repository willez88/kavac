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
use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;
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

        /** @var Object objeto que contendra la moneda manejada por defecto */
        $currency = Currency::where('default', true)->first();

        $currencies = json_encode(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));
        $institutions = template_choices('App\Models\Institution', 'name', [], true);

        $institutions[0]['text'] = 'Todas';
        $institutions = json_encode($institutions);

        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $entries = AccountingEntry::orderBy('from_date', 'ASC')->first();

        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $yearOld = explode('-', $entries['from_date'])[0];

        /** si no existe asientos contables la fecha mas antigua es la actual*/
        if ($yearOld == '') {
            $yearOld = date('Y');
        }

        /** @var array Arreglo que contendra las categorias */
        $categories = [];
        array_push($categories, [
            'id' => 0,
            'text' => 'Todas',
            'acronym' => ''
        ]);

        foreach (AccountingEntryCategory::all() as $category) {
            array_push($categories, [
                'id' => $category->id,
                'text' => $category->name,
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
        $currency = Currency::where('default', true)->orderBy('id', 'ASC')->first();

        $currencies = json_encode(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));

        $institutions = json_encode(template_choices('App\Models\Institution', 'name', [], true));

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
            'id' => '',
            'text' => 'Seleccione...',
            'acronym' => ''
        ]);
        foreach (AccountingEntryCategory::all() as $category) {
            array_push($categories, [
                'id' => $category->id,
                'text' => $category->name,
                'acronym' => $category->acronym,
            ]);
        }

        /**
         * se convierte array a JSON
         */
        $categories = json_encode($categories);
        $currency = json_encode($currency);

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
            // 'reference'      => 'required|string|unique:accounting_entries,reference',
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
            'reference.unique'        => 'El campo referencia debe ser único, debe verificar que no exista una 
                                            asiento con el mismo código de referencia.',
            'concept.required'        => 'El campo concepto o descripción es obligatorio.',
            'category.required'       => 'El campo categoria es obligatorio.',
            'category.integer'        => 'El campo categoria no esta en el formato de entero.',
            'institution_id.required' => 'El campo institución es obligatorio.',
            'institution_id.integer'  => 'El campo intitución no esta en el formato de entero.',
            'currency_id.required'    => 'El campo moneda es obligatorio.',
            'currency_id.integer'     => 'El campo moneda no esta en el formato de entero.',
            'tot.confirmed'           => 'El asiento no esta balanceado, Por favor verifique.',
        ]);

        /**
         * se crear el asiento contable
         */
        $newEntries = AccountingEntry::create([
            'from_date' => $request->date,
            'reference' => $this->generateReferenceCodeAvailable(),
            'concept' => $request->concept,
            'observations' => $request->observations,
            'accounting_entry_categories_id' => ($request->category!='')? $request->category: null,
            'institution_id' => $request->institution_id,
            'currency_id' => (int)$request->currency_id,
            'tot_debit' => $request->totDebit,
            'tot_assets' => $request->totAssets,
        ]);

        /**
         * se crea el registro en la tabla pivote entre el asiento contable y las cuentas patrimoniales
         */
        foreach ($request->accountingAccounts as $account) {
            AccountingEntryAccount::create([
                'accounting_entry_id' => $newEntries->id,
                'accounting_account_id' => $account['id'],
                'debit' => $account['debit'],
                'assets' => $account['assets'],
            ]);
        }
        return response()->json(['message'=>'Success', 'reference' => $newEntries->reference], 200);
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
        $currencies = json_encode(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));
        $institutions = json_encode(template_choices('App\Models\Institution', 'name', [], true));

        /** @var Object Objeto que contendra el asiento contable a editar */
        $entries = AccountingEntry::with('accountingAccounts.account.accountConverters.budgetAccount')->find($id);
        /** @var JSON Objeto que almacena las cuentas pratrimoniales */
        $AccountingAccounts = $this->getAccountingAccount();

        /**
         * se guarda en variables la información necesaria para la edición del asiento contable
         */
        
        $date = $entries->from_date;
        $reference = $entries->reference;
        $concept = $entries->concept;
        $observations = $entries->observations;
        $category = $entries->accounting_entry_categories_id;
        $institution = $entries->institution_id;
        $currency = $entries->currency_id;

        /** @var array Arreglo que contendra las categorias */
        $categories = [];
        array_push($categories, [
            'id' => '',
            'text' => 'Seleccione...',
            'acronym' => ''
        ]);
        foreach (AccountingEntryCategory::all() as $cat) {
            array_push($categories, [
                'id' => $cat->id,
                'text' => $cat->name,
                'acronym' => $cat->acronym,
            ]);
        }

        /**
         * se convierte array a JSON
         */
        $categories = json_encode($categories);

        $data_edit = [
            'date' => $date,
            'category' => $category,
            'reference' => $reference,
            'concept' => $concept,
            'observations' => $observations,
            'institution' => $institution,
            'currency' => $currency
        ];
        $data_edit = json_encode($data_edit);

        return view('accounting::entries.form', compact(
            'AccountingAccounts',
            'entries',
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

        /**
         * se actualiza la información del registro del asiento contable
         */
        $record = AccountingEntry::find($id);
        $record->concept = $request->concept;
        $record->observations = $request->observations;
        $record->tot_debit = $request->totDebit;
        $record->tot_assets = $request->totAssets;
        $record->institution_id = $request->institution_id;
        $record->currency_id = (int)$request->currency_id;
        $record->save();

        foreach ($request->accountingAccounts as $account) {
            /**
             * Actualiza la relación de cuenta a ese asiento ya existe lo actualiza,
             * de lo contrario crea el nuevo registro de cuenta
             */
            if ($account['entryAccountId']) {
                /** @var Object Objeto que contiene el registro de cuanta patrimonial
                asociada al asiento a actualizar */
                $record = AccountingEntryAccount::find($account['entryAccountId']);
                $record->accounting_account_id = $account['id'];
                $record->debit = $account['debit'];
                $record->assets = $account['assets'];
                $record->save();
            } else {
                /** @var Object Objeto que contiene el nuevo registro de cuanta patrimonial
                asociada que se asociara al asiento */
                AccountingEntryAccount::create([
                    'accounting_entry_id' => $id,
                    'accounting_account_id' => $account['id'],
                    'debit' => $account['debit'],
                    'assets' => $account['assets'],
                ]);
            }
        }

        /** Se eliminar los registros de las cuentas deseadas */
        AccountingEntryAccount::destroy($request->rowsToDelete);

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
        /** El registro de asiento contable a eliminar */
        AccountingEntryAccount::where('accounting_entry_id', $id)->delete();

        AccountingEntry::find($id)->delete();

        return response()->json(['message'=>'Success', 200]);
    }

    /**
     * consulta y filta los registros de asientos contables
     * @param Request $request
     * @return Response
     */
    public function filterRecords(Request $request)
    {
        /** @var array Arreglo que contendra los registros */
        $records = [];
        /** @var array Arreglo que contendra los registros luego de aplicar el filtrado por categoria de origen */
        $FilterByOrigin = [];

        /** @var int Variable que almacenara el id de la institución o departamento para el filtrado */
        $institution_id = null;
        $institution_id = $request->institution;

        if ($request->typeSearch == 'reference') {
            $allRecords = [];
            /**
             * Se realiza la consulta si selecciono una institución o departamento para el filtrado
            */
            if (!is_null($institution_id)) {
                /**
                 * Se seleccionan los registros por institución
                */
                $allRecords = AccountingEntry::with('accountingAccounts.account')
                                ->where('approved', true)
                                ->where('institution_id', $institution_id)
                                ->orderBy('from_date', 'ASC')->get();
            } else {
                $allRecords = AccountingEntry::with('accountingAccounts.account')
                                ->where('approved', true)
                                ->orderBy('from_date', 'ASC')->get();
            }
            foreach ($allRecords as $entries) {
                if (count(explode($request['reference'], $entries->reference)) > 1) {
                    array_push($records, $entries);
                }
            }
        } elseif ($request->typeSearch == 'origin') {
            /**
             * realiza busqueda de todos los asientos, de lo contrario solo por una categoria especifica
             * Se realiza la consulta si selecciono una institución o departamento para el filtrado
            */
            $FilterByOrigin = [];

            if (!is_null($institution_id)) {
                /**
                 * Se seleccionan los registros por institución
                */
                $FilterByOrigin = ($request->category == 0) ?
                                    AccountingEntry::with('accountingAccounts.account')
                                    ->where('institution_id', $institution_id)
                                    ->where('approved', true)
                                    ->orderBy('from_date', 'ASC')->get() :
                                    AccountingEntry::with('accountingAccounts.account')
                                    ->where('institution_id', $institution_id)
                                    ->where('approved', true)
                                    ->where('accounting_entry_categories_id', $request->category)
                                    ->orderBy('from_date', 'ASC')->get();
            } else {
                $FilterByOrigin = ($request->category == 0) ?
                                    AccountingEntry::with('accountingAccounts.account')
                                    ->where('approved', true)
                                    ->orderBy('from_date', 'ASC')->get() :
                                    AccountingEntry::with('accountingAccounts.account')
                                    ->where('approved', true)
                                    ->where('accounting_entry_categories_id', $request->category)
                                    ->orderBy('from_date', 'ASC')->get();
            }

            /**
             * Filtrado para unos meses o años en general
             */
            if ($request->filterDate == 'generic') {
                /** @var array Arreglo que contendra los registros restantes del primer filtrado general */
                $fltForYear = [];
                /**
                 * todas las fechas
                 */
                if ($request->year == 0 && $request->month == 0) {
                    $records = $FilterByOrigin;
                } else {
                    /**
                     * filtardo por año
                     */
                    if ($request->year == 0) { // todos los años
                        $fltForYear = $FilterByOrigin;
                    } else {
                        foreach ($FilterByOrigin as $record) {
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
                $records = $FilterByOrigin->whereBetween("from_date", [$request->init,$request->end]);
            }
        }
        return response()->json(['records'=>$records,'message'=>'Success', 200]);
    }
    /**
     * Obtiene los registros de las cuentas patrimoniales
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
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
        foreach (AccountingAccount::orderBy('group', 'ASC')
                                    ->orderBy('subgroup', 'ASC')
                                    ->orderBy('item', 'ASC')
                                    ->orderBy('generic', 'ASC')
                                    ->orderBy('specific', 'ASC')
                                    ->orderBy('subspecific', 'ASC')
                                    ->get() as $account) {
            if ($account->active) {
                array_push($records, [
                    'id' => $account->id,
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
         * [$entries registros resultantes de la busqueda]
         * @var
         */
        $entries = AccountingEntry::with('accountingAccounts.account.accountConverters.budgetAccount')
                    ->where('approved', false)->orderBy('from_date', 'ASC')->get();

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
        /** @var Object Objeto que contendra el asiento al que se le cambiara el estado */
        $entries = AccountingEntry::find($id);
        $entries->approved = true;
        $entries->save();
        return response()->json(['message'=>'Success'], 200);
    }

    /**
     * [getInstitution obtiene la informacion de una institución]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  int|null $id [identificador unico de la institución]
     * @return Institution     [informacion de la institución]
     */
    public function getInstitution($id = null)
    {
        if ($id) {
            return Institution::find($id);
        }
        return Institution::first();
    }

    public function generateReferenceCodeAvailable()
    {
        $institution = $this->getInstitution();
        $codeSetting = CodeSetting::where('table', $institution->id.'_'.$institution->acronym.'_accounting_entries')
                                    ->first();
        if (!is_null($codeSetting)) {
            $code  = generate_registration_code(
                $codeSetting->format_prefix,
                strlen($codeSetting->format_digits),
                (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                AccountingEntry::class,
                $codeSetting->field
            );
        } else {
            $code = 'error';
        }

        return $code;
    }
}
