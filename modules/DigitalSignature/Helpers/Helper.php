<?php

namespace Modules\DigitalSignature\Helpers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Module;
use Storage;

class Helper
{

    /**
     * Retorna la dirección completa del ejecutable del firma PortableSigner o del archivo a firmar o verificar
     */
    
    function getPathSign($nameFile)
    {
        $module = Module::find('DigitalSignature');

        //obtiene la dirección del PortableSigner
        if($nameFile == 'PortableSigner') {
            return($module->getPath() . '/PortableSigner/PortableSigner.jar');
        }
        //obtiene la dirección almacen del archivos pdf
        else {
            $path = Storage::disk('temporary')->path($nameFile);
            return($path);
        }
    }
}
