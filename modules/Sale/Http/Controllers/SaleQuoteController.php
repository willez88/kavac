<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleQuote;

class SaleQuoteController extends Controller
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
      return response()->json(['records' => SaleQuote::all()], 200);
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
        'name_enterprise' => ['required'],
        'address_applicant' => ['required'],
        'name_applicant' => ['required'],
        'email_applicant' => ['required'],
        'phone_applicant' => ['nullable', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
        'quantity_product' => ['required', 'max:200'],
        'unit_product' => ['required', 'max:200'],
        'payment_type_product' => ['required'],
        'reply_deadline_product' => ['required']
      ]);

      $quote = new SaleQuote;
      $quote->name_enterprise = $request->name_enterprise;
      $quote->address_applicant = $request->address_applicant;
      $quote->name_applicant = $request->name_applicant;
      $quote->email_applicant = $request->email_applicant;
      $quote->phone_applicant = $request->phone_applicant;
      $quote->quantity_product = $request->quantity_product;
      $quote->unit_product = $request->measurement_units;
      $quote->payment_type_product = $request->payment_type_product;
      $quote->reply_deadline_product = $request->reply_deadline_product;
      $quote->save();

      $request->session()->flash('message', ['type' => 'store']);
      return response()->json(['result' => true, 'redirect' => route('sale.register-quote.index')], 200);
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
      $quote = SaleQuote::find($id);

      $this->validate($request, [
        'name_enterprise' => ['required'],
        'address_applicant' => ['required'],
        'name_applicant' => ['required'],
        'email_applicant' => ['required'],
        'phone_applicant' => ['nullable', 'regex:/^\d{2}-\d{3}-\d{7}$/u'],
        'quantity_product' => ['required', 'max:200'],
        'unit_product' => ['required', 'max:200'],
        'payment_type_product' => ['required'],
        'reply_deadline_product' => ['required']
      ]);

      $quote->name_enterprise = $request->name_enterprise;
      $quote->address_applicant = $request->address_applicant;
      $quote->name_applicant = $request->name_applicant;
      $quote->email_applicant = $request->email_applicant;
      $quote->phone_applicant = $request->phone_applicant;
      $quote->quantity_product = $request->quantity_product;
      $quote->unit_product = $request->measurement_units;
      $quote->payment_type_product = $request->payment_type_product;
      $quote->reply_deadline_product = $request->reply_deadline_product;
      $quote->save();

      $request->session()->flash('message', ['type' => 'update']);
      return response()->json(['result' => true, 'redirect' => route('sale.register-quote.index')], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
      $quote = quote::find($id);
      $quote->delete();
      return response()->json(['record' => $quote, 'message' => 'Success'], 200);
    }
}
