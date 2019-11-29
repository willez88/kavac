<?php

namespace Modules\CitizenService\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\CitizenService\Models\CitizenServiceRequest;
use App\Models\Phone;

class CitizenServiceRequestController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        // return view('citizenservice::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('citizenservice::requests.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name'                       => ['required', 'max:100'],
            'last_name'                        => ['required', 'max:100'],
            'id_number'                        => ['required', 'max:12', 'regex:/^([\d]{7}|[\d]{8})$/u'],
            'email'                            => ['required', 'email'],
            'date'                             => ['required'],
            'payroll_sector_type_id'           => ['required'],
            'institution_name'                 => ['required', 'max:200'],
            'city_id'                          => ['required'],
            'municipality_id'                  => ['required'],
            'institution_address'              => ['required', 'max:200'],
            'web'                              => ['required', 'max:200'],
            'citizen_service_request_type_id'  => ['required'],
            'information'                      => ['required', 'max:200']
        ]);

        if ($request->citizen_service_request_type_id == 1) {
            $this->validate($request, [
                'institution'                      => ['required'],
                'team'                             => ['required'],
                'brand'                            => ['required'],
                'model'                            => ['required'],
                'serial'                           => ['required'],
                'color'                            => ['required'],
                'transfer'                         => ['required'],
                'code'                             => ['required'],
                'entryhour'                        => ['required'],
                'exithour'                         => ['required'],
                'informationteam'                  => ['required'],
            ]);
        }

        
       
        $i = 0;
        foreach ($request->phones as $phone) {
            $this->validate($request, [
                'phones.'.$i.'.type' => ['required'],
                'phones.'.$i.'.area_code' => ['required', 'digits:3'],
                'phones.'.$i.'.number' => ['required', 'digits:7'],
                'phones.'.$i.'.extension' => ['nullable', 'digits_between:3,6'],
            ]);
            $i++;
        }
        
        error_log($request->id_number);
        //Guardar los registros del formulario en  citizensrviceRequest
        $citizenserviceRequest = CitizenServiceRequest::create([
            'first_name'                       => $request->first_name,
            'last_name'                        => $request->last_name,
            'id_number'                        => $request->id_number,
            'email'                            => $request->email,
            'date'                             => $request->date,
            'payroll_sector_type_id'           => $request->payroll_sector_type_id,
            'institution_name'                 => $request->institution_name,
            'city_id'                          => $request->city_id,
            'municipality_id'                  => $request->municipality_id,
            'institution_address'              => $request->institution_address,
            'web'                              => $request->web,
            'citizen_service_request_type_id'  => $request->citizen_service_request_type_id,
            'information'                      => $request->information
        ]);


        if ($request->phones && !empty($request->phones)) {
            foreach ($request->phones as $phone) {
                $citizenserviceRequest->phones()->save(new Phone([
                    'type' => $phone['type'],
                    'area_code' => $phone['area_code'],
                    'number' => $phone['number'],
                    'extension' => $phone['extension']
                ]));
            }
        }
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
