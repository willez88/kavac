<?php

namespace App\Http\Controllers\Services;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Estate;
use App\Models\Municipality;
use App\Models\Parish;
use App\Models\City;

class LocatesController extends Controller
{
	protected $data = [];

	public function __construct() {
		$this->data[0] = [
    		'id' => 0,
    		'text' => 'Seleccione...'
    	];
	}

	/**
	 * Obtiene todos los Países registrados
	 * @return [json] JSON con los datos de los Países registrados
	 */
    public function getCountries()
    {
    	foreach (Country::all() as $country) {
    		$this->data[] = [
    			'id' => $country->id,
    			'text' => $country->name
    		];
    	}

    	return response()->json($this->data);
    }

    /**
     * Obtiene los Estados asociados al País indicado
     * @param  [integer] $country_id Identificador del País
     * @return [json]             	JSON con los datos de los Estados asociados al País indicado
     */
    public function getEstates($country_id)
    {
    	foreach (Estate::where('country_id', $country_id)->get() as $estate) {
    		$this->data[] = [
    			'id' => $estate->id,
    			'text' => $estate->name
    		];
    	}

    	return response()->json($this->data);
    }

    /**
     * Obtiene los Municipios de un Estado
     * @param  [integer] $estate_id Identificador del Estado
     * @return [json]            	JSON con los datos de los Municipios asociados al Estado indicado
     */
    public function getMunicipalities($estate_id)
    {
    	foreach (Municipality::where('estate_id', $estate_id)->get() as $municipality) {
    		$this->data[] = [
    			'id' => $municipality->id,
    			'text' => $municipality->name
    		];
    	}

    	return response()->json($this->data);
    }

    /**
     * Obtiene las Ciudades asociadas a un Estado
     * @param  [integer] $estate_id Identificador del Estado
     * @return [json]            	JSON con los datos de las Ciudades asociadas al Estado indicado
     */
    public function getCities($estate_id)
    {
    	foreach (City::where('estate_id', $estate_id)->get() as $city) {
    		$this->data[] = [
    			'id' => $city->id,
    			'text' => $city->name
    		];
    	}

    	return response()->json($this->data);
    }

    /**
     * Obtiene las Parroquias de un Municipio
     * @param  [integer] $municipality_id Identificador del Municipio
     * @return [json]                  	  JSON con los datos de las Parroquias asociadas al Municipio indicado
     */
    public function getParishes($municipality_id)
    {
    	foreach (Parish::where('municipality_id', $municipality_id)->get() as $parish) {
    		$this->data[] = [
    			'id' => $parish->id,
    			'text' => $parish->name
    		];
    	}

    	return response()->json($this->data);
    }
}
