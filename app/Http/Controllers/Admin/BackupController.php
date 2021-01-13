<?php
/** Controladores de uso exclusivo para usuarios administradores */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BackupRepository;

/**
 * @class BackupController
 * @brief Gestiona información de respaldo
 *
 * Controlador para gestionar respaldos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class BackupController extends Controller
{
    /**
     * Muestra un listado de respaldos del sistema
     *
     * @method  index
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  BackupRepository $backup Objeto con los métodos a implementar para la gestión de respaldos
     *
     * @return View    Devuelve la vista con los datos a mostrar
     */
    public function index(BackupRepository $backup)
    {
        /** @var array Arreglo con el listado de respaldos */
        $backups = $backup->getList(
            config('backup.backup.destination.disks'),
            config('backup.backup.name')
        );
        return view("admin.backups")->with(compact('backups'));
    }


    /**
     * Crea un nuevo respaldo
     *
     * @method  create
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  BackupRepository $backup Objeto con los métodos a implementar para la gestión de respaldos
     *
     * @return RedirectResponse         Redirecciona a la página anterior después de realizar el respaldo
     */
    public function create(BackupRepository $backup)
    {
        $backup->create();

        return redirect()->back();
    }

    /**
     * Descarga un respaldo solicitado
     *
     * @method  download
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  string           $file_name      Nombre del archivo a descargar
     * @param  BackupRepository $backup         Objeto con los métodos para la gestión de respaldos
     * @return StreamedResponse                 Retorna el response para la descarga del archivo
     */
    public function download($file_name, BackupRepository $backup)
    {
        /** @var array Arreglo con información del archivo a descargar */
        $down = $backup->getFile(
            config('backup.backup.destination.disks'),
            config('backup.backup.name'),
            $file_name
        );

        if (!$down[0]) {
            abort(404, __('El archivo de respaldo no existe.'));
        }

        /** @var string Texto con el contenido del archivo */
        $stream = $down['stream'];
        /** @var string Texto con el nombre del driver a usar para el sistema de archivos */
        $fs = $down['fs'];
        /** @var string Ruta en donde se encuentra el archivo a descargar */
        $file = $down['file'];

        return \Response::stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            "Content-Type" => $fs->getMimetype($file),
            "Content-Length" => $fs->getSize($file),
            "Content-disposition" => "attachment; filename=\"" . basename($file) . "\"",
        ]);
    }

    /**
     * Elimina un archivo de respaldo
     *
     * @method  delete
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  string               $file_name      Nombre del archivo a eliminar
     * @param  BackupRepository     $backup         Objeto con los métodos para la gestión de respaldos
     *
     * @return RedirectResponse                     Muestra una página de error 404 si el archivo no pudo ser
     *                                              eliminado, si el procedimiento fue exitoso retorna al
     *                                              listado de respaldos
     */
    public function delete($file_name, BackupRepository $backup)
    {
        /** @var boolean Determina si el archivo fue eliminado o no */
        $removed = $backup->delFile(
            config('backup.backup.destination.disks'),
            config('backup.backup.name'),
            $file_name
        );

        if (!$removed) {
            abort(404, __('El archivo de respaldo no existe.'));
        }

        return redirect()->back();
    }

    /**
     * Método que ejecuta la acción para la restauración de la base de datos a partir de un respaldo
     *
     * @method     restore
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      BackupRepository    $backup     Repositorio de instrucciones para la ejecución de procesos de
     *                                             respaldo y restauración de la base de datos
     * @param      Request             $request    Objeto con información de la petición realizada
     *
     * @return     \Illuminate\Http\JsonResponse   JSON con información del resultado en la restauración de la
     *                                             base de datos
     */
    public function restore(Request $request, BackupRepository $backup)
    {
        /** @var string Ruta del archivo a restaurar */
        $filename = $request->filename;

        /** @var boolean Determina si el archivo fue restaurado o no */
        $restaured = $backup->restore($filename, $request);

        return response()->json(['result' => $restaured], 200);
    }
}
