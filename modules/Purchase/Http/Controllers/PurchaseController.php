<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\FiscalYear;

class PurchaseController extends Controller
{
    /**
     * Obtiene el año fiscal actual
     * @return JsonResponse
     */
    public function getFiscalYear()
    {
        $fiscal_year = FiscalYear::where('active', true)->first();
        return response()->json(['fiscal_year'=> $fiscal_year, 'message' => 'success'], 200);
    }

    /**
     * Obtine un listado de las instituciones
     * @return JsonResponse
     */
    public function getInstitutions()
    {
        $institutions = template_choices('App\Models\Institution', 'name', [], true);
        return response()->json(['institutions'=> $institutions, 'message' => 'success'], 200);
    }
}
