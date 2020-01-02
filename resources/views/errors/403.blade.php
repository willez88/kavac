@extends('layouts.app')

@section('custom-page')
    <div class="notfoundpanel">
        <h1>403!</h1>
        <h3>{{ __('¡Acceso denegado!') }}</h3>
        <p>{{ __('Se ha denegado el acceso de la petición solicitada.') }}</p>
        <button type="button" class="btn btn-sm bt-primary" onclick="window.history.back();">
            {{ __('Regresar') }}
        </button>
    </div>
@stop
