<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UploadImageRepository;
use App\Models\Institution;
use App\Models\Setting;

/**
 * @class InstitutionController
 * @brief Gestiona información de Instituciones
 * 
 * Controlador para gestionar Instituciones
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class InstitutionController extends Controller
{
    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     */
    public function __construct() {
        $this->data[0] = [
            'id' => '',
            'text' => 'Seleccione...'
        ];
    }
    
    /**
     * Muesta todos los registros de las Instituciones
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => Institution::all()], 200);
    }

    /**
     * Muestra el formulario para crear un nuevo registro de Institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Valida y registra una nueva Institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, UploadImageRepository $up)
    {
        $this->validate($request, [
            'onapre_code' => 'required|max:20',
            'rif' => 'required|max:10',
            'acronym' => 'required|max:100',
            'name' => 'required|max:100',
            'business_name' => 'required|max:100',
            'start_operations_date' => 'required|date',
            'legal_address' => 'required',
            'postal_code' => 'required|max:10',
            'institution_sector_id' => 'required',
            'institution_type_id' => 'required',
            'municipality_id' => 'required',
            'city_id' => 'required'
        ]);

        // AGREGAR VALIDACIÓN DE MULTIPLES INSTITUCIONES CUANDO SE DEFINEN COMO TRUE EN 
        // LA CONFIGURACION DE PARAMETROS

        /*$logo = $banner = null;
        if ($request->file('logo_id')) {
            if ($up->uploadImage($request->file('logo_id'), 'pictures')) {
                $logo = $up->getImageStored()->id;
            }
        }
        if ($request->file('banner_id')) {
            if ($up->uploadImage($request->file('banner_id'), 'pictures')) {
                $banner = $up->getImageStored()->id;
            }
        }*/
        $logo = (!empty($request->logo_id)) ? $request->logo_id : null;
        $banner = (!empty($request->banner_id)) ? $request->banner_id : null;

        $setting = Setting::where('active', true)->first();
        
        $data = [
            'onapre_code' => $request->onapre_code,
            'rif' => $request->rif,
            'acronym' => $request->acronym,
            'name' => $request->name,
            'business_name' => $request->business_name,
            'start_operations_date' => $request->start_operations_date,
            'legal_address' => $request->legal_address,
            'postal_code' => $request->postal_code,
            'institution_sector_id' => $request->institution_sector_id,
            'institution_type_id' => $request->institution_type_id,
            'municipality_id' => $request->municipality_id,
            'city_id' => $request->city_id,
            'default' => ($request->default!==null),
            'active' => ($request->active!==null),
            'legal_base' => ($request->legal_base)?$request->legal_base:null,
            'legal_form' => ($request->legal_form)?$request->legal_form:null,
            'main_activity' => ($request->main_activity)?$request->main_activity:null,
            'mission' => ($request->mission)?$request->mission:null,
            'vision' => ($request->vision)?$request->vision:null,
            'web' => ($request->web)?$request->web:null,
            'composition_assets' => ($request->composition_assets)?$request->composition_assets:null,
            'retention_agent' => ($request->retention_agent!==null),
            'logo_id' => $logo,
            'banner_id' => $banner,
        ];

        if (is_null($setting->multi_institution) || !$setting->multi_institution) {
            /**
             * Crea o actualiza información de una institución si la aplicación esta configurada para el 
             * uso de una sola institución
             */
            $data['default'] = true;
            Institution::updateOrCreate(['rif' => $request->rif], $data);
        }
        else {
            if (!empty($request->institution_id)) {
                /**
                 * Si existe el identificador de la institución, se actualizan sus datos
                 */
                $inst = Institution::find($request->institution_id);
                $inst->fill($data);
                $inst->save();
            }
            else {
                /**
                 * Si no existe un identificador de institución, se crea una nueva
                 */
                Institution::create($data);
            }
        }

        session()->flash('message', ['type' => 'store']);
        return redirect()->route('settings.index');
    }

    /**
     * Muestra información acerca de la Institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function show(Institution $institution)
    {
        //
    }

    /**
     * Muestra el formulario para actualizar información de una Institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function edit(Institution $institution)
    {
        //
    }

    /**
     * Actualiza la información de la Institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Institution $institution)
    {
        //
    }

    /**
     * Elimina la Institución seleccionada
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  \App\Models\Institution  $institution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Institution $institution)
    {
        //
    }

    /**
     * Obtiene un listado de instituciones con id y nombre
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInstitutions()
    {
        foreach (Institution::all() as $institution) {
            $this->data[] = [
                'id' => $institution->id,
                'text' => $institution->name
            ];
        }

        return response()->json($this->data);
    }

    /**
     * Obtiene los datos de una institución
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  Institution $institution Objeto con información asociada a una institución
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDetails(Institution $institution)
    {
        $inst = Institution::where('id', $institution->id)->with(['municipality' => function($q) {
            return $q->with(['estate' => function($qq) {
                return $qq->with('country');
            }]);
        }, 'banner', 'logo'])->first();

        return response()->json(['result' => true, 'institution' => $inst], 200);
    }
}
