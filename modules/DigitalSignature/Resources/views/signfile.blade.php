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
                    <h6><i class="icofont icofont-file-pdf"></i> Firmar documentos PDF </h6>
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
            </div>
            <div class="card-body">
		        @if($signfile == 'true')
		        	<di class="row">
		        		<p><span class="font-weight-bold"> {{ $msg }}</span></p>
		        	</di>
		        	<div class="row">
		        		<p><span class="font-weight-bold"> {{ __('Descargar') }}</span> {{ $namefile }}  </p> 
		        		<a class="btn btn-info btn-xs btn-icon btn-action" href="{{ route('getFile', ['filename' => $namefile]) }}" title="Descargar documento firmado">
                    <i class="fa fa-eye"></i>
                </a>
		        	</div>
		        @endif
		    </div>
        </div>
    </div>
</div>

@stop