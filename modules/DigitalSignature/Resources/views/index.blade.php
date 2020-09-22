@extends('digitalsignature::layouts.master')

@section('maproute-icon')
    <i class="icofont icofont-ui-password"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-ui-password"></i>
@stop

@section('maproute-actual')
    {{ __('Fírma electrónica') }}
@stop

@section('maproute-title')
    {{ __('Firma electrónica') }}
@stop

@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h6 class="card-title"> Gestión de Certificado
                <a href data-toggle="tooltip" data-original-title="Ayuda para la gestión del certificado">
                    <i class="ion ion-ios-help-outline cursor-pointer"></i>
                </a>
            </h6>
            <div class="card-btns">
                <a href="#" title="" data-toggle="tooltip" class="card-minimize btn btn-card-action btn-round"
                   data-original-title="Minimizar">
                    <i class="now-ui-icons arrows-1_minimal-up"></i>
                </a>
            </div>
        </div>
        <div class="card-body">

            @php
                $user = Auth::User();
            @endphp

            <h3 class="h4 border-bottom border-primary text-center pb-1 col-12 col-md-4"> Datos del certificado </h3>

            <p class="mb-1"> <span class="font-weight-bold"> Ha iniciado sesión como: </span> {{ $user->name }} </p>
            <p class="mb-1">
                <span class="font-weight-bold"> {{ __('Datos del certificado:') }} </span>
                @if($cert == 'true')
                    <ul class="fa-ul">
                        <li><span class="font-weight-bold"> {{ __('Identidad:') }} </span> {{ $Identidad }} </li>
                        <li><span class="font-weight-bold">  {{ __('Validado por:') }} </span> {{ $Verificado }} </li>
                        <li><span class="font-weight-bold">  {{ __('Caduca:') }} </span> {{ $Caduca }} </li>
                    </ul>
                @else
                    {{ __('No ha cargado un certificado') }}
                @endif
            </p>

            @if($cert == 'true')
            <div class="col-md-12">
                <a class="btn btn-warning btn-xs btn-icon btn-action" href="#" data-target="#modalUpdateCert"
                   data-toggle="modal" title="Actualizar certificado">
                   <i class="fa fa-edit"></i>
               </a>
                <div class="modal fade" id="modalUpdateCert" tabindex="-1" aria-labelledby="modalUpdateCertLabel"
                     aria-hidden="true">
                    <div class="modal-dialog vue-crud">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6> <i class="icofont icofont-upload-alt inline-block"></i> Actualizar certificado</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8"
                                      action="{{ route('updateCertificate') }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                    <p>
                                        <label for="pkcs12">Actualizar Certificado firmante</label>
                                        <input id="pkcs12" type="file" class="form-control" name="pkcs12"  required />
                                    </p>
                                    <p>
                                        <label for="phasepass">Contraseña del certificado</label>
                                        <input id="phasepass" class="form-control" type="password" name="password" required
                                               placeholder="XXXXXX" />
                                    </p>
                                    <p class="text-right">
                                        <button type="submit" class="btn btn-success btn-icon btn-round"
                                                data-original-title="Subir certificado">
                                            <i class="icofont icofont-upload-alt"></i>
                                        </button>
                                    </p>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                        data-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <a class="btn btn-danger btn-xs btn-icon btn-action" href="#" data-target="#modalConfirmDelete"
                   data-toggle="modal" title="Eliminar certificado">
                    <i class="fa fa-trash-o"></i>
                </a>
                <div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel"
                     aria-hidden="true">
                    <div class="modal-dialog vue-crud">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6><i class="fa fa-times inline-block"></i> Eliminar certificado</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p class="pb-3"> ¿Está seguro de querer eliminar el certificado? </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-modal-close"
                                        data-dismiss="modal">
                                    <i class="fa fa-times"></i> Cancelar
                                </button>
                                <a class="btn btn-primary" href="{{ route('deleteCertificate') }}">
                                    <i class="fa fa-check"></i> Confirmar
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a class="btn btn-info btn-xs btn-icon btn-action" href="#" onclick="certificateDetails()" data-target="#modalDetailCert"
                   data-toggle="modal" title="Detalles del certificado">
                    <i class="fa fa-eye"></i>
                </a>
                <div class="modal fade" id="modalDetailCert" tabindex="-1" aria-labelledby="modalDetailCertLabel"
                     aria-hidden="true">
                    <div class="modal-dialog vue-crud">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6><i class="fa fa-certificate"></i> Detalles del certificado</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-header">     
                            <p>
                                Nombre del asunto
                            </p>
                            </div>
                            <ul class="fa-ul">
                                <li id="idsubjC"></li>
                                <li id="idsubjST"></li>
                                <li id="idsubjL"></li>
                                <li id="idsubjO"></li>
                                <li id="idsubjOU"></li>
                                <li id="idsubjCN"></li>
                                <li id="idsubjEMAIL"></li>
                            </ul>
                            <di class="modal-header">
                                <p>
                                    Nombre del emisor
                                </p>
                            </di>
                            <ul class="fa-ul">
                                <li id="idissC"></li>
                                <li id="idissST"></li>
                                <li id="idissL"></li>
                                <li id="idissO"></li>
                                <li id="idissOU"></li>
                                <li id="idissCN"></li>
                                <li id="idissEMAIL"></li>
                            </ul>
                            <di class="modal-header">
                                <p>
                                    Certificado
                                </p>
                            </di>
                            <ul class="fa-ul">
                                <li id="idsignatureTypeLN"></li>
                                <li id="idsignatureTypeNID"></li>
                                <li id="idsignatureTypeSN"></li>
                                <li id="idserialNumber"></li>
                                <li id="idvalidFrom"></li>
                                <li id="idvalidTo"></li>
                                <li id="idversion"></li>
                            </ul>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                        data-dismiss="modal">
                                    Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h6 class="card-title"> Acciones Comúnes </h6>
            <div class="card-btns">
                <a href="#" data-toggle="tooltip" class="card-minimize btn btn-card-action btn-round"
                   data-original-title="Minimize Panel">
                    <i class="now-ui-icons arrows-1_minimal-up"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xs-2 text-center">
                    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="#" data-toggle="modal"
                       data-target="#modalSign" title="Firmar archivos usando el certificado cargado">
                        <i class="icofont icofont-file-pdf ico-3x"></i>
                        <span> Firmar PDF </span>
                    </a>
                    <div class="modal fade" id="modalSign" tabindex="-1" aria-labelledby="modalSignLabel"
                         aria-hidden="true">
                        <div class="modal-dialog vue-crud">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6><i class="icofont icofont-file-pdf"></i> Firmar documentos </h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8" action="{{ route('signFile') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <p>
                                            <label for="pdf">Cargar PDF a firmar</label>
                                            <input id="pdf" type="file" class="form-control" name="pdf" required />
                                        </p>
                                        <p class="text-right">
                                            <button type="submit" class="btn btn-success btn-icon btn-round" data-toggle="tooltip"
                                                    title="Firmar documento">
                                                <i class="icofont icofont-fountain-pen"></i>
                                            </button>
                                        </p>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                            data-dismiss="modal">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2 text-center">
                    <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="#" data-toggle="modal"
                       data-target="#modalVerify" title="Verificar Firmar de documentos pdf">
                        <i class="icofont icofont-file-pdf ico-3x"></i>
                        <span> Verificar firma PDF </span>
                    </a>
                    <div class="modal fade" id="modalVerify" tabindex="-1" aria-labelledby="modalVerifyLabel"
                         aria-hidden="true">
                        <div class="modal-dialog vue-crud">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6><i class="icofont icofont-file-pdf"></i> Verificar firma de documento PDF </h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8" action="{{ route('verifysign') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <p>
                                            <label for="pdf">Cargar PDF a verificar firma</label>
                                            <input id="pdf" type="file" class="form-control" name="pdf" required />
                                        </p>
                                        <p class="text-right">
                                            <button type="submit" class="btn btn-success btn-icon btn-round" data-toggle="tooltip"
                                                    title="Verificar firma de documento PDF">
                                                <i class="icofont icofont-fountain-pen"></i>
                                            </button>
                                        </p>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
                                            data-dismiss="modal">
                                        Cerrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2 text-center">
                    @if($cert == 'true')
                        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="#"
                           title="Formulario de carga del certificado" data-toggle="modal"
                           data-target="#modalUpdateCert">
                            <i class="icofont icofont-upload-alt ico-3x"></i>
                            <span class="pt-2"> Actualizar certificado </span>
                        </a>
                    @else
                        <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="#"
                           title="Formulario de carga del certificado" data-toggle="modal"
                           data-target="#modalUploadCert">
                            <i class="icofont icofont-upload-alt ico-3x"></i>
                            <span class="pt-2"> Cargar certificado </span>
                        </a>
                    @endif
                    <div class="modal fade" id="modalUploadCert" tabindex="-1" aria-labelledby="modalUploadCertLabel"
                         aria-hidden="true">
                        <div class="modal-dialog vue-crud">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6> <i class="icofont icofont-upload-alt inline-block"></i> Cargar certificado</h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body text-left">
                                    <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8"
                                          action="{{ route('signprofilestore') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                        <p>
                                            <label for="pkcs12">Cargar Certificado firmante</label>
                                            <input id="pkcs12" type="file" class="form-control" name="pkcs12"  required />
                                        </p>
                                        <p>
                                            <label for="phasepass">Contraseña del certificado</label>
                                            <input id="phasepass" class="form-control" type="password" name="password" required
                                                   placeholder="XXXXXX" />
                                        </p>
                                        <p class="text-right">
                                            <button type="submit" class="btn btn-success btn-icon btn-round"
                                                    data-original-title="Subir certificado">
                                                <i class="icofont icofont-upload-alt"></i>
                                            </button>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

<script>

    /* Función que enviar el documento del formuario para la firma electrónica
    */
   
   function signFilePdf() {
        console.log('signFile');
        let data = new FormData();
        data.append('file', document.getElementById('pdf').files[0]);
        axios.post('{{ route('signFile') }}', data).then(function (response) {
            console.log(response.data);
        });
   }

    /* Función que muestra el detalle del certificado firmante 
    */
   
    function certificateDetails() {
        
            axios.get('{{ route('certificateDetails') }}', {
            })
            .then(response => {
                $("#idsubjC").text( 'C(País): ' + response.data['certificateDetail']['subjCountry']);
                $("#idsubjST").text( 'ST(Estado): ' + response.data['certificateDetail']['subjState']);
                $("#idsubjL").text( 'L(Localidad): ' + response.data['certificateDetail']['subjLocality']);
                $("#idsubjO").text( 'O(Organización): ' + response.data['certificateDetail']['subjOrganization']);
                $("#idsubjOU").text( 'OU(Unidad de organización): ' + response.data['certificateDetail']['subjUnitOrganization']);
                $("#idsubjCN").text( 'CN(Nombre común): ' + response.data['certificateDetail']['subjName']);
                $("#idsubjEMAIL").text( 'EMAIL(Dirección de correo electrónico): ' + response.data['certificateDetail']['subjMail']);
                $("#idissC").text( 'C(País): ' + response.data['certificateDetail']['issCountry']);
                $("#idissST").text( 'ST(Estado): ' + response.data['certificateDetail']['issState']);
                $("#idissjL").text( 'L(Localidad): ' + response.data['certificateDetail']['issLocality']);
                $("#idissO").text( 'O(Organización): ' + response.data['certificateDetail']['issOrganization']);
                $("#idissOU").text( 'OU(Unidad de organización): ' + response.data['certificateDetail']['issUnitOrganization']);
                $("#idissCN").text( 'CN(Nombre común): ' + response.data['certificateDetail']['issName']);
                $("#idissEMAIL").text( 'EMAIL(Dirección de correo electrónico): ' + response.data['certificateDetail']['issMail']);
                $("#idsignatureTypeLN").text( 'Algoritmo de firma LN: ' + response.data['certificateDetail']['signatureTypeLN']);
                $("#idsignatureTypeNID").text( 'Algoritmo de firma NID: ' + response.data['certificateDetail']['signatureTypeNID']);
                $("#idsignatureTypeSN").text( 'Algoritmo de firma SN: ' + response.data['certificateDetail']['signatureTypeSN']);
                $("#idserialNumber").text( 'Serial: ' + response.data['certificateDetail']['serialNumber']);
                $("#idvalidTo").text( 'Valido desde: ' + response.data['certificateDetail']['validTo']);
                $("#idvalidFrom").text( 'Valido hasta: ' + response.data['certificateDetail']['validFrom']);
                $("#idversion").text( 'Version: ' + response.data['certificateDetail']['version']);
            });
    }
</script>