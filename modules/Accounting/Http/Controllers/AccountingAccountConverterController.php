<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Accounting\Models\Accountable;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\BudgetAccount;

use Module;

/**
 * @class AccountingAccountConverterController
 * @brief Controlador para la conversión de cuentas presupuestarias y patrimoniales
 *
 * Clase que gestiona la conversión entre cuentas presupuestarias y patrimoniales
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AccountingAccountConverterController extends Controller
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
		 *Establece permisos de acceso para cada método del controlador
		 */
		$this->middleware('permission:accounting.converter.index', ['only' => 'index']);
		$this->middleware('permission:accounting.converter.create', ['only' => ['create', 'store']]);
		$this->middleware('permission:accounting.converter.edit', ['only' => ['update']]);
		$this->middleware('permission:accounting.converter.delete', ['only' => 'destroy']);
	}

	/**
	 * [index Muestra la vista principal para mostrar las conversiones]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @return Renderable
	 */
	public function index()
	{
		/**
		 * [$has_budget determina si esta instalado el modulo Budget]
		 * @var [boolean]
		 */
		$has_budget = (Module::has('Budget') && Module::isEnabled('Budget'));
		return view('accounting::account_converters.index', compact('has_budget'));
	}

	/**
	 * [getAllRecordsAccountingVuejs registros de las cuentas patrimoniales al componente]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @return [response]
	 */
	public function getAllRecordsAccountingVuejs()
	{
		return response()->json(['records'=>$this->getRecordsAccounting()]);
	}

	/**
	 * [getAllRecordsBudgetVuejs registros de las cuentas presupuestarias al componente]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @return [response]
	 */
	public function getAllRecordsBudgetVuejs()
	{
		return response()->json(['records'=>$this->getRecordsBudget()]);
	}

	/**
	 * [create Muestra un formulario para crear conversiones de cuentas]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @return Renderable
	 */
	public function create()
	{
		/**
		 * [$has_budget determina si esta instalado el modulo Budget]
		 * @var [boolean]
		 */
		$has_budget = (Module::has('Budget') && Module::isEnabled('Budget'));

		if (!Module::has('Budget') || !Module::isEnabled('Budget')) {
			return view('accounting::account_converters.create', compact('has_budget'));
		}

		/**
		 * [$accountingList contiene las cuentas patrimoniales]
		 * @var [Json]
		 */
		$accountingList = json_encode($this->getRecordsAccounting());

		/**
		 * [$accountingList contiene las cuentas presupuestarias]
		 * @var [Json]
		 */
		$budgetList = json_encode($this->getRecordsBudget());

		return view('accounting::account_converters.create', compact('has_budget', 'accountingList', 'budgetList'));
	}

	/**
	 * Crea una nuevas conversiones
	 * ejemplo de datos que recibe la función
	 * {
			'module'                : 'Budget',		Nombre del modulo hacia el cual se relacionara el registro
			'model'                 : Modules\\Accounting\\Models\\BudgetAccount',  Clase a la que se hara la relacion
			'accountable_id'        : id, identificador del registro a relacionar
			'accounting_account_id' : id, identificador de la cuenta patrimonial
		}

	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param  [Request] $request 
	 * @return [Response]
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'module'				=> ['required'],
			'model'					=> ['required'],
			'accounting_account_id' => ['required'],
			'accountable_id'     	=> ['required'],
		]);

		$account = AccountingAccount::find($request->accounting_account_id);
		// dd($account);
		/**
		 * Crea el registro de conversiones
		 */
		if (Module::has($request->module) && Module::isEnabled($request->module)) {

			foreach (Accountable::where('accounting_account_id', $request->accounting_account_id)
								->where('active', true)->orderBy('id', 'ASC')->get() as $accountable) {
				$accountable->active = false;
				$accountable->save();
			}

			foreach (Accountable::where('accountable_id', $request->accountable_id)
									->where('accountable_type', $request->model)
									->where('active', true)->orderBy('id', 'ASC')->get() as $accountable) {
				$accountable->active = false;
				$accountable->save();
			}

			Accountable::create([
				'accounting_account_id' => $request->accounting_account_id,
				'accountable_type'		=> $request->model,
				'accountable_id'		=> $request->accountable_id,
				'active'				=> true,
			]);
			
			return response()->json(['message'=>'Success'], 200);
		}
		return response()->json(['message'=>'No se pudo crear la relacion entre registros.'], 200);
	}

	/**
	 * [edit Muestra el formulario para la edición de conversión de cuentas]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param  [integer] $id [Identificador de la conversión a modificar]
	 * @return Renderable
	 */
	public function edit($id)
	{
		/**
		 * [$has_budget determina si esta instalado el modulo Budget]
		 * @var [boolean]
		 */
		$has_budget = (Module::has('Budget') && Module::isEnabled('Budget'));

		if (!$has_budget) {
			return view('accounting::account_converters.edit', compact('has_budget'));
		}

		/**
		 * [$account contine el registro de conversión a editar]
		 * @var [Modules\Accounting\Models\Accountable]
		 */
		$account = Accountable::find($id);

		/**
		 * [$records_accounting contiene las cuentas patrimoniales disponibles]
		 * @var [Json]
		 */
		$accountingAccounts = json_encode($this->getRecordsAccounting());

		/**
		 * [$records_busget contiene las cuentas presupuestarias disponibles]
		 * @var [Json]
		 */
		$budgetAccounts = json_encode($this->getRecordsBudget());

		return view(
			'accounting::account_converters.edit',
			compact('has_budget', 'account', 'accountingAccounts', 'budgetAccounts')
		);
	}

	/**
	 * [update Actualiza los datos de la conversión]
	 * ejemplo de datos que recibe la función en $request
	 * {
			'module'                : 'Budget',		Nombre del modulo hacia el cual se relacionara el registro
			'model'                 : Modules\\Accounting\\Models\\BudgetAccount',  Clase a la que se hara la relacion
			'accountable_id'        : id, identificador del registro a relacionar
			'accounting_account_id' : id, identificador de la cuenta patrimonial
		}

	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param  [Request] $request [Objeto con datos de la petición a realizar]
	 * @param  [integer] $id      [Identificador de la conversión a modificar]
	 * @return [Response]
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, [
			'module'				=> ['required'],
			'model'					=> ['required'],
			'accounting_account_id' => ['required'],
			'accountable_id'     	=> ['required'],
		]);

		if (Module::has($request->module) && Module::isEnabled($request->module)){
			/**
			 * Actualiza el registro de conversión a editar
			 */
			$record = Accountable::find($id);

			$record->accounting_account_id 	= $request->accounting_account_id;
			$record->accountable_id       	= $request->accountable_id;
			$record->accountable_type 		= $request->model;
			$record->save();

			return response()->json(['message'=>'Success'], 200);
		}

		return response()->json(['message'=>'No se pudo crear la relacion entre registros.'], 200);
	}

	/**
	 * [destroy Elimina un conversión]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param  [integer] $id [Identificador de la conversión a eliminar]
	 * @return [Response]
	 */
	public function destroy($id)
	{
		/**
		 * [$convertion registro de conversión a eliminar]
		 * @var [Modules\Accounting\Models\Accountable]
		 */
		$convertion = Accountable::find($id);

		if ($convertion) {
			$convertion->delete();
		}
		return response()->json(['records' => [], 'message' => 'Success'], 200);
	}

	/**
	 * [getRecords registros en un rango de ids dado]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param  Request $request [parametros de busqueda]
	 * @return Response
	 */
	public function getRecords(Request $request)
	{
		/**
		 * [$records contendra registros]
		 * @var array
		 */
		$records = [];

		/**
		 * [$init_id id de rango inicial de busqueda]
		 * @var integer
		 */
		$init_id = 0;

		/**
		 * [$end_id id de rango final de busqueda]
		 * @var integer
		 */
		$end_id = 0;

		if (!$request->all) {
			$init_id = $request->init_id = ($request->init_id > $request->end_id)? $request->end_id : $request->init_id;
			$end_id  = $request->end_id = ($request->init_id > $request->end_id) ? $request->init_id : $request->end_id;
		}

		if ($request->type == 'budget') {
			if ($request->all) {
				/**
				 * Se obtienen el primer y ultimo id de las cuentas presupuestarias
				*/
				$init_id = \Modules\Budget\Models\BudgetAccount::orderBy('created_at', 'ASC')
																->where('parent_id', null)->first()->id;
				$end_id  = \Modules\Budget\Models\BudgetAccount::orderBy('created_at', 'DESC')->first()->id;
			}

			/**
			 * [$query contine los registros de conversión a en un rango de ids]
			 * @var [Modules\Accounting\Models\Accountable]
			 */
			$query = Accountable::with('budgetAccount', 'accountingAccount')
											->where('accountable_id', '>=', $init_id)
											->where('accountable_id', '<=', $end_id)
											->orderBy('id', 'ASC')->get();
		} elseif ($request->type == 'accounting') {
			if ($request->all) {
				/**
				 * Se obtienen el primer y ultimo id de las cuentas patrimoniales
				*/
				$init_id = AccountingAccount::orderBy('created_at', 'ASC')->where('parent_id', null)->first()->id;
				$end_id  = AccountingAccount::orderBy('created_at', 'DESC')->first()->id;
			}

			/**
			 * [$query contine los registros de conversión a en un rango de ids]
			 * @var [Modules\Accounting\Models\Accountable]
			 */
			$query = Accountable::with('accountingAccount', 'budgetAccount')->where('accounting_account_id', '>=', $init_id)
											->where('accounting_account_id', '<=', $end_id)
											->orderBy('id', 'ASC')->get();
			// dd($query);
		}

		$records = [];
		$cont = 0;

		foreach ($query as $r) {
			$records[$cont] = [
				'id'                 => $r['id'],
				'codeAccounting'     => $r['accountingAccount']->getCodeAttribute(),
				'accounting_account' => $r['accountingAccount']['denomination'],
				'codeBudget'         => $r['budgetAccount']->getCodeAttribute(),
				'budget_account'     => $r['budgetAccount']['denomination'],
			];
			$cont++;
		}
		return response()->json(['records'=>$records, 'message'=>'Success',200]);
	}

	/**
	 * Consulta los registros del modelo AccountingAccount que posean conversión
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param  Request $request [array con listado de cuentas a convertir]
	 *                             true= todo, false=solo sin conversiones
	 * @return Array
	 */
	public function getRecordsAccounting()
	{
		/**
		 * [$records contendra registros]
		 * @var array
		 */
		$records = [];
		$index = 0;
		array_push($records, [
			'id'   => '',
			'text' =>   "Seleccione..."
		]);

		/**
		 * ciclo para almacenar en array cuentas patrimoniales disponibles para conversiones
		*/
		foreach (AccountingAccount::with('accountable')
				->where('active', true)
				->orderBy('group', 'ASC')
				->orderBy('subgroup', 'ASC')
				->orderBy('item', 'ASC')
				->orderBy('generic', 'ASC')
				->orderBy('specific', 'ASC')
				->orderBy('subspecific', 'ASC')
				->orderBy('denomination', 'ASC')
				->cursor() as $AccountingAccount) {
			array_push($records, [
					'id'   => $AccountingAccount->id,
					'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
				]);
			$index++;
		}

		$records[0]['index'] = $index;

		/**
		 * se convierte array a JSON
		 */
		return $records;
	}

	/**
	 * [getRecordsBudget Consulta los registros del modelo BudgetAccount que posean conversión]
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @return [json]
	 */
	public function getRecordsBudget()
	{
		/**
		 * [$records contendra registros]
		 * @var null
		 */
		$records = null;
		$index = 0;

		if (Module::has('Budget') && Module::isEnabled('Budget')) {
			$records = [];
			array_push($records, [
				'id'   => '',
				'text' =>   "Seleccione..."
			]);

			/**
			 * ciclo para almacenar en array cuentas presupuestarias disponibles para conversiones
			*/
			foreach (BudgetAccount::with('accountingAccounts')
				->where('active', true)
				->orderBy('group', 'ASC')
				->orderBy('item', 'ASC')
				->orderBy('generic', 'ASC')
				->orderBy('specific', 'ASC')
				->orderBy('subspecific', 'ASC')
				->orderBy('denomination', 'ASC')
				->cursor() as $AccountingAccount) {
				array_push($records, [
					'id'   => $AccountingAccount->id,
					'text' =>   "{$AccountingAccount->getCodeAttribute()} - {$AccountingAccount->denomination}"
				]);
			}
			$index++;
		}

		$records[0]['index'] = $index;
		/**
		 * se convierte array a JSON
		 */
		return $records;
	}

	/**
	 * [budgetToAccount cuenta patrimonial correspondiente a la presupuestaria]
	 * @author    Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param  [integer] $id [id de cuenta patrimonial]
	 * @return [Response]     [cuenta patrimonial correspondiente a la presupuestaria]
	 */
	public function budgetToAccount($id)
	{
		/**
		 * [$convertion registros relacionados]
		 * @var [Modules\Accounting\Models\Accountable]
		 */
		$convertion = Accountable::with('accountingAccount')->where('accountable_id', $id)->first();
		return response()->json(['record'=> $convertion->accounting_account,'message'=>'Success'], 200);
	}

	/**
	 * [accountToBudget cuenta presupuestaria correspondiente a la patrimonial]
	 * @author    Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param  [integer] $id [id de cuenta presupuestaria]
	 * @return [Response]     [cuenta presupuestaria correspondiente a la patrimonial]
	 */
	public function accountToBudget($id)
	{
		/**
		 * [$convertion registros relacionados]
		 * @var [Modules\Accounting\Models\Accountable]
		 */
		$convertion = Accountable::with('budgetAccount')->where('accounting_account_id', $id)->first();
		return response()->json(['record'=> $convertion->budgetAccount,'message'=>'Success'], 200);
	}
}
