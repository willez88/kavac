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
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BackupRepository
{
    /**
     * Construct function
     */
    public function __construct()
    {
        //
    }

    /**
     * Gestiona la creación de respaldos de la base de datos
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
        $path = Storage::disk(config('backup.backup.destination.disks')[0])->getAdapter()->getPathPrefix();

        $zip = new ZipArchive;
        $res = $zip->open($path . config('app.name') . "/" . $filename);
        if ($res === true) {
            try {
                $request->session()->regenerate();
                $snapName = str_replace(".zip", "", $filename);
                $zip->renameName('db-dumps/postgresql-kavac.sql', $snapName . '.sql');
                $zip->extractTo($path);
                $zip->close();
                $exitCode = Artisan::call('snapshot:load ' . $snapName);
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
     * @param  string $disk Nombre del disco del sistema de archivos
     * @param  string $dir  Nombre del directorio del sistema de archivos
     * @return array        Devuelve un arreglo con el listado de archivos de respaldo en orden descendente
     */
    public function getList($disk, $dir)
    {
        $storage_disk = Storage::disk($disk[0]);
        $files = $storage_disk->files($dir);
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
     * Get the file
     * @param  string $disk      Disk name
     * @param  string $dir       Directory name
     * @param  string $file_name File name
     * @return array             File data
     */
    public function getFile($disk, $dir, $file_name)
    {
        $file = $dir . '/' . $file_name;
        $storage_disk = Storage::disk($disk[0]);
        if ($storage_disk->exists($file)) {
            $fs = Storage::disk($disk[0])->getDriver();
            $stream = $fs->readStream($file);
            return [true, 'stream' => $stream, 'fs' => $fs, 'file' => $file];
        }

        return [false];
    }

    public function delFile($disk, $dir, $file_name)
    {
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
     * @param  float   $size       File size to convert
     * @param  integer $precision  Precision for the file size
     * @return string              Return readeable human file size
     */
    public function humanFileSize($size, $precision = 2)
    {
        $units = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $step = 1024;
        $i = 0;
        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }
        return round($size, $precision).$units[$i];
    }
}
