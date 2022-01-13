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

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <p>Corrige los siguientes errores:</p>
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <h6 class="card-title"> Acciones Comúnes </h6>
            <div class="card-btns">
                <a href="javascript:void(0)" data-toggle="tooltip" class="card-minimize btn btn-card-action btn-round"
                   data-original-title="Minimize Panel">
                    <i class="now-ui-icons arrows-1_minimal-up"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xs-2 text-center">
                    <h6><i class="icofont icofont-file-pdf"></i> Firmar documentos PDF...!!!! </h6>
                </div>
                <digitalsignature-signfile-component
                    route_list="{{ url('digitalsignature/apiSignFile') }}" >
                </digitalsignature-signfile-component>
            </div>
        </div>
    </div>
</div>

@stop
