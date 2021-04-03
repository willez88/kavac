<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleFormPayment;
//use Illuminate\Support\Facades\Log;

class SaleFormPaymentController extends Controller
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
    $data = [];
    $records = SaleFormPayment::all();
    foreach ($records as $record) {
      $list_attributes = [];
      $attrib = json_decode($record->attributes_form_payment, true);

      //list of attributes for options UPDATE content
      foreach ($attrib as $row) {
        $list_attributes[] = ["attributes" => $row];
      }

      $data[] = [
        'id' => $record->id,
        'name_form_payment' => $record->name_form_payment,
        'description_form_payment' => $record->description_form_payment,
        'created_at' => $record->created_at,
        'updated_at' => $record->updated_at,
        'name_attributes' => implode(", ", $attrib),
        'list_attributes' => $list_attributes
      ];
    }

    return response()->json(['records' => $data], 200);
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
    //Log::error( 'DEV- ' . print_r($request->list_attributes, 1));
    $attributes = [];
    if ($request->list_attributes && !empty($request->list_attributes)) {
      foreach ($request->list_attributes as $attribute) {
        $attributes[] = $attribute['attributes'];
      }
    }

    $this->validate($request, [
      'name_form_payment' => ['required', 'max:100'],
      'description_form_payment' => ['required', 'max:100']
    ]);

    $form_payment = SaleFormPayment::create([
      'name_form_payment' => $request->name_form_payment,
      'description_form_payment' => $request->description_form_payment,
      'attributes_form_payment' => json_encode($attributes, JSON_FORCE_OBJECT)
    ]);

    return response()->json(['record' => $form_payment, 'message' => 'Success'], 200);
  }

  /**
   * Show the specified resource.
   * @param int $id
   * @return Renderable
   */
  public function show($id)
  {
    return view('sale::show');
  }

  /**
   * Show the form for editing the specified resource.
   * @return Renderable
   */
  public function edit($id)
  {
    return view('sale::edit');
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @param int $id
   * @return JsonResponse
   */
  public function update(Request $request, $id)
  {
    /** @var object Datos de la forma de cobro */
    $form_payment = SaleFormPayment::find($id);

    $this->validate($request, [
      'name_form_payment' => ['required', 'max:100'],
      'description_form_payment' => ['required', 'max:100']
    ]);

    $attributes = [];
    if ($request->list_attributes && !empty($request->list_attributes)) {
      foreach ($request->list_attributes as $attribute) {
        $attributes[] = $attribute['attributes'];
      }
    }

    $form_payment->name_form_payment = $request->name_form_payment;
    $form_payment->description_form_payment = $request->description_form_payment;
    $form_payment->attributes_form_payment = json_encode($attributes, JSON_FORCE_OBJECT);
    $form_payment->save();

    return response()->json(['message' => 'Success'], 200);
  }

  /**
   * Remove the specified resource from storage.
   * @param int $id
   * @return Renderable
   */
  public function destroy(Request $request, $id)
  {
    $form_payment = SaleFormPayment::find($id);
    $form_payment->delete();

    return response()->json(['record' => $form_payment, 'message' => 'Success'], 200);
  }
}
