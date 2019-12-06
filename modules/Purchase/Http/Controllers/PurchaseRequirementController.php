<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseSupplierObject;
use Modules\Accounting\Models\AccountingAccount;

class PurchaseRequirementController extends Controller
{
    protected $supplier_objects;

    public function __construct()
    {
        $supplier_objects = [
            ['id' => '',          'text' => 'Seleccione...'],
            ['id' => 'Bienes',    'text' => []],
            ['id' => 'Obras',     'text' => []],
            ['id' => 'Servicios', 'text' => []]
        ];
        // dd($supplier_objects);
        // $pos = 1;
        foreach (PurchaseSupplierObject::all() as $so) {
            $type = ($so->type === 'B') ? 'Bienes' : (($so->type === 'O') ? 'Obras' : 'Servicios');

            for ($i=1; $i < count($supplier_objects); $i++) {
                if ($type == $supplier_objects[$i]['id'] && is_array($supplier_objects[$i]['text'])) {
                    $supplier_objects[$i]['text'][$so->id] = $so->name;
                }
            }
        }
        // dd($supplier_objects);
        $this->supplier_objects = $supplier_objects;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('purchase::requirements.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $supplier_objects = $this->supplier_objects;
        $acc = AccountingAccount::where('id', '<', 10)->get();
        $acc = [
            ['id' => '',          'text' => 'Seleccione...'],
            ['id' => 'Bienes',    'text' => 'asd'],
            ['id' => 'Obras',     'text' => 'asd2'],
            ['id' => 'Servicios', 'text' => 'asd3']
        ];

        // dd($supplier_objects);
        return view('purchase::requirements.form', ['supplier_objects' => json_encode($supplier_objects),
                                                    'acc' => $acc]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
