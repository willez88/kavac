<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ReportRepository;
use App\Models\Institution;
use App\Models\Document;

class ReportController extends Controller
{
    public function create(Request $request, ReportRepository $reportRepository)
    {
        $institution = Institution::find(1);
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => 'www.google.com']);
        $pdf->setHeader('Formulación de Presupuesto', 'Mes de Septiembre');
        $pdf->setFooter();
        $pdf->setBody('budget::reports.formulation', true, [
            'formulation' => \Modules\Budget\Models\BudgetSubSpecificFormulation::find(1)
        ]);
    }

    public function sign(Request $request, ReportRepository $reportRepository)
    {
        //
    }

    public function verify(Document $document)
    {
    }
}
