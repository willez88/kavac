<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elibyy\TCPDF\TCPDF as PDF;
use App\Repositories\ReportRepository;
use App\Models\Institution;
use App\Models\Document;

class ReportController extends Controller
{
    public function create(Request $request, ReportRepository $reportRepository)
    {
        /*$institution = Institution::find(1);
        $pdf = new PDF(config('app.name'));
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => 'www.google.com']);
        $pdf->setHeader(__('Formulación de Presupuesto'), __('Mes de Septiembre'));
        $pdf->setFooter();
        $pdf->setBody('budget::reports.formulation', true, [
            'formulation' => \Modules\Budget\Models\BudgetSubSpecificFormulation::find(1)
        ]);*/
    }

    public function sign(Request $request, ReportRepository $reportRepository)
    {
        //
    }

    public function verify(Document $document)
    {
    }
}
