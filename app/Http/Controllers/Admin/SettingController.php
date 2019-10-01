<?php

/** Controladores de uso exclusivo para usuarios administradores */
namespace App\Http\Controllers\Admin;

use App\Models\Parameter;
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
use App\Repositories\ParameterRepository;

/**
 * @class SettingController
 * @brief Gestiona información de configuración general
 *
 * Controlador para gestionar configuraciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SettingController extends Controller
{
    /**
     * Muesta todos los registros de los parámetros de configuración de la aplicación
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function index()
    {
        //$model_parameters = Setting::where('active', true)->first();
        $paramSupport = Parameter::where([
            'active' => true, 'required_by' => 'core',
            'p_key' => 'support', 'p_value' => 'true'
        ])->first();
        $paramChat = Parameter::where([
            'active' => true, 'required_by' => 'core',
            'p_key' => 'chat', 'p_value' => 'true'
        ])->first();
        $paramNotify = Parameter::where([
            'active' => true, 'required_by' => 'core',
            'p_key' => 'notify', 'p_value' => 'true'
        ])->first();
        $paramReportBanner = Parameter::where([
            'active' => true, 'required_by' => 'core',
            'p_key' => 'report_banner', 'p_value' => 'true'
        ])->first();
        $paramMultiInstitution = Parameter::where([
            'active' => true, 'required_by' => 'core',
            'p_key' => 'multi_institution', 'p_value' => 'true'
        ])->first();
        $paramDigitalSign = Parameter::where([
            'active' => true, 'required_by' => 'core',
            'p_key' => 'digital_sign', 'p_value' => 'true'
        ])->first();
        $paramOnline = Parameter::where([
            'active' => true, 'required_by' => 'core',
            'p_key' => 'online', 'p_value' => 'true'
        ])->first();

        $header_parameters = [
            'route' => 'settings.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        $model_institution = null;
        if (is_null($paramMultiInstitution)) {
            $model_institution = Institution::where([
                'active' => true,
                'default' => true
            ])->first();
        }
        $header_institution = [
            'route' => 'institutions.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
            'enctype' => 'multipart/form-data'
        ];

        $organism_adscripts = (!is_null($model_institution)) ? template_choices(
            Institution::class,
            'name',
            [],
            false,
            $model_institution->id
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
                'header_parameters',
                'paramSupport',
                'paramChat',
                'paramNotify',
                'paramReportBanner',
                'paramMultiInstitution',
                'paramDigitalSign',
                'paramOnline',
                'model_institution',
                'header_institution',
                'institutions',
                'countries',
                'estates',
                'municipalities',
                'parishes',
                'cities',
                'sectors',
                'types',
                'organism_adscripts'
            )
        );
    }

    /**
     * Valida y registra los parámetros de configuración de la aplicación
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, ParameterRepository $parameterRepository)
    {
        $parameters = ['support', 'chat', 'notify', 'report_banner', 'multi_institution', 'digital_sign', 'online'];
        $msgType = ['type' => 'store'];

        foreach ($parameters as $parameter) {
            $parameterRepository->updateOrCreate(
                ['p_key' => $parameter, 'required_by' => 'core'],
                ['p_value' => (!is_null($request->$parameter)) ? 'true' : 'false']
            );

            if ($parameter === "online") {
                if (is_null($request->$parameter)) {
                    \Artisan::call('up');
                    $msgType = [
                        'type' => 'other',
                        'text' => 'El sistema esta actualmente en en línea, ' .
                        'todos los usuarios pueden acceder a la aplicación'
                    ];
                } else {
                    \Artisan::call('down', ['--allow' => $request->ip()]);
                    $msgType = [
                        'type' => 'other',
                        'text' => 'El sistema esta actualmente en mantenimiento, ' .
                        'solo puede acceder a la aplicación desde este equipo'
                    ];
                }
            }
        }

        $request->session()->flash('message', $msgType);
        return redirect()->route('settings.index');
    }
}
