<?php

namespace Modules\Purchase\Http\Controllers\Reports;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Repositories\ReportRepository;
use Modules\Purchase\Models\PurchaseRequirement;
use Modules\Purchase\Models\FiscalYear;
use App\Models\Profile;
use App\Models\Institution;
use Auth;

/**
 * @class PurchaseRequirementController
 * @brief Controlador para la generación del reporte de requerimiento
 *
 * Clase que gestiona de la generación del reporte de requerimiento
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PurchaseRequirementController extends Controller
{
	/**
	 * Define la configuración de la clase
	 *
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 */
	public function __construct()
	{
		/** Establece permisos de acceso para cada método del controlador */
	}

		/**
	 * vista en la que se genera el reporte en pdf de balance de comprobación
	 *
	 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
	 * @param Int $id id del asiento contable
	*/
	public function pdf($id)
	{

		// Validar acceso para el registro

		$is_admin = auth()->user()->isAdmin();

		$user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

		$requirement = PurchaseRequirement::with(
			'contratingDepartment',
	        'userDepartment',
	        'fiscalYear',
	        'purchaseSupplierObject',
	        'purchaseRequirementItems.warehouseProduct.measurementUnit'
		)->find($id);

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
		$pdf->setConfig(['institution' => Institution::first(), 'urlVerify' => url('/purchase/purchase_requirement/pdf/'.$id)]);
		$pdf->setHeader('Requerimiento '.$requirement->code, 'Reporte pdf de requerimiento '.$requirement->code);
		$pdf->setFooter();
		$pdf->setBody('purchase::pdf.requirements', true, [
			'pdf'         => $pdf,
			'requirement' => $requirement
		]);
	}

	public function getCheckBreak()
	{
		return $this->PageBreakTrigger;
	}
}