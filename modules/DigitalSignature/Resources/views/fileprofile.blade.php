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

        <div>
            <div class="row">
                <div>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('signprofilestore') }}"
                          accept-charset="UTF-8" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div>
                            <label>Cargar Certificado firmante</label>
                            <p>
                                <input type="file" class="form-control" name="pkcs12">
                            </p>
                            <p>
                            <input id="phasepass" class="form-control" type="password" name="password" required
                                   tabindex="3" placeholder="pkcs12 password" />
                            </p>
                        </div>
                        <div>
                            <div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>









        </div>
        <div class="card-footer text-right d-none">
            <button data-toggle="tooltip" type="button"
                    onclick="window.location.href=&quot;http://localhost:8000/citizenservice/settings&quot;"
                    class="btn btn-warning btn-icon btn-round" data-original-title="Cancelar y regresar">
                <i class="fa fa-ban"></i>
            </button>
            <button data-toggle="tooltip" id="save" type="submit" class="btn btn-success btn-icon btn-round"
                    data-original-title="Guardar registro">
                <i class="fa fa-save"></i>
            </button>
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
                    <a href="#" title="Registros de departamentos" data-toggle="tooltip"
                       class="btn-simplex btn-simplex-md btn-simplex-primary">
                        <i class="icofont icofont-file-pdf ico-3x"></i>
                        <span class="pt-2">Firmar PDF</span>
                    </a>
                </div>
                <div class="col-xs-2 text-center">
                    <a href="{{ route('fileprofile') }}" title="Cargar el certificado del usuario" data-toggle="tooltip"
                       class="btn-simplex btn-simplex-md btn-simplex-primary">
                        <i class="icofont icofont-upload-alt ico-3x"></i>
                        <span> Cargar certificado </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>










@stop
