<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
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
     * @return Renderable
     */
    public function index()
    {
        return view('purchase::suppliers.list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
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
     * @return Renderable
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'person_type'                    => ['required'],
            'company_type'                   => ['required'],
            'rif'                            => ['required', 'size:10', new RifRule],
            'name'                           => ['required'],
            'purchase_supplier_type_id'      => ['required'],
            'purchase_supplier_object_id'    => ['required'],
            'purchase_supplier_branch_id'    => ['required'],
            'purchase_supplier_specialty_id' => ['required'],
            'country_id'                     => ['required'],
            'estate_id'                      => ['required'],
            'city_id'                        => ['required'],
            'direction'                      => ['required'],
            'contact_name'                   => ['required'],
            'contact_email'                  => ['required'],
            'rnc_certificate_number'         => ['required_with:rnc_status'],
            'phone_type'                     => ['array'],
            'phone_area_code'                => ['array'],
            'phone_number'                   => ['array'],
            'phone_extension'                => ['array'],
        ],
        [
            'person_type.required'                    => 'El campo tipo de persona es obligatorio.',
            'company_type.required'                   => 'El campo tipo de empresa es obligatorio.',
            'rif.required'                            => 'El campo rif es obligatorio.',
            'name.required'                           => 'El campo nombre es obligatorio.',
            'purchase_supplier_type_id.required'      => 'El campo denominación comercial es obligatorio.',
            'purchase_supplier_object_id.required'    => 'El campo objeto principal es obligatorio.',
            'purchase_supplier_branch_id.required'    => 'El campo rama es obligatorio.',
            'purchase_supplier_specialty_id.required' => 'El campo especialidad es obligatorio.',
            'country_id.required'                     => 'El campo pais es obligatorio.',
            'estate_id.required'                      => 'El campo estado es obligatorio.',
            'city_id.required'                        => 'El campo ciudad es obligatorio.',
            'direction.required'                      => 'El campo dirección fiscal es obligatorio.',
            'contact_name.required'                   => 'El campo nombre de contacto es obligatorio.',
            'contact_email.required'                  => 'El campo correo electrónico de contacto es obligatorio.',
        ]);
        $supplier = PurchaseSupplier::create([
            'person_type'                    => $request->person_type,
            'company_type'                   => $request->company_type,
            'rif'                            => $request->rif,
            'code'                           => generate_code(PurchaseSupplier::class, 'code'),
            'name'                           => $request->name,
            'direction'                      => $request->direction,
            'contact_name'                   => $request->contact_name,
            'contact_email'                  => $request->contact_email,
            'website'                        => $request->website ?? null,
            'active'                         => $request->active ? true : false,
            'purchase_supplier_object_id'    => $request->purchase_supplier_object_id,
            'purchase_supplier_branch_id'    => $request->purchase_supplier_branch_id,
            'purchase_supplier_specialty_id' => $request->purchase_supplier_specialty_id,
            'purchase_supplier_type_id'      => $request->purchase_supplier_type_id,
            'country_id'                     => $request->country_id,
            'estate_id'                      => $request->estate_id,
            'city_id'                        => $request->city_id,
            'rnc_status'                     => $request->rnc_status ?? 'NOI',
            'rnc_certificate_number'         => $request->rnc_certificate_number ?? null
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
     * @return Renderable
     */
    public function show()
    {
        //return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
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
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'person_type'                    => ['required'],
            'company_type'                   => ['required'],
            'rif'                            => ['required', 'size:10', new RifRule],
            'name'                           => ['required'],
            'purchase_supplier_type_id'      => ['required'],
            'purchase_supplier_object_id'    => ['required'],
            'purchase_supplier_branch_id'    => ['required'],
            'purchase_supplier_specialty_id' => ['required'],
            'country_id'                     => ['required'],
            'estate_id'                      => ['required'],
            'city_id'                        => ['required'],
            'direction'                      => ['required'],
            'contact_name'                   => ['required'],
            'contact_email'                  => ['required'],
            'rnc_certificate_number'         => ['required_with:rnc_status'],
            'phone_type'                     => ['array'],
            'phone_area_code'                => ['array'],
            'phone_number'                   => ['array'],
            'phone_extension'                => ['array'],
        ],
        [
            'person_type.required'                    => 'El campo tipo de persona es obligatorio.',
            'company_type.required'                   => 'El campo tipo de empresa es obligatorio.',
            'rif.required'                            => 'El campo rif es obligatorio.',
            'name.required'                           => 'El campo nombre es obligatorio.',
            'purchase_supplier_type_id.required'      => 'El campo denominación comercial es obligatorio.',
            'purchase_supplier_object_id.required'    => 'El campo objeto principal es obligatorio.',
            'purchase_supplier_branch_id.required'    => 'El campo rama es obligatorio.',
            'purchase_supplier_specialty_id.required' => 'El campo especialidad es obligatorio.',
            'country_id.required'                     => 'El campo pais es obligatorio.',
            'estate_id.required'                      => 'El campo estado es obligatorio.',
            'city_id.required'                        => 'El campo ciudad es obligatorio.',
            'direction.required'                      => 'El campo dirección fiscal es obligatorio.',
            'contact_name.required'                   => 'El campo nombre de contacto es obligatorio.',
            'contact_email.required'                  => 'El campo correo electrónico de contacto es obligatorio.',
        ]);

        $supplier = PurchaseSupplier::find($id);

        $supplier->person_type                    = $request->person_type;
        $supplier->company_type                   = $request->company_type;
        $supplier->rif                            = $request->rif;
        $supplier->code                           = $supplier->code;
        $supplier->name                           = $request->name;
        $supplier->direction                      = $request->direction;
        $supplier->contact_name                   = $request->contact_name;
        $supplier->contact_email                  = $request->contact_email;
        $supplier->website                        = $request->website ?? null;
        $supplier->active                         = $request->active ? true : false;
        $supplier->purchase_supplier_object_id    = $request->purchase_supplier_object_id;
        $supplier->purchase_supplier_branch_id    = $request->purchase_supplier_branch_id;
        $supplier->purchase_supplier_specialty_id = $request->purchase_supplier_specialty_id;
        $supplier->purchase_supplier_type_id      = $request->purchase_supplier_type_id;
        $supplier->country_id                     = $request->country_id;
        $supplier->estate_id                      = $request->estate_id;
        $supplier->city_id                        = $request->city_id;
        $supplier->rnc_status                     = $request->rnc_status ?? 'NOI';
        $supplier->rnc_certificate_number         = $request->rnc_certificate_number ?? null;

        $supplier->save();

        /** Se elimina la relacion de proveedor con los telefonos anteriores **/
        $supp_ph = $supplier->phones()->get();
        if (count($supp_ph) > 0) {
            foreach ($supp_ph as $value) {
                $value->delete();
            }
        }

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
     * Remove the specified resource from storage.
     * @return Renderable
     */
    public function destroy($id)
    {
        /**
         * Objeto con la información asociada al modelo PurchaseSupplier
         * @var Object $supplier
         */
        $supplier = PurchaseSupplier::with('purchaseOrder')->find($id);

        if ($supplier && count($supplier->purchaseOrder) > 0) {
            return response()->json([
                'error'   => true,
                'message' => 'El registro no se puede eliminar, debido a que esta siendo usado por ordenes de compra.'
            ], 200);
        }
        if ($supplier) {
            /** Se elimina la relacion de proveedor con los telefonos anteriores **/
            $supp_ph = $supplier->phones()->get();
            if (count($supp_ph) > 0) {
                foreach ($supp_ph as $value) {
                    $value->delete();
                }
            }
            $supplier->delete();
        }
        return response()->json(['records' => PurchaseSupplier::orderBy('id')->get(),
        'message'=>'Success'], 200);
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
