<?php

/** Controladores para la gestión de servicios generales del sistema */
namespace App\Http\Controllers\Services;

use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Estate;
use App\Models\Municipality;
use App\Models\Parish;
use App\Models\City;

/**
 * @class LocatesController
 * @brief Gestiona información de servicios de localización
 *
 * Controlador para gestionar servicios de localización (Países, Estados, Municipios, Parroquias, Ciudades, etc...)
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class LocatesController extends Controller
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
            'text' => __('Seleccione...')
        ];
    }

    /**
     * Obtiene todos los Países registrados
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @property string $country Identificador del país
     * @return \Illuminate\Http\JsonResponse JSON con los datos de los Países registrados
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
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $country_id Identificador del País
     * @return \Illuminate\Http\JsonResponse    JSON con los datos de los Estados asociados al País indicado
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
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $estate_id Identificador del Estado
     * @return \Illuminate\Http\JsonResponse    JSON con los datos de los Municipios asociados al Estado indicado
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
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $estate_id Identificador del Estado
     * @return \Illuminate\Http\JsonResponse    JSON con los datos de las Ciudades asociadas al Estado indicado
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
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  integer $municipality_id Identificador del Municipio
     * @return \Illuminate\Http\JsonResponse      JSON con los datos de las Parroquias asociadas a un Municipio
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
