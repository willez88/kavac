<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\BackupRepository;

use Artisan;
use Log;
use Storage; //Eliminar
use Session;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function index(BackupRepository $backup)
    {
    	$backups = $backup->getList(
            config('backup.backup.destination.disks'), config('backup.backup.name')
        );
        return view("admin.backups")->with(compact('backups'));
    }


    public function create(BackupRepository $backup)
    {
        $backup->create();

        return redirect()->back();
    }

    /**
     * Downloads a backup zip file.
     *
     * TODO: make it work no matter the flysystem driver (S3 Bucket, etc).
     */
    public function download($file_name, BackupRepository $backup)
    {
        $down = $backup->getFile(
            config('backup.backup.destination.disks'), config('backup.backup.name'), $file_name
        );

        if (!$down[0]) {
            abort(404, "El archivo de respaldo no existe.");
        }

        $stream = $down['stream'];
        $fs = $down['fs'];
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
     * Deletes a backup file.
     */
    public function delete($file_name, BackupRepository $backup)
    {
        $removed = $backup->delFile(
            config('backup.backup.destination.disks'), config('backup.backup.name'), $file_name
        );

        if (!$removed) {
            abort(404, "El archivo de respaldo no existe.");
        }

        return redirect()->back();
    }

    
}
