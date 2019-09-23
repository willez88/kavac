<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Purchase\Models\PurchaseProcess;
use App\Models\Parameter;

class PurchaseProcessController extends Controller
{
    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        $this->data[0] = [
            'id' => '',
            'text' => 'Seleccione...'
        ];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => PurchaseProcess::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('purchase::create');
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

    public function getProcesses()
    {
        foreach (PurchaseProcess::all() as $process) {
            $this->data[] = [
                'id' => $process->id,
                'text' => $process->name
            ];
        }

        return response()->json($this->data);
    }

    public function getProcessDocuments(Request $request)
    {
        $listDocuments = [];
        $processDocuments = Parameter::where([
            'p_key' => 'process_documents',
            'required_by' => 'purchase',
            'active' => true,
        ])->first();

        if ($request->id) {
            $process = PurchaseProcess::find($request->id);
        }

        if (!is_null($processDocuments)) {
            foreach (json_decode($processDocuments->p_value) as $processDocument) {
                array_push($listDocuments, [
                    'title' => $processDocument->title,
                    'documents' => $processDocument->documents
                ]);
            }
        }

        return response()->json(['records' => $listDocuments], 200);
    }
}
