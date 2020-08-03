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

            return view('digitalsignature::index', ['Identidad' => $cert['subject']['CN'], 'Verificado' => $cert['issuer']['CN'], 'Caduca' => $cert['validFrom_time_t'], 'cert' => 'true']);
        }
        else {
            return view('digitalsignature::index',['informacion' => 'No posee una certificado firmante', 'cert' => 'false']);}
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
        $path = $request->file('pkcs12')->storeAs('documents', $filename);
        $url = 'storage/app/documents/'.$filename;

        $certStore = file_get_contents('/home/pbuitrago/Cenditel/Proyecto_kavac/kavac_cenditel/' . $url);
        //$passphrase = Str::random(8);
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
        Storage::disk('documents')->delete($filename);
    
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
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
