<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequestType;

class CitizenServiceRequestTypeController extends Controller
{
    use ValidatesRequests;
    /**
      * Define la configuración de la clase
      *
      * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
      */
    public function index()
    {
        return response()->json(['records' => CitizenServiceRequestType::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('citizenservice::create');
    }

    /**
     * Valida y registra un nuevo tipo de solicitud
     *
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => ['required', 'max:100'],
            'description' => ['max:200']
        ]);
        $citizenserviceRequestType = CitizenServiceRequestType::create([
            'name'        => $request->name,
            'description' => $request->description
        ]);
        return response()->json(['record' => $citizenserviceRequestType, 'message' => 'Success'], 200);
    }


    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('citizenservice::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('citizenservice::edit');
    }

    /**
     * Actualiza la información del tipo de solicitud
     *
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $citizenserviceRequestType = CitizenServiceRequestType::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['max:200']
        ]);
        $citizenserviceRequestType->name        = $request->name;
        $citizenserviceRequestType->description = $request->description;
        $citizenserviceRequestType->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el tipo de solicitud
     *
     * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
     * @return Response
     */
    public function destroy($id)
    {
        $citizenserviceRequestType = CitizenServiceRequestType::find($id);
        $citizenserviceRequestType->delete();
        return response()->json(['record' => $citizenserviceRequestType, 'message' => 'Success'], 200);
    }

    public function getRequestTypes()
    {
        return template_choices('Modules\CitizenService\Models\CitizenServiceRequestType', 'name', [], true, null);
    }
}
