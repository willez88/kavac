<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\Country;
use App\Models\Estate;
use Modules\Purchase\Models\PurchaseSupplierBranch;
use Modules\Purchase\Models\PurchaseSupplierObject;
use Modules\Purchase\Models\PurchaseSupplierSpecialty;
use Modules\Purchase\Models\PurchaseSupplierType;
use Modules\Purchase\Models\PurchaseSupplier;
use Modules\Purchase\Models\City;

class PurchaseSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('purchase::suppliers.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $countries = template_choices(Country::class);
        $estates = template_choices(Estate::class);
        $cities = template_choices(City::class);
        $supplier_types = template_choices(PurchaseSupplierType::class);
        $supplier_branches = template_choices(PurchaseSupplierBranch::class);
        $supplier_specialties = template_choices(PurchaseSupplierSpecialty::class);
        $supplier_objects = ['' => 'Seleccione...', 'Bienes' => [], 'Obras' => [], 'Servicios' => []];
        $assets = [];
        $works = [];
        $services = [];

        foreach (PurchaseSupplierObject::all() as $so) {
            $type = ($so->type === 'B') ? 'Bienes' : (($so->type === 'O') ? 'Obras' : 'Servicios');
            $supplier_objects[$type][$so->id] = $so->name;
        }
        return view(
            'purchase::suppliers.create-edit-form', 
            compact(
                'countries', 'estates', 'cities', 'supplier_types', 'supplier_objects', 'supplier_branches',
                'supplier_specialties'
            )
        );
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\View\View
     */
    public function destroy()
    {
    }

    /**
     * Obtiene listado de registros
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function vueList()
    {
        return response()->json(['records' => PurchaseSupplier::all()], 200);
    }
}
