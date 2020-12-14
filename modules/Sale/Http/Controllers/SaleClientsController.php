<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleClients;
use App\Rules\Rif as RifRule;

class SaleClientsController extends Controller
{
    use ValidatesRequests;

    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => SaleClients::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sale::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'rif' => ['required', 'max:17', new RifRule],
            'type_person_juridica' => ['required'],
            'name' => ['required'],
            'country_id' => ['required'],
            'estate_id' => ['required'],
            'city_id' => ['required'],
            'municipality_id' => ['required'],
            'parish_id' => ['required'],
            'address' => ['required', 'max:200'],
            'address_tax' => ['required', 'max:200'],
            'name_client' => ['required'],
            'email_client' => ['required'],
            'phone_client' => ['nullable', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
        ]);

        $client = new SaleClients;
        $client->rif = $request->rif;
        $client->type_person_juridica = $request->type_person_juridica;
        $client->name = $request->name;
        $client->country_id = $request->country_id;
        $client->estate_id = $request->estate_id;
        $client->city_id = $request->city_id;
        $client->municipality_id = $request->municipality_id;
        $client->parish_id = $request->parish_id;
        $client->address = $request->address;
        $client->address_tax = $request->address_tax;
        $client->name_client = $request->name_client;
        $client->email_client = $request->email_client;
        $client->phone_client = $request->phone_client;
        $client->save();

        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $client->phones()->save(new Phone([
                    'type' => $phone['type'],
                    'area_code' => $phone['area_code'],
                    'number' => $phone['number'],
                    'extension' => $phone['extension']
                ]));
            }
        }

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('sale.register-clients.index')], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        /** @var object Datos de la entidad bancaria */
        $client = SaleClients::find($id);

        $this->validate($request, [
            'rif' => ['required', 'max:17', new RifRule],
            'type_person_juridica' => ['required'],
            'name' => ['required'],
            'country_id' => ['required'],
            'estate_id' => ['required'],
            'city_id' => ['required'],
            'municipality_id' => ['required'],
            'parish_id' => ['required'],
            'address' => ['required', 'max:200'],
            'address_tax' => ['required', 'max:200'],
            'name_client' => ['required'],
            'email_client' => ['required'],
            'phone_client' => ['nullable', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
        ]);

        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate($request, [
                'phones.'.$i.'.type' => ['required'],
                'phones.'.$i.'.area_code' => ['required', 'digits:3'],
                'phones.'.$i.'.number' => ['required', 'digits:7'],
                'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
            ]);
            $i++;
        }

        $client->rif = $request->rif;
        $client->type_person_juridica = $request->type_person_juridica;
        $client->name = $request->name;
        $client->country_id = $request->country_id;
        $client->estate_id = $request->estate_id;
        $client->city_id = $request->city_id;
        $client->municipality_id = $request->municipality_id;
        $client->parish_id = $request->parish_id;
        $client->address = $request->address;
        $client->address_tax = $request->address_tax;
        $client->name_client = $request->name_client;
        $client->email_client = $request->email_client;
        $client->phone_client = $request->phone_client;
        $client->save();

        foreach ($client->phones as $phone) {
            $phone->delete();
        }

        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $client->phones()->updateOrCreate(
                    [
                        'type' => $phone['type'], 'area_code' => $phone['area_code'],
                        'number' => $phone['number'], 'extension' => $phone['extension']
                    ],
                    [
                        'type' => $phone['type'], 'area_code' => $phone['area_code'],
                        'number' => $phone['number'], 'extension' => $phone['extension']
                    ]
                );
            }
        }

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.register-clients.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy()
    {
        $client = client::find($id);
        $client->delete();
        return response()->json(['record' => $client, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene el rif de los clientes registrados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los productos
     */
    public function getSaleClientsRif()
    {
        return response()->json(template_choices(SaleClients::class, 'rif', '', true));
    }

    /**
     * Obtiene el rif de los clientes registrados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los productos
     */
    public function getSaleClient($id)
    {
        $saleClient = SaleClients::find($id);
        return response()->json(['sale_client' => $saleClient], 200);
    }
}
