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
        $item = 0;
        $records = [
            "count" => 0,
            "signs" => [],
        ];
        $infoVerify = array();

        # Cuenta el número de firmas del archivo
        for($i = 0; $i < count($respverify); $i++) {
            if(substr_count($respverify[$i], 'Signature #') !== 0) {
                $count++;
            }
        }

        # Número de firmas
        $records["count"] = $count;

        # Recorte de los datos de la cadena
        # $signsInfo: array, informacion de la verificación de firma
        # $count: posición dentro del array
        # $item: bloque de información de la firma n 
        # $data: nombre del dato a buscar
        # $str_l: retorna la información del nombre de dato que busco

        function findData($signsInfo, $count, $item, $data) {
            $str_l = '';
            if(count($signsInfo) > ($count + $item))  {
                if(strpos($signsInfo[$count + $item], $data)) {
                    $post = strrpos($signsInfo[ $count + $item ], ': ') + 2;
                    $str_l = substr($signsInfo[ $count + $item ], $post);
                }
            }
            return $str_l;
        }

        for($j = 1; $j <= $count; $j++) {

            # Número de la firma
            $records["signs"][$j]["Firma"] = $j;

            # Nombre del firmante
            $str = findData($respverify, 2, $item, 'Signer Certificate Common Name');
            $records["signs"][$j]["Nombre del firmante"] = $str;

            # Sujeto firmante
            $str = findData($respverify, 3, $item, 'Signer full Distinguished Name');
            $records["signs"][$j]["Sujeto firmante"] = $str;

            # Fecha de la firma
            $str = findData($respverify, 4, $item, 'Signing Time');
            $records["signs"][$j]["Fecha de la firma"] = $str;

            # Algoritmo hash (reseña)
            $str = findData($respverify, 5, $item, 'Signing Hash Algorithm');
            $records["signs"][$j]["Algoritmo hash (reseña)"] = $str;

            # Tipo de firma
            $str = findData($respverify, 6, $item, 'Signature Type');
            $records["signs"][$j]["Tipo de firma"] = $str;

            # Validación de la firma
            $str = findData($respverify, 9, $item, 'Signature Validation');
            $records["signs"][$j]["Validación de la firma"] = $str;

            # Validación del certificado
            $str = findData($respverify, 10, $item, 'Certificate Validation');
            $records["signs"][$j]["Validación del certificado"] = $str;

            $item = $item + 10;
        }

        # $records["signs"] = $infoVerify;

        return ($records);
    }
}
