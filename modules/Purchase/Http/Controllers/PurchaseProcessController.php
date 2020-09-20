<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Purchase\Models\PurchaseProcess;
use App\Models\Parameter;

class PurchaseProcessController extends Controller
{
    use ValidatesRequests;

    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @method  __construct
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
     *
     * @method  index
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => PurchaseProcess::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @method  create
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return Renderable
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @method  store
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'unique:purchase_processes,name'],
            'description' => ['required']
        ]);

        $process = PurchaseProcess::create([
            'name' => $request->name,
            'description' => $request->description,
            'require_documents' => (count($request->list_documents) > 0),
            'list_documents' => (count($request->list_documents) > 0) ? json_encode($request->list_documents) : null
        ]);

        return response()->json(['record' => $process, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     *
     * @method  show
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return Renderable
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @method  edit
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return Renderable
     */
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @method  update
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => ['required'],
        ]);

        $data = [
            'require_documents' => (count($request->list_documents) > 0),
            'list_documents' => (count($request->list_documents) > 0) ? json_encode($request->list_documents) : null
        ];

        if (!is_null($request->name)) {
            $data['name'] = $request->name;
        }
        if (!is_null($request->description)) {
            $data['description'] = $request->description;
        }

        $process = PurchaseProcess::updateOrCreate(['id' => $request->id], $data);

        return response()->json(['record' => $process, 'message' => 'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @method  destroy
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse
     */
    public function destroy(PurchaseProcess $purchaseProcess)
    {
        $purchaseProcess->delete();
        return response()->json(['record' => $purchaseProcess, 'message' => 'Success'], 200);
    }

    /**
     * Método que permite obtener un listado de procesos de compra ya registrados
     *
     * @method     getProcesses
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     JsonResponse
     */
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

    /**
     * Método que permite obtener un listado de documentos a solicitar para los procesos de compra
     *
     * @method     getProcessDocuments
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      Request $request    Datos de la petición
     *
     * @return     JsonResponse
     */
    public function getProcessDocuments(Request $request)
    {
        $listDocuments = [];
        $process = null;
        $processDocuments = Parameter::where([
            'p_key' => 'process_documents',
            'required_by' => 'purchase',
            'active' => true,
        ])->first();
        // return $request->all();
        if ($request->id) {
            $process = PurchaseProcess::find($request->id);
        }

        if (!is_null($processDocuments)) {
            foreach (json_decode($processDocuments->p_value) as $processDocument) {
                array_push($listDocuments, [
                    'id' => $processDocument->id,
                    'title' => $processDocument->title,
                    'documents' => $processDocument->documents
                ]);
            }
        }

        return response()->json([
            'records' => $listDocuments,
            'selected' => (!is_null($process) && !is_null($process->list_documents)) ? $process->list_documents : null
        ], 200);
    }
}
