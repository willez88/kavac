<?php

namespace Modules\DigitalSignature\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
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
     * @return Renderable
     */
    public function index()
    {
        if (User::find(auth()->user()->id)->signprofiles) {
            $userprofile = User::find(auth()->user()->id)->signprofiles;
            $certuser = Crypt::decryptString($userprofile['cert']);
            $cert = openssl_x509_parse($certuser);
            $fecha = date('d-m-y H:i:s', $cert['validFrom_time_t']);

            return view('digitalsignature::index', ['Identidad' => $cert['subject']['CN'],
                                                    'Verificado' => $cert['issuer']['CN'],
                                                    'Caduca' => $fecha,
                                                    'cert' => 'true',
                                                    'certdetail' => 'false'
                                                   ]
            );
        } else {
            return view('digitalsignature::index',['informacion' => 'No posee un certificado firmante',
                                                   'cert' => 'false',
                                                   'certdetail' => 'false'
                                                  ]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('digitalsignature::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Renderable
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
     * @return Renderable
     */
    public function show()
    {
        return view('digitalsignature::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('digitalsignature::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Renderable
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
     * @return Renderable
     */
    public function destroy()
    {
        if(User::find(auth()->user()->id)->signprofiles) {
            $userprofile = User::find(auth()->user()->id)->signprofiles;
            $userprofile->delete();
            session()->flash(
                    'msg',
                    [
                        'autohide' => 'true',
                        'type'     => 'success',
                        'title'    => 'Éxito',
                        'text'     => 'Registro eliminado con éxito.'
                    ]
                );
            return redirect()->route('digitalsignature');
        }
        else {
            session()->flash(
                'msg',
                [
                    'autohide' => 'true',
                    'type'     => 'error',
                    'title'    => 'Alerta',
                    'text'     => 'El registro fue eliminado previamente.'
                ]
            );
            return redirect()->route('digitalsignature');
        }
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
            'validFrom' => date('d-m-y H:i:s', $cert['validFrom_time_t']),
            'validTo' => date('d-m-y H:i:s', $cert['validTo_time_t']),
            'signatureTypeSN' => $cert['signatureTypeSN'],
            'signatureTypeLN' => $cert['signatureTypeLN'],
            'signatureTypeNID' => $cert['signatureTypeNID'],
            ];
            $fecha = date('d-m-y H:i:s', $cert['validFrom_time_t']);
            //print_r($certificateDetails);
            return response()->json(['certificateDetail' => $certificateDetails, 
                                                    'cert' => 'true', 
                                                    'certdetail' => 'true', 
                                                    'Identidad' => $cert['subject']['CN'],
                                                    'Verificado' => $cert['issuer']['CN'],
                                                    'Caduca' => $fecha], 200);
        }
    }

    /**
     * Realiza la firma electrónica de un documento
     *
     * @author Pedro Buitrago <pbuitrago@cenditel.gob.ve> | <pedrobui@gmail.com>
     * @return
     */
    public function signFile(Request $request)
    {

        if(Auth::user() && User::find(auth()->user()->id)->signprofiles) {

            //Documento pdf
            $filename = Str::random(10);
            $filenamepdf = $filename . '.pdf';
            $path = $request->file('pdf')->storeAs('',$filenamepdf, 'temporary');
            $filenamepdfsign = $filename . '-sign.pdf';
            $storePdfSign = getPathSign($filenamepdfsign);
            $storePdf = getPathSign($filenamepdf);


            //Crear archivo pkcs#12
            $cert = Crypt::decryptString(User::find(auth()->user()->id)->signprofiles['cert']);
            $pkey = Crypt::decryptString(User::find(auth()->user()->id)->signprofiles['pkey']);
            $passphrase = Str::random(10);

            //Datos para la firma
            $filenamep12 = Str::random(10) . '.p12';
            $storeCertificated = getPathSign($filenamep12);
            $createpkcs12 = openssl_pkcs12_export_to_file($cert,$storeCertificated,$pkey,$passphrase);
            $pathPortableSigner = getPathSign('PortableSigner');

            //ejecución del comando para firmar
            $comand = 'java -jar ' . $pathPortableSigner . ' -n -t ' . $storePdf . ' -o ' . $storePdfSign . ' -s ' . $storeCertificated . ' -p ' . $passphrase;
            $run = exec($comand, $output);

            //enlace para descargar archivo 
            $pathDownload = asset('storage/temporary/'.$filenamepdfsign);
            $headers = array(
                 'Content-Type: application/pdf',
               );

            //print_r($pathDownload);

            //elimina el certficado .p12
            Storage::disk('temporary')->delete($filenamep12);

            //return Storage::download($pathDownload, $filenamepdfsign, $headers);
            print_r($output);
            //return redirect()->route('digitalsignature', ['path' => $pathDownload, 'msg' => 'Se firmo correctamente']);
        }

        else { return redirect()->route('login'); }
    }



    /**
     * Verifica la firma electrónica de un documento
     *
     * @author Pedro Buitrago <pbuitrago@cenditel.gob.ve> | <pedrobui@gmail.com>
     * @return
     */
    public function verifysign(Request $request) {

        //Documento pdf
        $filename = Str::random(10);
        $namepdfsign = $filename . '.pdf';
        $path = $request->file('pdf')->storeAs('',$namepdfsign, 'temporary');
        
        $storePdfSign = getPathSign($namepdfsign);

        //ejecución del comando para firmar
        $comand = 'pdfsig ' . $storePdfSign;

        $run = exec($comand, $output);
        $cont = 0;
        $size = count($output);
        print_r($output);

    }

    /**
     * Lista los usuarios que asociado certificado firmante
     *
     * @author Pedro Buitrago <pbuitrago@cenditel.gob.ve> | <pedrobui@gmail.com>
     * @return
     */
    public function listCertificate() {

        $users = User::all();
        $userlist = [];
        foreach ($users as $user) {
            $profile = User::find($user->id);
            if ($profile->signprofiles) {
                print_r('############');
                print_r($user->name);
                print_r('############');
                print_r($user->email);
                print_r('############');
                print_r(Crypt::decryptString($profile->signprofiles['cert']));
            }
        }
    }

     function getFile($filename){
        
        $file=Storage::disk('temporary')->get($filename);
        return (new Response($file, 200))
              ->header('Content-Type', 'application/pdf');
        /*$file=Storage::disk('temporary')->get($filename);
        return redirect()::away((new Response($file, 200))
              ->header('Content-Type', 'application/pdf')); */
    }
}

