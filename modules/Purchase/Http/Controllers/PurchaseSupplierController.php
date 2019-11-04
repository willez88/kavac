<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Country;
use App\Models\Estate;
use App\Models\RequiredDocument;
use App\Models\Phone;
use App\Rules\Rif as RifRule;
use Modules\Purchase\Models\PurchaseSupplierBranch;
use Modules\Purchase\Models\PurchaseSupplierObject;
use Modules\Purchase\Models\PurchaseSupplierSpecialty;
use Modules\Purchase\Models\PurchaseSupplierType;
use Modules\Purchase\Models\PurchaseSupplier;
use Modules\Purchase\Models\City;

class PurchaseSupplierController extends Controller
{
    use ValidatesRequests;

    protected $countries;
    protected $estates;
    protected $cities;
    protected $supplier_types;
    protected $supplier_branches;
    protected $supplier_specialties;
    protected $supplier_objects;
    protected $requiredDocuments;

    public function __construct()
    {
        $this->countries = template_choices(Country::class);
        $this->estates = template_choices(Estate::class);
        $this->cities = template_choices(City::class);
        $this->supplier_types = template_choices(PurchaseSupplierType::class);
        $this->supplier_branches = template_choices(PurchaseSupplierBranch::class);
        $this->supplier_specialties = template_choices(PurchaseSupplierSpecialty::class);

        $supplier_objects = ['' => 'Seleccione...', 'Bienes' => [], 'Obras' => [], 'Servicios' => []];
        $assets = $works = $services = [];

        foreach (PurchaseSupplierObject::all() as $so) {
            $type = ($so->type === 'B') ? 'Bienes' : (($so->type === 'O') ? 'Obras' : 'Servicios');
            $supplier_objects[$type][$so->id] = $so->name;
        }

        $this->supplier_objects = $supplier_objects;
        $this->requiredDocuments = RequiredDocument::where(['model' => 'supplier', 'module' => 'purchase'])->get();
    }

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

        return view('purchase::suppliers.create-edit-form', [
            'countries' => $this->countries, 'estates' => $this->estates, 'cities' => $this->cities,
            'supplier_types' => $this->supplier_types, 'supplier_objects' => $this->supplier_objects,
            'supplier_branches' => $this->supplier_branches, 'supplier_specialties' => $this->supplier_specialties,
            'header' => $header, 'requiredDocuments' => $this->requiredDocuments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'person_type' => ['required'],
            'company_type' => ['required'],
            'rif' => ['required', 'size:10', new RifRule],
            'name' => ['required'],
            'purchase_supplier_type_id' => ['required'],
            'purchase_supplier_object_id' => ['required'],
            'purchase_supplier_branch_id' => ['required'],
            'purchase_supplier_specialty_id' => ['required'],
            'city_id' => ['required'],
            'direction' => ['required'],
            'contact_name' => ['required'],
            'contact_email' => ['required'],
            'rnc_certificate_number' => ['required_with:rnc_status'],
            'phone_type' => ['array'],
            'phone_area_code' => ['array'],
            'phone_number' => ['array'],
            'phone_extension' => ['array'],
        ]);

        $supplier = PurchaseSupplier::create([
            'person_type' => $request->person_type,
            'company_type' => $request->company_type,
            'rif' => $request->rif,
            'code' => generate_code(PurchaseSupplier::class, 'code'),
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
        if ($request->phone_type && !empty($request->phone_type)) {
            foreach ($request->phone_type as $key => $phone_type) {
                $supplier->phones()->save(new Phone([
                    'type' => $phone_type,
                    'area_code' => $request->phone_area_code[$key],
                    'number' => $request->phone_number[$key],
                    'extension' => $request->phone_extension[$key]
                ]));
            }
        }

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
        //return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $model = PurchaseSupplier::find($id);

        $header = [
            'route' => ['purchase.suppliers.update', $model->id],
            'method' => 'PUT',
            'role' => 'form',
        ];

        return view('purchase::suppliers.create-edit-form', [
            'countries' => $this->countries, 'estates' => $this->estates, 'cities' => $this->cities,
            'supplier_types' => $this->supplier_types, 'supplier_objects' => $this->supplier_objects,
            'supplier_branches' => $this->supplier_branches, 'supplier_specialties' => $this->supplier_specialties,
            'header' => $header, 'model' => $model, 'requiredDocuments' => $this->requiredDocuments
        ]);
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
