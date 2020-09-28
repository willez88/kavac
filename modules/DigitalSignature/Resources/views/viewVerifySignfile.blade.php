@extends('digitalsignature::layouts.master')

@section('maproute-icon')
    <i class="icofont icofont-ui-password"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-ui-password"></i>
@stop

@section('maproute-actual')
    {{ __('Verificar fírma electrónica') }}
@stop

@section('maproute-title')
    {{ __('Verificar fírma electrónica') }}
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
                <a href="#" data-toggle="tooltip" class="card-minimize btn btn-card-action btn-round"
                   data-original-title="Minimize Panel">
                    <i class="now-ui-icons arrows-1_minimal-up"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-xs-2 text-center">
                    <h6><i class="icofont icofont-file-pdf"></i> Verificar firma de documento PDF </h6>
                    <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8" action="{{ route('verifysignfile') }}">
                        <input type="hidden" name="_token" accept=".pdf" value="{{ csrf_token() }}" />
                        <p>
                            <label for="pdf">Cargar PDF a verificar firma</label>
                            <input id="pdf" type="file" class="form-control" name="pdf" required />
                        </p>
                        <p class="text-right">
                            <button type="submit" class="btn btn-success btn-icon btn-round" data-toggle="tooltip"
                                    title="Verificar firmar documento PDF">
                                <i class="icofont icofont-fountain-pen"></i>
                            </button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($verifyFile == 'true')
                    <div class="row">
                        <p><span class="font-weight-bold"> {{ __('Detalle de la firma') }}</span>
                        </p>
                    </div>
                    <div class="row">
                        <p><span class="font-weight-bold"> {{ __('Número de la firma: ') }}</span> {{ $nunSign }}
                        </p>
                        <br>
                        <p> {{ $json_test }}
                        </p>  
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@stop