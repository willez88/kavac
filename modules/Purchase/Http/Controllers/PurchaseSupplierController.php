<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Country;
use App\Models\Estate;
use App\Models\RequiredDocument;
use Modules\Purchase\Models\PurchaseSupplierBranch;
use Modules\Purchase\Models\PurchaseSupplierObject;
use Modules\Purchase\Models\PurchaseSupplierSpecialty;
use Modules\Purchase\Models\PurchaseSupplierType;
use Modules\Purchase\Models\PurchaseSupplier;
use Modules\Purchase\Models\City;

class PurchaseSupplierController extends Controller
{
    use ValidatesRequests;

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
        $header = [
            'route' => 'purchase.suppliers.store', 
            'method' => 'POST', 
            'role' => 'form',
        ];
        $countries = template_choices(Country::class);
        $estates = template_choices(Estate::class);
        $cities = template_choices(City::class);
        $supplier_types = template_choices(PurchaseSupplierType::class);
        $supplier_branches = template_choices(PurchaseSupplierBranch::class);
        $supplier_specialties = template_choices(PurchaseSupplierSpecialty::class);
        $supplier_objects = ['' => 'Seleccione...', 'Bienes' => [], 'Obras' => [], 'Servicios' => []];
        $assets = $works = $services = [];

        foreach (PurchaseSupplierObject::all() as $so) {
            $type = ($so->type === 'B') ? 'Bienes' : (($so->type === 'O') ? 'Obras' : 'Servicios');
            $supplier_objects[$type][$so->id] = $so->name;
        }

        $requiredDocuments = RequiredDocument::where(['model' => 'supplier', 'module' => 'purchase'])->get();

        return view(
            'purchase::suppliers.create-edit-form', 
            compact(
                'countries', 'estates', 'cities', 'supplier_types', 'supplier_objects', 'supplier_branches',
                'supplier_specialties', 'header', 'requiredDocuments'
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
        $this->validate($request, [
            'person_type' => 'required',
            'company_type_type' => 'required',
            'rif' => 'required',
            'name' => 'required',
            'purchase_supplier_type_id' => 'required',
            'purchase_supplier_object_id' => 'required',
            'purchase_supplier_branch_id' => 'required',
            'purchase_supplier_specialty_id' => 'required',
            'city_id' => 'required',
            'direction' => 'required',
            'contact_name' => 'required',
            'contact_email' => 'required',
            'rnc_certificate_number' => 'required_with:rnc_status',
            'phone_type' => 'array',
            'phone_area_code' => 'array',
            'phone_number' => 'array',
            'phone_extension' => 'array',
        ]);

        $supplier = PurchaseSupplier::create([
            'person_type' => $request->person_type,
            'company_type' => $request->company_type,
            'rif' => $request->rif,
            'code' => '', // Generar código aleatorio de 20 caracteres
            'name' => $request->name,
            'direction' => $request->direction,
            'contact_name' => $request->contact_name,
            'contact_email' => $request->contact_email,
            'website' => $request->website ?? null,
            'active' => ($request->active),
            'purchase_supplier_object_id' => $request->purchase_supplier_object_id,
            'purchase_supplier_branch_id' => $request->purchase_supplier_branch_id,
            'purchase_supplier_specialty_id' => $request->purchase_supplier_specialty_id,
            'purchase_supplier_type_id' => $request->purchase_supplier_type_id,
            'city_id' => $request->city_id,
            'rnc_status' => $request->rnc_status ?? 'NOI',
            'rnc_certificate_number' => $request->rnc_certificate_number ?? null
        ]);

        /** Asociación de números telefónicos */

        /** Registro y asociación de documentos */

        session()->flash('message', ['type' => 'store']);

        return redirect()->route('purchase.suppliers.index');
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
