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
                <a class="btn btn-warning btn-xs btn-icon btn-action" href="#"> <i class="fa fa-edit"></i> </a>
                <a class="btn btn-danger btn-xs btn-icon btn-action" href="#"> <i class="fa fa-trash-o"></i> </a>
                <a class="btn btn-info btn-xs btn-icon btn-action" href="{{ route('certificateDetails') }}"
                   data-toggle="tooltip" title="Detalles del certificado">
                    <i class="fa fa-eye"></i>
                </a>
            </div>
            @endif


            <div class="d-none">

                <p> {{ getPathSign('pruebaPDF.pdf') }} </p>
                <p>
                    <span class="font-weight-bold"> Correo: </span>
                    <span class="text-gray-900"> {{ $user->email }} </span>
                </p>
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

@stop