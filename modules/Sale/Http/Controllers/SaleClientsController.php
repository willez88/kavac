<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Sale\Models\SaleClients;

class SaleClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
      return response()->json(['records' => SaleClients::orderBy('id')->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('sale::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
      $this->validate($request, [
        'rif' => ['required', 'max:17', 'unique:sale_clients,formatcode']
      ]);

      $formatCode = SaleClients::create([
        'rif' => $request->rif,
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'name' => $request->name,
        'email' => $request->email,
        'typeformat' => $request->typeformat,
        'country_id' => $request->country_id,
        'parish_id' => $request->parish_id,
        'address' => $request->address,
        'address_tax' => $request->address_tax,
        'phone' => $request->address,
      ]);

      return response()->json(['record' => $formatCode, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('sale::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('sale::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
       /** @var object Datos de la entidad bancaria */
       $formatCode = SaleClients::find($id);

       $this->validate($request, [
         'rif' => ['required', 'max:17', 'unique:sale_clients,rif']
       ]);

       $formatCode->rif = $request->rif;
       $formatCode->save();

      return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
