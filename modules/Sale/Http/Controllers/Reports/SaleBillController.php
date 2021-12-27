<?php

namespace Modules\Sale\Http\Controllers\Reports;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Repositories\ReportRepository;
use App\Models\CodeSetting;
use App\Models\Profile;
use App\Models\Institution;

use Modules\Sale\Models\SaleBill;
use Modules\Sale\Models\SaleBillInventoryProduct;
use Modules\Sale\Models\SaleWarehouseInventoryProduct;
use Auth;

/**
 * @class SaleBillController
 * @brief Controlador para la emision de una factura
 *
 * Clase que gestiona de la emision de una factura
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve | exodiadaniel@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL</a>
 */
class SaleBillController extends Controller
{
	/**
	 * Define la configuración de la clase
	 *
	 * @author Daniel Contreras <dcontreras@cenditel.gob.ve | exodiadaniel@gmail.com>
	 */
	public function __construct()
	{
		/** Establece permisos de acceso para cada método del controlador */
	}

		/**
	 * vista en la que se genera la emisión de la factura en pdf
	 *
	 * @author Daniel Contreras <dcontreras@cenditel.gob.ve | exodiadaniel@gmail.com>
	 * @param Int $id id de la factura
	*/
	public function pdf($id)
	{

		// Validar acceso para el registro

		$is_admin = auth()->user()->isAdmin();


		$sale_bills = SaleBill::where('state', 'Aprobado')->with(['SaleFormPayment', 'saleBillInventoryProduct' => function ($query) {
                        $query->with(['saleGoodsToBeTraded', 'currency', 'saleListSubservices', 'measurementUnit', 'historyTax',
                            'saleWarehouseInventoryProduct' => function ($q) {
                                $q->with('saleSettingProduct');
                        }]);
                    }])->find($id);
		// if (!$is_admin && $user_profile && $user_profile['institution']) {
		// 	// )->where('institution_id', $user_profile['institution']['id'])->find($id);
		// } else {
		// 	$requirement = AccountingEntry::with(
		// 		'accountingAccounts.account.accountConverters.budgetAccount',
		// 		'currency'
		// 	)->find($id);
		// }

		if (!auth()->user()->isAdmin()) {
			if ($requirement && $requirement->queryAccess($user_profile['institution']['id'])) {
				return view('errors.403');
			}
		}

		/**
		 * [$pdf base para generar el pdf]
		 * @var [Modules\Accounting\Pdf\Pdf]
		 */
		$pdf = new ReportRepository();

		/*
		 *  Definicion de las caracteristicas generales de la página pdf
		 */
		$institution = null;

		if (!$is_admin && $user_profile && $user_profile['institution']) {
			$institution = Institution::find($user_profile['institution']['id']);
		} else {
			$institution = '';
		}

		// $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('/purchase/purchase_requirement/pdf/'.$id)]);
		$pdf->setConfig(['institution' => Institution::first()]);
		$pdf->setHeader('Factura');
		$pdf->setFooter();
		$pdf->setBody('sale::pdf.bills', true, [
			'pdf'         => $pdf,
			'sale_bills' => $sale_bills
		]);
	}

}