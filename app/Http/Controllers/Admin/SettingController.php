<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use App\Models\Institution;
use App\Models\Country;
use App\Models\Estate;
use App\Models\Municipality;
use App\Models\Parish;
use App\Models\City;
use App\Models\InstitutionSector;
use App\Models\InstitutionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @class SettingController
 * @brief Gestiona información de configuración general
 * 
 * Controlador para gestionar configuraciones
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class SettingController extends Controller
{
    /**
     * Muesta todos los registros de los parámetros de configuración de la aplicación
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $model_setting = Setting::where('active', true)->first();
        $header_setting = [
            'route' => 'settings.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        $model_institution = Institution::where(['active' => true, 'default' => false])->first();
        $header_institution = [
            'route' => 'institutions.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
            'enctype' => 'multipart/form-data'
        ];

        $organism_adscripts = (!is_null($model_institution)) ? template_choices(
            Institution::class, 'name', [], false, $model_institution->id
        ) : ['' => 'Seleccione...'];
        $institutions = Institution::all();
        $countries = template_choices(Country::class);
        $estates = template_choices(Estate::class);
        $municipalities = template_choices(Municipality::class);
        $parishes = template_choices(Parish::class);
        $cities = template_choices(City::class);
        $sectors = template_choices(InstitutionSector::class);
        $types = template_choices(InstitutionType::class);

        return view(
            'admin.settings',
            compact(
                'model_setting', 'header_setting', 'model_institution', 'header_institution', 
                'institutions', 'countries', 'estates', 'municipalities', 'parishes', 'cities', 
                'sectors', 'types', 'organism_adscripts'
            )
        );
    }

    /**
     * Valida y registra los parámetros de configuración de la aplicación
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $setting = Setting::updateOrCreate(
            ['active' => true],
            [
                'support' => ($request->support!==null),
                'chat' => ($request->chat!==null),
                'notify' => ($request->notify!==null),
                'report_banner' => ($request->report_banner!==null),
                'multi_institution' => ($request->multi_institution!==null),
                'digital_sign' => ($request->digital_sign!==null)
            ]
        );
        
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('settings.index');
    }
}
