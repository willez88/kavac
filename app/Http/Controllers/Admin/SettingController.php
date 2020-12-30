<?php

/** Controladores de uso exclusivo para usuarios administradores */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Parameter;
use App\Models\Institution;
use App\Models\Country;
use App\Models\Estate;
use App\Models\Municipality;
use App\Models\Parish;
use App\Models\City;
use App\Models\InstitutionSector;
use App\Models\InstitutionType;
use App\Http\Controllers\Controller;
use App\Repositories\ParameterRepository;
use App\Roles\Models\Role;
use App\Notifications\System as AppNotification;

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
        $parameters = Parameter::where([
            'active' => true, 'required_by' => 'core', 'p_value' => 'true'
        ])->get();

        $paramSupport = $parameters->filter(function ($param) {
            return $param->p_key === 'support';
        })->first();
        $paramChat = $parameters->filter(function ($param) {
            return $param->p_key === 'chat';
        })->first();
        $paramNotify = $parameters->filter(function ($param) {
            return $param->p_key === 'notify';
        })->first();
        $paramReportBanner = $parameters->filter(function ($param) {
            return $param->p_key === 'report_banner';
        })->first();
        $paramMultiInstitution = $parameters->filter(function ($param) {
            return $param->p_key === 'multi_institution';
        })->first();
        $paramDigitalSign = $parameters->filter(function ($param) {
            return $param->p_key === 'digital_sign';
        })->first();
        $paramOnline = $parameters->filter(function ($param) {
            return $param->p_key === 'online';
        })->first();

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
        $social_networks = [
            'facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'telegram'
        ];

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
                'organism_adscripts',
                'social_networks'
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
                        'text' => 'El sistema esta actualmente en línea, ' .
                        'todos los usuarios pueden acceder a la aplicación'
                    ];
                    $title = config('app.name') . ' - ' . __('En línea');
                    $description = __('Se ha reestablecido el acceso a la aplicación. Puede acceder en cualquier momento');
                    $users = User::all();
                    foreach ($users as $user) {
                        $user->notify(new AppNotification($title, '', $description, true));
                    }
                } else {
                    $secretHash = generate_hash(36, false, true);
                    \Artisan::call('down', ['--secret' => $secretHash]);
                    $msgType = [
                        'type' => 'other',
                        'text' => 'El sistema esta actualmente en mantenimiento, ' .
                        'solo puede acceder a la aplicación desde el enlace proporcionado'
                    ];
                    $roleAdmin = Role::where('slug', 'admin')->first();
                    if ($roleAdmin && !$roleAdmin->users->isEmpty()) {
                        $title = config('app.name') . ' - ' . __('Configuración en modo mantenimiento');
                        $description = __('Se ha configurado la aplicación en modo mantenimiento. Para poder acceder bajo esta modalidad es necesario que acceda a la siguiente URL: ') . config('app.url') . '/' . $secretHash;
                        foreach ($roleAdmin->users as $user) {
                            $user->notify(new AppNotification($title, '', $description, true));
                        }
                    }
                }
            }
        }

        $request->session()->flash('message', $msgType);
        return redirect()->route('settings.index');
    }
}
