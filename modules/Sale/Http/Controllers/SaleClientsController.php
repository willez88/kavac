<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleClients;
use Modules\Sale\Models\SaleClientsEmail;
use App\Models\Phone;
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
        return response()->json(['records' => SaleClients::with(['saleClientsEmail', 'phones'])->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'rif' => ['required_if:type_person_juridica,Jurídica', 'max:17'],
            'business_name' => ['required_if:type_person_juridica,Jurídica'],
            'type_person_juridica' => ['required'],
            'representative_name' => ['required_if:type_person_juridica,Jurídica'],
            'name' => ['required_if:type_person_juridica,Natural'],
            'country_id' => ['required'],
            'estate_id' => ['required'],
            'municipality_id' => ['required'],
            'parish_id' => ['required', 'max:200'],
            'address_tax' => ['required', 'max:200'],
            'name_client' => ['required_if:type_person_juridica,Jurídica'],
            'id_type' => ['required_if:type_person_juridica,Natural'],
            'id_number' => ['required_if:type_person_juridica,Natural'],
        ]);

        $client = new SaleClients;
        $client->type_person_juridica = $request->type_person_juridica;
        $client->rif = $request->rif;
        $client->business_name = $request->business_name;
        $client->representative_name = $request->representative_name;
        $client->name = $request->name;
        $client->country_id = $request->country_id;
        $client->estate_id = $request->estate_id;
        $client->municipality_id = $request->municipality_id;
        $client->parish_id = $request->parish_id;
        $client->address_tax = $request->address_tax;
        $client->name_client = $request->name_client;
        $client->id_type = $request->id_type;
        $client->id_number = $request->id_number;
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

        if ($request->emails && !empty($request->emails)) {
            foreach ($request->emails as $email) {
                $clientEmail = SaleClientEmail::create([
                    'email'          => $email['email'],
                    'sale_client_id' => $client->id
                ]);
            }
        }

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('sale.settings.index')], 200);
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
    public function update(Request $request, $id)
    {
        /** @var object Datos de la entidad bancaria */
        $client = SaleClients::find($id);

        $this->validate($request, [
            'rif' => ['required_if:type_person_juridica,Jurídica', 'max:17'],
            'business_name' => ['required_if:type_person_juridica,Jurídica'],
            'type_person_juridica' => ['required'],
            'representative_name' => ['required_if:type_person_juridica,Jurídica'],
            'name' => ['required_if:type_person_juridica,Natural'],
            'country_id' => ['required'],
            'estate_id' => ['required'],
            'municipality_id' => ['required'],
            'parish_id' => ['required', 'max:200'],
            'address_tax' => ['required', 'max:200'],
            'name_client' => ['required_if:type_person_juridica,Jurídica'],
            // 'emails' => ['required'],
            // 'phones' => ['nullable', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
            'id_type' => ['required_if:type_person_juridica,Natural'],
            'id_number' => ['required_if:type_person_juridica,Natural'],
        ]);

        // $i = 0;
        // foreach ($request->phones as $phone) {
        //     $this->validate($request, [
        //         'phones.'.$i.'.type' => ['required'],
        //         'phones.'.$i.'.area_code' => ['required', 'digits:3'],
        //         'phones.'.$i.'.number' => ['required', 'digits:7'],
        //         'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
        //     ]);
        //     $i++;
        // }

        $client->rif = $request->rif;
        $client->business_name = $request->business_name;
        $client->type_person_juridica = $request->type_person_juridica;
        $client->representative_name = $request->representative_name;
        $client->name = $request->name;
        $client->country_id = $request->country_id;
        $client->estate_id = $request->estate_id;
        $client->municipality_id = $request->municipality_id;
        $client->parish_id = $request->parish_id;
        $client->address_tax = $request->address_tax;
        $client->name_client = $request->name_client;
        $client->emails = $request->emails;
        $client->phones = $request->phones;
        $client->id_type = $request->id_type;
        $client->id_number = $request->id_number;
        $client->save();

        // foreach ($client->phones as $phone) {
        //     $phone->delete();
        // }

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
        return response()->json(['result' => true, 'redirect' => route('sale.settings.index')], 200);
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
     * Muestra una lista de los tipos de bienes
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return JsonResponse
     */

    public function getSaleClientsRif()
    {
        $records = [];
        $saleClients = SaleClients::orderBy('id', 'ASC')->get();

        array_push($records, ['id' => '', 'text' => 'Seleccione...']);

        foreach ($saleClients as $saleClient) {
            if ($saleClient->type_person_juridica == 'Natural') {
                array_push($records, [
                    'id'            => $saleClient->id,
                    'text'          => $saleClient->name.' - '.$saleClient->id_type.$saleClient->id_number,
                ]);
            } elseif ($saleClient->type_person_juridica == 'Jurídica') {
                array_push($records, [
                    'id'            => $saleClient->id,
                    'text'          => $saleClient->business_name.' - '.$saleClient->rif,
                ]);
            }
        }
        return response()->json(['records' => $records], 200);
    }

    /**
     * Obtiene los clientes registrados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse    Json con los datos de los productos
     */
    public function getSaleClient($id)
    {
        $saleClient = SaleClients::with(['phones', 'sale_clients_email'])->find($id);
        return response()->json(['sale_client' => $saleClient], 200);
    }
}
