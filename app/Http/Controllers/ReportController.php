<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elibyy\TCPDF\TCPDF as PDF;
use App\Repositories\ReportRepository;
use App\Models\Institution;
use App\Models\Document;

/**
 * @class ReportController
 * @brief Gestiona información de reportes de la aplicación
 *
 * Controlador para gestionar reportes de la aplicación
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ReportController extends Controller
{
    /**
     * Crea un nuevo reporte
     *
     * @method    create
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request             $request             Objeto con información de la petición
     * @param     ReportRepository    $reportRepository    Objeto con los método necesarios para gestionar los reportes
     */
    public function create(Request $request, ReportRepository $reportRepository)
    {
        /*$institution = Institution::find(1);
        $pdf = new PDF(config('app.name'));
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => 'www.cenditel.gob.ve']);
        $pdf->setHeader(__('Formulación de Presupuesto'), __('Mes de Septiembre'));
        $pdf->setFooter();
        $pdf->setBody('budget::reports.formulation', true, [
            'formulation' => \Modules\Budget\Models\BudgetSubSpecificFormulation::find(1)
        ]);*/
    }

    /**
     * Realiza el proceso de firma digital de un reporte
     *
     * @method    sign
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request             $request             Objeto con información de la petición
     * @param     ReportRepository    $reportRepository    Objeto con los método necesarios para gestionar los reportes
     */
    public function sign(Request $request, ReportRepository $reportRepository)
    {
        //
    }

    /**
     * Verifica la autenticidad de una firma en un reporte
     *
     * @method    verify
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Document    $document    Objeto con información del documento a verificar
     */
    public function verify(Document $document)
    {
        //
    }
}
