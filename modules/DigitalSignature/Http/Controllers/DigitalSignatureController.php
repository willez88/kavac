<?php

namespace Modules\DigitalSignature\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Modules\DigitalSignature\Models\Signprofile;
use Modules\DigitalSignature\Models\User;


/**
 * @class DigitalSignatureController
 * @brief Controlador para la gestión de firma electrónica
 *
 * Clase que gestiona la firma electrónica
 *
 * @author Pedro Buitrago <pbuitrago@cenditel.gob.ve> | <pedrobui@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */

class DigitalSignatureController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        if(User::find(auth()->user()->id)->signprofiles) {
            $userprofile = User::find(auth()->user()->id)->signprofiles;
            $certuser = Crypt::decryptString($userprofile['cert']);
            $cert = openssl_x509_parse($certuser);
            $fecha = date('d-m-y H:i:s', $cert['validFrom_time_t']);

            return view('digitalsignature::index', ['Identidad' => $cert['subject']['CN'], 'Verificado' => $cert['issuer']['CN'], 'Caduca' => $fecha, 'cert' => 'true', 'certdetail' => 'false']);
        }
        else {
            return view('digitalsignature::index',['informacion' => 'No posee un certificado firmante', 'cert' => 'false', 'certdetail' => 'false']);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('digitalsignature::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        
        $filename = Str::random(10) . '.p12';
        $path = $request->file('pkcs12')->storeAs('',$filename, 'temporary');
        $certStore = file_get_contents(storage_path('temporary') . '/' . $filename);
        $passphrase = $request->get('password');
        if (!$certStore) {
            echo "Error: No se puede leer el fichero del certificado\n";
            exit;   
        }
        
        $pkcs12 = openssl_pkcs12_read($certStore, $certInfo, $passphrase );
        $cert = Crypt::encryptString($certInfo['cert']);
        $pkey = Crypt::encryptString($certInfo['pkey']);

       
        $profile = new Signprofile();
        $profile->cert = $cert; 
        $profile->pkey = $pkey;
        $profile->user_id = Auth::user()->id;
        $profile->save();
        Storage::disk('temporary')->delete($filename);
    
        return redirect()->route('digitalsignature');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('digitalsignature::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('digitalsignature::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        if(User::find(auth()->user()->id)->signprofiles) { 
            $userprofile = User::find(auth()->user()->id)->signprofiles;
            $userprofile->delete();
        }
        
        $filename = Str::random(10) . '.p12';
        $path = $request->file('pkcs12')->storeAs('',$filename, 'temporary');
        $certStore = file_get_contents(storage_path('temporary') . '/' . $filename);
        $passphrase = $request->get('password');
        if (!$certStore) {
            echo "Error: No se puede leer el fichero del certificado\n";
            exit;   
        }
        
        $pkcs12 = openssl_pkcs12_read($certStore, $certInfo, $passphrase );
        $cert = Crypt::encryptString($certInfo['cert']);
        $pkey = Crypt::encryptString($certInfo['pkey']);

       
        $profile = new Signprofile();
        $profile->cert = $cert; 
        $profile->pkey = $pkey;
        $profile->user_id = Auth::user()->id;
        $profile->save();
        Storage::disk('temporary')->delete($filename);
    
        return redirect()->route('digitalsignature');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    /**
     * Obtiene la información detallada del certificado del firmante
     *
     * @author Pedro Buitrago <pbuitrago@cenditel.gob.ve> | <pedrobui@gmail.com>
     * @return 
     */
    public function getCertificate() {

        if(User::find(auth()->user()->id)->signprofiles) {

            $userprofile = User::find(auth()->user()->id)->signprofiles;
            $certuser = Crypt::decryptString($userprofile['cert']);
            $cert = openssl_x509_parse($certuser);
            
            $certificateDetails = (object) [
            'subjCountry' => $cert['subject']['C'],
            'subjState' => $cert['subject']['ST'],
            'subjLocality' => $cert['subject']['L'],
            'subjOrganization' => $cert['subject']['O'],
            'subjUnitOrganization' => $cert['subject']['OU'],
            'subjName' => $cert['subject']['CN'],
            'subjMail' => $cert['subject']['emailAddress'],
            'issCountry' => $cert['issuer']['C'],
            'issState' => $cert['issuer']['ST'],
            'issLocality' => $cert['issuer']['L'],
            'issOrganization' => $cert['issuer']['O'],
            'issUnitOrganization' => $cert['issuer']['OU'],
            'issName' => $cert['issuer']['CN'],
            'issMail' => $cert['issuer']['emailAddress'],
            'version' => $cert['version'],
            'serialNumber' => $cert['serialNumber'],
            'validFrom' => $cert['validFrom'],
            'validTo' => $cert['validTo'],
            'signatureTypeSN' => $cert['signatureTypeSN'],
            'signatureTypeLN' => $cert['signatureTypeLN'],
            'signatureTypeNID' => $cert['signatureTypeNID'],
            ];
            print_r($certificateDetails);
            //return view('digitalsignature::index', ['certificateDetail' => $certificateDetails, 'cert' => 'true', 'certdetail' => 'true']);
        }
    }

    /**
     * Realiza la firma electrónica de un documento
     *
     * @author Pedro Buitrago <pbuitrago@cenditel.gob.ve> | <pedrobui@gmail.com>
     * @return 
     */
    public function signFile() 
    {
        
        if(Auth::user() && User::find(auth()->user()->id)->signprofiles) {

            //Crear archivo pkcs#12
            $cert = Crypt::decryptString(User::find(auth()->user()->id)->signprofiles['cert']);
            $pkey = Crypt::decryptString(User::find(auth()->user()->id)->signprofiles['pkey']);
            $passphrase = Str::random(10);
            
            //Datos para la firma
            $filename = Str::random(10) . '.p12';
            $storeCertificated = getPathSign($filename);
            $createpkcs12 = openssl_pkcs12_export_to_file($cert,$storeCertificated,$pkey,$passphrase);
            $pathPortableSigner = getPathSign('PortableSigner');
            
            //Documento pdf 
            $namepdf = 'pruebaPDF.pdf';
            $namepdfsign = 'pruebaPDF-sign.pdf';
            $storePdfSign = getPathSign($namepdfsign);
            $storePdf = getPathSign($namepdf);
            
            //ejecución del comando para firmar 
            $comand = 'java -jar ' . $pathPortableSigner . ' -n -t ' . $storePdf . ' -o ' . $storePdfSign . ' -s ' . $storeCertificated . ' -p ' . $passphrase;
            $run = exec($comand, $output);

            //elimina el certficado .p12
            Storage::disk('temporary')->delete($filename);
            
            print_r($output);
        }

        else { return redirect()->route('login'); } 
    }


    /**
     * Verifica la firma electrónica de un documento
     *
     * @author Pedro Buitrago <pbuitrago@cenditel.gob.ve> | <pedrobui@gmail.com>
     * @return 
     */
    public function verifysign() {

        //informacion para realizar la verificación de firma electrónica 
        $namepdfsign = 'pruebaPDF-sign.pdf';
        $storePdfSign = getPathSign($namepdfsign);
        
        //ejecución del comando para firmar
        $comand = 'pdfsig ' . $storePdfSign;

        $run = exec($comand, $output);
        $cont = 0;
        $size = count($output);
        print_r($output);

    }
}
    
