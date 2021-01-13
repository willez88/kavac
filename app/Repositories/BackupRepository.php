<?php

/** Repositorios del sistema */
namespace App\Repositories;

use Artisan;
use Log;
use Storage;
use Session;
use Exception;
use ZipArchive;

/**
 * @class BackupRepository
 * @brief Gestiona las acciones a ejecutar en los respaldos del sistema
 *
 * Gestiona las acciones que se deben realizar en el respaldo de información
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class BackupRepository
{
    /**
     * Construct function
     *
     * @method  __construct
     */
    public function __construct()
    {
        //
    }

    /**
     * Gestiona la creación de respaldos de la base de datos
     *
     * @method  create
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return  boolean Devuelve verdadero al crear el respaldo
     */
    public function create()
    {
        try {
            /** start the backup process */
            Artisan::call('backup:run');
            /** @var string Información del resultado de la ejecución del comando */
            $output = Artisan::output();

            /** log the results */
            Log::info(
                "Backpack\BackupManager -- " .
                __('se ha generado un nuevo backup desde la interfaz administrativa') . ". \r\n" .
                $output
            );

            Session::flash('message', ['type' => 'other', 'text' => __('Nuevo backup generado')]);
        } catch (Exception $e) {
            Session::flash('message', ['type' => 'other', 'text' => $e->getMessage()]);
        }

        return true;
    }

    /**
     * Ejecuta la acción necesaria para restaurar los datos a partir de un respaldo
     *
     * @method     restore(string $filename, \Illuminate\Http\Request $request)
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      string           $filename    Nombre del archivo con el respaldo a ser restaurado
     * @param      object           $request     Objeto con información de la petición
     *
     * @return     boolean          Devuelve verdadero si se realizó la restauración de la base de datos,
     *                              de lo contrario devuelve falso
     */
    public function restore($filename, $request)
    {
        /** @var string Ruta en la que se realiza el respaldo de la base de datos */
        $path = Storage::disk(config('backup.backup.destination.disks')[0])->getAdapter()->getPathPrefix();
        /** @var ZipArchive Instancia a la clase */
        $zip = new ZipArchive;
        /** @var object Objeto con información del archivo a descomprimir */
        $res = $zip->open($path . config('app.name') . "/" . $filename);
        if ($res === true) {
            try {
                $request->session()->regenerate();
                /** @var string Nombre del archivo a descomprimir */
                $snapName = str_replace(".zip", "", $filename);
                $zip->renameName('db-dumps/postgresql-kavac.sql', $snapName . '.sql');
                $zip->extractTo($path);
                $zip->close();
                /** @var string Código de respuesta en la restauración de datos */
                $exitCode = Artisan::call('snapshot:load ' . $snapName);
                /** @var string Datos de respuesta en la ejecución del comando */
                $output = Artisan::output();
                /** log the results */
                Log::info(
                    "Backpack\BackupManager -- " .
                    'se ha generado una nueva restauración de la base de datos desde la interfaz administrativa' .
                    ". \r\n" .
                    $output
                );
                return (strpos($output, 'loaded') > 0);
            } catch (Exception $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * Muestra el listado de archivos de respaldo
     *
     * @method  getList
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  string $disk Nombre del disco del sistema de archivos
     * @param  string $dir  Nombre del directorio del sistema de archivos
     *
     * @return array        Devuelve un arreglo con el listado de archivos de respaldo en orden descendente
     */
    public function getList($disk, $dir)
    {
        /** @var object Objeto con información del disco a usar para obtener el listado de archivos disponibles */
        $storage_disk = Storage::disk($disk[0]);
        /** @var object Objeto con información de los archivos disponibles */
        $files = $storage_disk->files($dir);
        /** @var array Listado con información detallada de los archivos a restaurar */
        $backups = [];
        /** make an array of backup files, with their filesize and creation date */
        foreach ($files as $k => $f) {
            /** only take the zip files into account */
            if (substr($f, -4) == '.zip' && $storage_disk->exists($f)) {
                $backups[] = [
                    'file_path' => $f,
                    'file_name' => str_replace($dir . '/', '', $f),
                    'file_size' => $this->humanFileSize($storage_disk->size($f)),
                    'last_modified' => $storage_disk->lastModified($f),
                ];
            }
        }
        /** reverse the backups, so the newest one would be on top */
        return array_reverse($backups);
    }

    /**
     * Obtiene un archivo
     *
     * @method  getFile
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  string $disk      Disk name
     * @param  string $dir       Directory name
     * @param  string $file_name File name
     *
     * @return array             File data
     */
    public function getFile($disk, $dir, $file_name)
    {
        /** @var string Ruta del archivo */
        $file = $dir . '/' . $file_name;
        /** @var object Objeto con información del disco a usar para obtener el archivo */
        $storage_disk = Storage::disk($disk[0]);
        if ($storage_disk->exists($file)) {
            /** @var string Driver del disco a usar */
            $fs = Storage::disk($disk[0])->getDriver();
            /** @var string Contenido del archivo */
            $stream = $fs->readStream($file);
            return [true, 'stream' => $stream, 'fs' => $fs, 'file' => $file];
        }

        return [false];
    }

    /**
     * Elimina un archivo
     *
     * @method  delFile
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  string $disk      Disk name
     * @param  string $dir       Directory name
     * @param  string $file_name File name
     *
     * @return array             File data
     */
    public function delFile($disk, $dir, $file_name)
    {
        /** @var object Objeto con información del disco del sistema de archivos */
        $storage_disk = Storage::disk($disk[0]);
        if ($storage_disk->exists($dir . '/' . $file_name)) {
            $storage_disk->delete($dir . '/' . $file_name);
            Session::flash('message', ['type' => 'destroy']);
            return true;
        }

        return false;
    }

    /**
     * Show readeable human file size
     *
     * @method  humanFileSize
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  float   $size       File size to convert
     * @param  integer $precision  Precision for the file size
     *
     * @return string              Return readeable human file size
     */
    public function humanFileSize($size, $precision = 2)
    {
        /** @var array Listado de unidades de capacidad */
        $units = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        /** @var integer base de cálculo para determinar el tamaño en formato legible */
        $step = 1024;
        /** @var integer Contador */
        $i = 0;
        while (($size / $step) > 0.9) {
            /** @var float Tamaño del archivo */
            $size = $size / $step;
            $i++;
        }
        return round($size, $precision).$units[$i];
    }
}
