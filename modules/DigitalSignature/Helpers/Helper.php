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

    /**
     * Manejo de la cadena de caracteres de la verificación de la firma electrónica
     */
    
    function getRespVerify($respverify)
    {
        $count = 0;
        $iten = 0;
        $infoVerify = array();
        for($i = 0; $i < count($respverify); $i++) {
            if(substr_count($respverify[$i], 'Signature #') !== 0) {
                $count++;
            }
        } 
        
        array_push($infoVerify, "Número de firma(s): " . $count);
        for($j = 0; $j < $count; $j++) {
            $sing = $j+1;
            array_push($infoVerify, "## Firma: " . $sing ." ##");
            $post = strrpos($respverify[2+$iten], ': ') + 1;
            $str = substr($respverify[2+$iten], $post);
            array_push($infoVerify, "Nombre del firmante: " . $str);
            $post = strrpos($respverify[3+$iten], ': ') + 1;
            $str = substr($respverify[3+$iten], $post);
            array_push($infoVerify, "Sujeto firmante: " . $str);
            $post = strrpos($respverify[4+$iten], ': ') + 1;
            $str = substr($respverify[4+$iten], $post);
            array_push($infoVerify, "Fecha de la firma: " . $str);
            $post = strrpos($respverify[5+$iten], ': ') + 1;
            $str = substr($respverify[5+$iten], $post);
            array_push($infoVerify, "Algoritmo hash (reseña): " . $str);
            $post = strrpos($respverify[6+$iten], ': ') + 1;
            $str = substr($respverify[6+$iten], $post);
            array_push($infoVerify, "Tipo de firma: " . $str);
            $post = strrpos($respverify[9+$iten], ': ') + 1;
            $str = substr($respverify[9+$iten], $post);
            array_push($infoVerify, "Validación de la firma: " . $str);
            $post = strrpos($respverify[10+$iten], ': ') + 1;
            $str = substr($respverify[10+$iten], $post);
            array_push($infoVerify, "Validación del certificado: " . $str);
            $iten = $iten + 10;
        }

        return ($infoVerify);
    }
}
