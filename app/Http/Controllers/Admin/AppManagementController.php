<?php
/** Gestiona algunos procesos de acceso administrativo de la aplicación */
namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Traits\ModelsTrait;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

/**
 * @class AppManagementController
 * @brief Gestiona los procesos, registros, etc., de la aplicación, de uso exclusivo para el administrador
 *
 * Controlador para gestionar procesos y registros de la aplicación
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AppManagementController extends Controller
{
    use ModelsTrait;

    /**
     * Método constructor de la clase
     *
     * @method    __construct()
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Restringe el acceso solo a usuarios con el rol admin */
        $this->middleware('role:admin');
    }

    /**
     * Obtiene un listado de los últimos 20 registros eliminados
     *
     * @method    getDeletedRecords(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request              $request    Objeto con información de la petición
     *
     * @return    JsonResponse       Objeto Json con datos de respuesta a la petición
     */
    public function getDeletedRecords(Request $request)
    {
        /** @var array Arreglo con los registros eliminados */
        $trashed = [];
        
        if (Cache::has('deleted_records')) {
            $deletedRecords = Cache::get('deleted_records');
            if ($request->start_delete_at) {
                $deletedRecords = $deletedRecords->filter(function ($deleted) use ($request) {
                    return $deleted->deleted_at->format('Y-m-d') >= $request->start_delete_at;
                });
            }
            if ($request->end_delete_at) {
                $deletedRecords = $deletedRecords->filter(function ($deleted) use ($request) {
                    return $deleted->deleted_at->format('Y-m-d') <= $request->end_delete_at;
                });
            }
            if ($request->module_delete_at) {
                $deletedRecords = $deletedRecords->filter(function ($deleted) use ($request) {
                    return strpos(get_class($deleted), $request->module_delete_at)!==false;
                });
            }
            if (!$deletedRecords->isEmpty()) {
                
                $trashed = $this->setDeletedRecords($trashed, $deletedRecords);
                /** Si ya dispone de un listado de 20 registros, se detiene y se retorna la consulta */
                if ($deletedRecords->count() >= 20) {
                    return response()->json(['result' => true, 'records' => $trashed]);
                }
            }
        } else {
            foreach ($this->getModels() as $model_name) {
                //if (Cache::has($cacheKey)) {}
                /** @var string Nombre del modelo del cual se va a buscar registros eliminados */
                $model = app($model_name);
                
                try {
                    if ($this->isModelSoftDelete($model)) {
                        if ($request->start_delete_at) {
                            $model = $model->whereDate('deleted_at', '>=', $request->start_delete_at);
                        }
                        if ($request->end_delete_at) {
                            $model = $model->whereDate('deleted_at', '<=', $request->end_delete_at);
                        }
                        if ($request->module_delete_at && strpos($model_name, $request->module_delete_at) === false) {
                            continue;
                        }
                        /** @var object Objeto con información de registros eliminados */
                        $filtered = $model->onlyTrashed()->orderBy('deleted_at', 'desc');
                        /** @var object Objeto con información de los registros eliminados */
                        $deleted = $filtered->get();
                        if (!$deleted->isEmpty()) {
                            /** Si ya dispone de un listado de 20 registros, se detiene y se retorna la consulta */
                            if (count($trashed) >= 20) {
                                break;
                            }
                            
                            $trashed = $this->setDeletedRecords($trashed, $deleted, $model_name);
                        }
                    }
                } catch (Exception $e) {
                    continue;
                }
            }
        }        

        return response()->json(['result' => true, 'records' => $trashed]);
    }

    public function setDeletedRecords($trashed, $deleted, $model_name = null)
    {
        foreach ($deleted as $del) {
            /** @var string Texto con las etiquetas html que contiene los registros eliminados */
            $regs = '<div class="row">';
            foreach ($del->getAttributes() as $attr => $value) {
                if (!in_array($attr, ['created_at', 'updated_at', 'deleted_at'])) {
                    $regs .= "<div class='col-6 break-words'><b>$attr:</b> $value</div>";
                }
            }
            $regs .= '</div>';
            array_push($trashed, [
                'id' => secure_record($del->id),
                'deleted_at' => $del->deleted_at->format("d-m-Y"),
                'module' => $model_name ?? get_class($del),
                'registers' => $regs
            ]);
        }
        return $trashed;
    }

    /**
     * Restaura un archivo eliminado
     *
     * @method    restoreRecord(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request          $request    Objeto con datos de la petición
     *
     * @return    JsonResponse       Objeto Json con datos de respuesta a la petición
     */
    public function restoreRecord(Request $request)
    {
        $this->validate($request, [
            'module' => ['required'],
            'id' => ['required']
        ]);

        /** @var string Nombre del modelo del cual se van a restaurar los registros */
        $model = $request->module;
        /** @var string Hash con el identificador del registro a restaurar */
        $id = secure_record($request->id, true);
        $model::withTrashed()->find($id)->restore();

        return response()->json(['result' => true], 200);
    }

    /**
     * Obtiene un listado de registros a auditar
     *
     * @method    getAuditRecords(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request            $request    Objeto con información de la petición
     *
     * @return    JsonResponse       Objeto Json con datos de respuesta a la petición
     */
    public function getAuditRecords(Request $request)
    {
        /** @var Audit Instancia la clase para buscar datos de auditoria */
        $auditables = new Audit;

        if ($request->start_date) {
            $auditables = $auditables->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $auditables = $auditables->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->user) {
            /** @var User Objeto con información del usuario a consultar */
            $users = User::where('name', 'like', "{$request->user}%")
                        ->orWhere('name', 'like', "%{$request->user}%")
                        ->orWhere('name', 'like', "%{$request->user}")
                        ->orWhere('username', 'like', "{$request->user}%")
                        ->orWhere('username', 'like', "%{$request->user}%")
                        ->orWhere('username', 'like', "%{$request->user}")->get('id');

            if (!$users->isEmpty()) {
                $auditables = $auditables->whereIn('user_id', $users);
            } else {
                return response()->json(['result' => false, 'message' => __('El usuario no está registrado')], 200);
            }
        }
        if ($request->module) {
            $auditables = $auditables->where('auditable_type', 'like', "{$request->module}%")
                                     ->orWhere('auditable_type', 'like', "%{$request->module}%")
                                     ->orWhere('auditable_type', 'like', "%{$request->module}");
        }

        /** @var array Arreglo con registros a auditar según la acción ejecutada */
        $records = [];
        foreach ($auditables->orderBy('id', 'desc')->take(20)->get() as $audit) {
            if ($audit->user_id !== null) {
                switch ($audit->event) {
                    case 'created':
                        /** @var string texto con la clase text-success */
                        $registerClass = 'text-success';
                        break;
                    case 'deleted':
                        /** @var string texto con la clase text-danger */
                        $registerClass = 'text-danger';
                        break;
                    case 'restored':
                        /** @var string texto con la clase text-info */
                        $registerClass = 'text-info';
                        break;
                    case 'updated':
                        /** @var string texto con la clase text-warning */
                        $registerClass = 'text-warning';
                        break;
                    default:
                        /** @var string texto con la clase text-default */
                        $registerClass = 'text-default';
                        break;
                }

                /** @var string Texto con la clase badge a usar */
                $badgeClass = str_replace('text', 'badge', $registerClass);
                /** @var string Texto con el modelo de usuario a utilizar */
                $model_user = ($audit->user_type === "App\User") ? User::class : $audit->user_type;
                /** @var User Objeto con información del usuario */
                $user = $model_user::find($audit->user_id);

                /** @var string Nombre completo del usuario */
                $name = ($user) ? $user->name : '';
                /** @var string Nombre de usuario con el cual accede a la aplicación */
                $username = ($user) ? $user->username : '';

                array_push($records, [
                    'id' => secure_record($audit->id),
                    'status' => '<i class="ion-android-checkbox-blank ' . $registerClass . '"></i>',
                    'date' => $audit->created_at->format('d-m-Y h:i:s A'),
                    'ip' => $audit->ip_address,
                    'module' => $audit->auditable_type,
                    'users' => "<b>Nombre:</b> $name<br><b>Usuario:</b> $username"
                ]);
            }
        }
        return response()->json(['result' => true, 'records' => $records], 200);
    }

    /**
     * Obtiene detalles de un registro seleccionado
     *
     * @method    getAuditDetails(Request $request)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request            $request    Objeto con datos de la petición
     *
     * @return    JsonResponse       Objeto Json con detalles del registro
     */
    public function getAuditDetails(Request $request)
    {
        $this->validate($request, [
            'id' => ['required']
        ]);
        /** @var string Hash con el identificador del registro */
        $id = secure_record($request->id, true);
        /** @var Audit Objeto con información de auditoria */
        $audit = Audit::find($id);
        return response()->json(['result' => true, 'audit' => $audit], 200);
    }
}
