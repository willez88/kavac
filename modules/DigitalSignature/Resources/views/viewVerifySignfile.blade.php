@extends('digitalsignature::layouts.master')

@section('maproute-icon')
  <i class="icofont icofont-ui-password"></i>
@stop

@section('maproute-icon-mini')
  <i class="icofont icofont-ui-password"></i>
@stop

@section('maproute-actual')
  {{ __('Verificar firma electrónica') }}
@stop

@section('maproute-title')
  {{ __('Verificar firma electrónica') }}
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
        <h6 class="card-title"> Verificar firma electrónica </h6>
        <div class="card-btns">
          <a href="#" data-toggle="tooltip" class="card-minimize btn btn-card-action btn-round"
             data-original-title="Minimize Panel">
            <i class="now-ui-icons arrows-1_minimal-up"></i>
          </a>
        </div>
      </div>
      <div class="card-body">
        <h6><i class="icofont icofont-file-pdf"></i> Verificar firma de documento PDF </h6>
        <form method="POST" enctype="multipart/form-data" accept-charset="UTF-8" action="{{ route('verifysignfile') }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}" />
          <p>
            <label for="pdf">Cargar PDF a verificar firma</label>
            <input id="pdf" type="file" class="form-control" name="pdf" required accept=".pdf"/>
          </p>
          <p class="text-right">
            <button type="submit" class="btn btn-success btn-icon btn-round" data-toggle="tooltip"
                title="Verificar firmar documento PDF">
              <i class="icofont icofont-fountain-pen"></i>
            </button>
          </p>
        </form>
          @if($verifyFile == 'true')
            <h6> {{ __('Detalle de la firma') }}</h6>
              @foreach (json_decode($json_test, true) as $key => $value)
                <p>{{ $value }}</p>
              @endforeach
          @endif
      </div>
    </div>
  </div>

  {{-- Acciones comunes --}}
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

          <digitalsignature-signfile-component></digitalsignature-signfile-component>

          <div class="col-xs-2 text-center">
            <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="{{ route('digitalsignature.viewSignfile') }}"
               title="Firmar archivos usando el certificado cargado">
              <i class="icofont icofont-file-pdf ico-3x"></i>
              <span> Firmar PDF </span>
            </a>
          </div>
          <div class="col-xs-2 text-center">
            <a class="btn-simplex btn-simplex-md btn-simplex-primary" title="Verificar Firmar de documentos pdf">
              <i class="icofont icofont-file-pdf ico-3x"></i>
              <span> Verificar firma PDF </span>
            </a>
          </div>
          <div class="col-xs-2 text-center">
            <a class="btn-simplex btn-simplex-md btn-simplex-primary" href="{{ route('digitalsignature') }}"
               title="Verificar Firmar de documentos pdf">
              <i class="icofont icofont-certificate-alt-1 ico-3x"></i>
              <span> Gestionar certificado </span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>


@stop