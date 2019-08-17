<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingAccount;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;
use App\Imports\DataImport;



/**
 * Clase que gestiona las Cuentas patrimoniales
 *
 * @class AccountingAccountController
 * @brief Controlador de Cuentas patrimoniales
 *
 * @author    Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 *
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *             LICENCIA DE SOFTWARE CENDITEL</a>
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
        /**
         * Establece permisos de acceso para cada método del controlador
         */
        $this->middleware('permission:accounting.account.list', ['only' => 'index']);
        $this->middleware(
            'permission:accounting.account.create',
            ['only' => ['store', 'registerImportedAccounts']]
        );
        $this->middleware(
            'permission:accounting.account.edit',
            ['only' => ['update']]
        );
        $this->middleware(
            'permission:accounting.account.delete',
            ['only' => 'destroy']
        );
    }

    /**
     * Muestra un listado de cuentas patrimoniales
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return view
     */
    public function index()
    {
        return response()->json(['records'=>$this->getAccounts()], 200);
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
        $this->validate(
            $request,
            [
                'group'        => 'required|digits:1',
                'subgroup'     => 'required|digits:1',
                'item'         => 'required|digits:1',
                'generic'      => 'required|digits:2',
                'specific'     => 'required|digits:2',
                'subspecific'  => 'required|digits:2',
                'denomination' => 'required',
                'active'       => 'required',
            ]
        );

        /**
         * [$acc  almacena la consulta de la cuenta, si esta no existe retorna null]
         * @var [Object]
         */
        $acc = AccountingAccount::where('group', $request['group'])
            ->where('subgroup', $request['subgroup'])
            ->where('item', $request['item'])
            ->where('generic', $request['generic'])
            ->where('specific', $request['specific'])
            ->where('subspecific', $request['subspecific'])->first();

        /** @var Object que almacena la consulta de la cuenta de nivel superior de la cuanta actual,
        * si esta no posee retorna false
        */
        $parent = AccountingAccount::getParent(
            $request['group'],
            $request['subgroup'],
            $request['item'],
            $request['generic'],
            $request['specific'],
            $request['subspecific']
        );
        AccountingAccount::updateOrCreate(
            [
                'group' => $request['group'], 'subgroup' => $request['subgroup'],
                'item' => $request['item'], 'generic' => $request['generic'],
                'specific' => $request['specific'], 'subspecific' => $request['subspecific'],
            ],
            [
                'denomination' => $request['denomination'],
                'active' => $request['active'],
                'inactivity_date' => (!$request['active'])?date('Y-m-d'):null,

                /**
                * Si existe, al ejecutar nuevamente el seeder o refrescar la base
                * de datos evita que se asigne en la columna parent_id a si mismo como su parent
                */
                'parent_id' => ($acc != null && $parent != false) ?
                (($acc->id == $parent->id)?null:$parent->id) : (($parent == false)?null:$parent->id) ,
            ]
        );

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
        $this->validate(
            $request,
            [
                'group'        => 'required|digits:1',
                'subgroup'     => 'required|digits:1',
                'item'         => 'required|digits:1',
                'generic'      => 'required|digits:2',
                'specific'     => 'required|digits:2',
                'subspecific'  => 'required|digits:2',
                'denomination' => 'required',
                'active'       => 'required',
            ]
        );

        /**
         * Actualiza el registro de la cuenta
         */
        AccountingAccount::where('id', $id)
          ->update($request->all());

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
        $AccountingAccount = AccountingAccount::with('accountConverters')->find($id);

        if ($AccountingAccount) {
            if (!is_null($AccountingAccount->accountConverters)
                || !is_null(AccountingSeatAccount::where('accounting_account_id', $id)->first())) {
                return response()->json(
                    [
                        'error' => true,
                        'message' => 'No es posible eliminar cuentas que esten'.
                        ' siendo utilizadas en conversiones ó asientos contables.'
                    ],
                    200
                );
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
        $subgroup    = $parent->subgroup;
        /** @var string Contiene el código del ítem */
        $item        = $parent->item;
        /** @var string Contiene el código del generic */
        $generic     = $parent->generic;
        /** @var string Contiene el código del speific */
        $specific    = $parent->specific;
        /** @var string Contiene el código del subspecific */
        $subspecific = $parent->subspecific;

        if ($parent->subgroup === "0") {
            $currentSubgroup = AccountingAccount::where(['group' => $parent->group])
                                                ->orderBy('subgroup', 'desc')->first();

            $subgroup = (strlen(intval($currentSubgroup->subgroup)) < 2 || intval($currentSubgroup->subgroup) < 9)
                    ? (intval($currentSubgroup->subgroup) + 1) : $currentSubgroup->subgroup;
        } elseif ($parent->item === "0") {
            $currentItem = AccountingAccount::where(
                [
                    'group'    => $parent->group,
                    'subgroup' => $parent->subgroup
                ]
            )->orderBy('item', 'desc')->first();

            $item = (strlen(intval($currentItem->item)) < 2 || intval($currentItem->item) < 9)
                    ? (intval($currentItem->item) + 1) : $currentItem->item;
        } elseif ($parent->generic === "00") {
            $currentGeneric = AccountingAccount::where(
                [
                    'group'    => $parent->group,
                    'subgroup' => $parent->subgroup,
                    'item'     => $parent->item
                ]
            )->orderBy('generic', 'desc')->first();

            $generic = (strlen(intval($currentGeneric->generic)) < 2 || intval($currentGeneric->generic) < 99)
                       ? (intval($currentGeneric->generic) + 1) : $currentGeneric->generic;
            $generic = (strlen($generic) === 1) ? "0$generic" : $generic;
        } elseif ($parent->specific === "00") {
            $currentSpecific = AccountingAccount::where(
                [
                    'group'    => $parent->group,
                    'subgroup' => $parent->subgroup,
                    'item'     => $parent->item,
                    'generic'  => $parent->generic
                ]
            )->orderBy('specific', 'desc')->first();

            $specific = (strlen(intval($currentSpecific->specific)) < 2 || intval($currentSpecific->specific) < 99)
                        ? (intval($currentSpecific->specific) + 1) : $currentSpecific->specific;
            $specific = (strlen($specific) === 1) ? "0$specific" : $specific;
        } elseif ($parent->subspecific === "00") {
            $currentSubSpecific = AccountingAccount::where(
                [
                    'group'    => $parent->group,
                    'subgroup' => $parent->subgroup,
                    'item'     => $parent->item,
                    'generic'  => $parent->generic,
                    'specific' => $parent->specific
                ]
            )->orderBy('subspecific', 'desc')->first();

            $subspecific = (strlen(intval($currentSubSpecific->subspecific)) < 2
                            || intval($currentSubSpecific->subspecific) < 99)
                        ? (intval($currentSubSpecific->subspecific) + 1) : $currentSubSpecific->subspecific;
            $subspecific = (strlen($subspecific) === 1) ? "0$subspecific" : $subspecific;
        }

        $account = [
            'group'        => (string)$parent->group,
            'subgroup'     => (string)$subgroup,
            'item'         => (string)$item,
            'generic'      => (string)$generic,
            'specific'     => (string)$specific,
            'subspecific'  => (string)$subspecific,
            'denomination' => $parent->denomination,
            'active'       => $parent->active
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
        foreach (AccountingAccount::orderBy('group', 'ASC')
                                    ->orderBy('subgroup', 'ASC')
                                    ->orderBy('item', 'ASC')
                                    ->orderBy('generic', 'ASC')
                                    ->orderBy('specific', 'ASC')
                                    ->orderBy('subspecific', 'ASC')
                                    ->get() as $record) {
            /** @var array arreglo con datos de las cuentas patrimoniales*/
            array_push($records, [
                'id'           => $record->id,
                'code'         =>   $record->getCode(),
                'denomination' => $record->denomination,
                'active'       => $record->active,
                'text'         =>"{$record->getCode()} - {$record->denomination}",
            ]);
        }
        return $records;
    }

    public function import()
    {
        $this->validate(request(), [
            'file' => 'required|mimes:xls,xlsx,ods,csv'
        ]);

        $headings = (new HeadingRowImport)->toArray(request()->file('file'));
        $records = Excel::toArray(new DataImport, request()->file('file'))[0];
        $msg = '';

        if (count($headings) < 1 || $headings[0] < 1) {
            $msg = 'El archivo no contiene las cabeceras de los datos a importar.';
        } elseif (count($headings) === 1 && $headings[0] >= 1) {
            $validHeads = [
                'codigo', 'denominacion','activa'
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

        if (!empty($msg)) {
            return response()->json(['result' => false, 'message' => $msg], 200);
        }

        $file = Excel::toArray(new DataImport, request()->file('file'))[0];
        $records = [];

        $currentRow = 2;
        $rowErrors = [];
        foreach ($file as $record) {

            /** @var Array se almacena el código*/
            $CodeExplode = explode('.', $record['codigo']);

            /** se Agrega un 0 al inicio de ser necesario*/
            $n_cuenta_orden = ((int)$CodeExplode[3] > 9) ?
                                                    $CodeExplode[3]:'0'.(int)$CodeExplode[3];
            $n_subcuenta_primer_orden = ((int)$CodeExplode[4] > 9) ?
                                                    $CodeExplode[4]:'0'.(int)$CodeExplode[4];
            $n_subcuenta_segundo_orden = ((int)$CodeExplode[5] > 9) ?
                                                    $CodeExplode[5]:'0'.(int)$CodeExplode[5];

            /** @var Array para almacenar la información que se verificara */
            $recordCode = [
                'grupo'                     => $CodeExplode[0],
                'subgrupo'                  => $CodeExplode[1],
                'rubro'                     => $CodeExplode[2],
                'n_cuenta_orden'            => $n_cuenta_orden,
                'n_subcuenta_primer_orden'  => $n_subcuenta_primer_orden,
                'n_subcuenta_segundo_orden' => $n_subcuenta_segundo_orden,
                'activa'                    => $record['activa'],
            ];


            /** Se validan los errores en los formatos de las columnas en el archivo */
            foreach ($this->validatedErrors($recordCode, $currentRow) as $error) {
                array_push($rowErrors, $error);
            }

            $currentRow +=1;

            array_push($records, [
                'code'         =>$record['codigo'],
                'denomination' => $record['denominacion'],
                'active'       =>($record['activa'] == 'si') ? true : false,
                'group'        =>$recordCode['grupo'],
                'subgroup'     =>$recordCode['subgrupo'],
                'item'         =>$recordCode['rubro'],
                'generic'      =>$recordCode['n_cuenta_orden'],
                'specific'     =>$recordCode['n_subcuenta_primer_orden'],
                'subspecific'  =>$recordCode['n_subcuenta_segundo_orden'],
                ]);
        }

        if (count($rowErrors) > 0) {
            return response()->json(['result' => false, 'errors' => $rowErrors], 200);
        }

        return response()->json([ 'result' => true, 'records' => $records, 'errors' => $rowErrors ], 200);
    }

    /**
     * Registra en la base de datos todas las cuentas cargadas desde la hoja de cálculo
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return Array con los errores en caso de existir
    */
    public function registerImportedAccounts(Request $request)
    {
        foreach ($request->records as $account) {

            /** @var Object que almacena la consulta de la cuenta, si esta no existe retorna null */
            $acc = AccountingAccount::where('group', $account['group'])
                                ->where('subgroup', $account['subgroup'])
                                ->where('item', $account['item'])
                                ->where('generic', $account['generic'])
                                ->where('specific', $account['specific'])
                                ->where('subspecific', $account['subspecific'])->first();

            /** @var Object que almacena la consulta de la cuenta de nivel superior
            * de la cuanta actual, si esta no posee retorna false
            */
            $parent = AccountingAccount::getParent(
                $account['group'],
                $account['subgroup'],
                $account['item'],
                $account['generic'],
                $account['specific'],
                $account['subspecific']
            );

            AccountingAccount::updateOrCreate(
                [
                    'group'       => $account['group'],
                    'subgroup'    => $account['subgroup'],
                    'item'        => $account['item'],
                    'generic'     => $account['generic'],
                    'specific'    => $account['specific'],
                    'subspecific' => $account['subspecific'],
                ],
                [
                    'denomination' => $account['denomination'],
                    'active' => $account['active'],
                    'inactivity_date' => (!$account['active'])?date('Y-m-d'):null,

                    /**
                    * Si existe, evita que se asigne en la columna parent_id a si mismo como su parent
                    */
                    'parent_id' => ($acc != null && $parent != false) ?
                    (($acc->id == $parent->id)?null:$parent->id) : (($parent == false)?null:$parent->id) ,
                ]
            );
        }
        return response()->json(['records'=>$this->getAccounts(),
            'message'=>'Los registros importados fueron guardados de manera exitosa.']);
    }


    /**
     * Verifica los posibles errores que se pueden presentar en las filas de archivo y
     * agrega un mensaje del error para el usuario
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return Array con los errores en caso de existir
    */

    public function validatedErrors($record, $currentRow)
    {
        $errors = [];
        /** Se valida el formato y que el valor sea entero en el rango de min 0 y max 9 */
        if (! ctype_digit($record['grupo'])) {
            array_push($errors, 'La columna grupo en la fila '.$currentRow.
                ' debe ser entero y no debe contener caracteres ni simbolos.');
        }
        if ((int)$record['grupo'] > 9 || (int)$record['grupo'] < 0) {
            array_push($errors, 'La columna grupo en la fila '.$currentRow.
                ' no cumple con el formato valido, Número entero entre 0 y 9.');
        }

        /** Se valida el formato y que el valor sea entero en el rango de min 0 y max 9 */
        if (! ctype_digit($record['subgrupo'])) {
            array_push($errors, 'La columna subgrupo en la fila '.$currentRow.
                ' debe ser entero y no debe contener caracteres ni simbolos.');
        }
        if ((int)$record['subgrupo'] > 9 || (int)$record['subgrupo'] < 0) {
            array_push($errors, 'La columna subgrupo en la fila '.$currentRow.
                ' no cumple con el formato valido, Número entero entre 0 y 9.');
        }

        /** Se valida el formato y que el valor sea entero en el rango de min 0 y max 9 */
        if (! ctype_digit($record['rubro'])) {
            array_push($errors, 'La columna rubro en la fila '.$currentRow.
                ' debe ser entero y no debe contener caracteres ni simbolos.');
        }
        if ((int)$record['rubro'] > 9 || (int)$record['rubro'] < 0) {
            array_push($errors, 'La columna rubro en la fila '.$currentRow.
                ' no cumple con el formato valido, Número entero entre 0 y 9.');
        }

        /** Se valida el formato y que el valor sea entero en el rango de min 0 y max 99 */
        if (! ctype_digit($record['n_cuenta_orden'])) {
            array_push($errors, 'La columna n_cuenta_orden en la fila '.$currentRow.
                ' debe ser entero y no debe contener caracteres ni simbolos.');
        }
        if ((int)$record['n_cuenta_orden'] > 99 || (int)$record['n_cuenta_orden'] < 0) {
            array_push($errors, 'La columna n_cuenta_orden en la fila '.$currentRow.
                ' no cumple con el formato valido, Número entero entre 0 y 99.');
        }

        /** Se valida el formato y que el valor sea entero en el rango de min 0 y max 99 */
        if (! ctype_digit($record['n_subcuenta_primer_orden'])) {
            array_push($errors, 'La columna n_subcuenta_primer_orden en la fila '.$currentRow.
                ' debe ser entero y no debe contener caracteres ni simbolos.');
        }
        if ((int)$record['n_subcuenta_primer_orden'] > 99 || (int)$record['n_subcuenta_primer_orden'] < 0) {
            array_push($errors, 'La columna n_subcuenta_primer_orden en la fila '.$currentRow.
                ' no cumple con el formato valido, Número entero entre 0 y 99.');
        }

        /** Se valida el formato y que el valor sea entero en el rango de min 0 y max 99 */
        if (! ctype_digit($record['n_subcuenta_segundo_orden'])) {
            array_push($errors, 'La columna n_subcuenta_segundo_orden en la fila '.$currentRow.
                ' debe ser entero y no debe contener caracteres ni simbolos.');
        }
        if ((int)$record['n_subcuenta_segundo_orden'] > 99 || (int)$record['n_subcuenta_segundo_orden'] < 0) {
            array_push($errors, 'La columna n_subcuenta_segundo_orden en la fila '.$currentRow.
                ' no cumple con el formato valido, Número entero entre 0 y 99.');
        }


        /** Se valida que el valor en la columna de activa */
        if (strtolower($record['activa']) != 'si' && strtolower($record['activa']) != 'no') {
            array_push($errors, 'La columna activa en la fila '.$currentRow.
                ' no cumple con el formato valido, SI ó NO.');
        }

        return $errors;
    }
}
