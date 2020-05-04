<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleCodeFormat;

class SaleCodeFormatController extends Controller
{
    use ValidatesRequests;

    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => SaleCodeFormat::all()], 200);
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
          'formatcode' => ['required', 'max:17'],
          'type_formatcode' => ['required', 'max:50']
       ]);

       $formatCode = SaleCodeFormat::create([
         'formatcode' => $request->formatcode,
         'type_formatcode' => $request->type_formatcode
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
    public function update(Request $request, $id)
    {
      /** @var object Datos de la entidad bancaria */
      $formatCode = SaleCodeFormat::find($id);

      $this->validate($request, [
        'formatcode' => ['required', 'max:17'],
        'type_formatcode' => ['required', 'max:50']
      ]);

      $formatCode->formatcode = $request->formatcode;
      $formatCode->type_formatcode = $request->type_formatcode;
      $formatCode->save();

      return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Obtiene los datos de los distintos formatos de codigo
     * @return \Illuminate\Http\JsonResponse Devuelve un JSON con los dinstintos formatos de codigo
     */
    public function getCodeFormat()
    {
      foreach (SaleCodeFormat::all() as $code) {
         $this->data[] = [
           'id' => $code->id,
           'formatcode' => $code->formatcode,
           'type_formatcode' => $code->type_formatcode
         ];
      }

      return response()->json($this->data);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
      /** @var object Datos de la entidad bancaria */
      $formatCode = SaleCodeFormat::find($id);
      $formatCode->delete();
      return response()->json(['record' => $formatCode, 'message' => 'Success'], 200);
    }
}
