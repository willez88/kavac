<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleChargeMoney;

class SaleChargeMoneyController extends Controller
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
    $records = SaleChargeMoney::all();
    foreach ($records as $record) {
      $list_attributes = [];
      $attrib = json_decode($record->attributes_charge_money, true);

      //list of attributes for options UPDATE content
      foreach ($attrib as $row) {
        $list_attributes[] = ["attributes" => $row];
      }

      $data[] = [
        'id' => $record->id,
        'name_charge_money' => $record->name_charge_money,
        'description_charge_money' => $record->description_charge_money,
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
    $attributes = [];
    if ($request->list_attributes && !empty($request->list_attributes)) {
      foreach ($request->list_attributes as $attribute) {
        $attributes[] = $attribute['attributes'];
      }
    }

    $this->validate($request, [
      'name_charge_money' => ['required', 'max:100'],
      'description_charge_money' => ['required', 'max:100']
    ]);

    $charge_money = SaleChargeMoney::create([
      'name_charge_money' => $request->name_charge_money,
      'description_charge_money' => $request->description_charge_money,
      'attributes_charge_money' => json_encode($attributes, JSON_FORCE_OBJECT)
    ]);

    return response()->json(['record' => $charge_money, 'message' => 'Success'], 200);
  }

  /**
   * Show the specified resource.
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
   * @return JsonResponse
   */
  public function update(Request $request, $id)
  {
    /** @var object Datos del metodo de cobro */
    $charge_money = SaleChargeMoney::find($id);

    $this->validate($request, [
      'name_charge_money' => ['required', 'max:100'],
      'description_charge_money' => ['required', 'max:100']
    ]);

    $attributes = [];
    if ($request->list_attributes && !empty($request->list_attributes)) {
      foreach ($request->list_attributes as $attribute) {
        $attributes[] = $attribute['attributes'];
      }
    }

    $charge_money->name_charge_money = $request->name_charge_money;
    $charge_money->description_charge_money = $request->description_charge_money;
    $charge_money->attributes_charge_money = json_encode($attributes, JSON_FORCE_OBJECT);
    $charge_money->save();
    return response()->json(['message' => 'Success'], 200);
  }

  /**
   * Remove the specified resource from storage.
   * @return JsonResponse
   */
  public function destroy(Request $request, $id)
  {
    $charge_money = SaleChargeMoney::find($id);
    $charge_money->delete();

    return response()->json(['record' => $charge_money, 'message' => 'Success'], 200);
  }
}
