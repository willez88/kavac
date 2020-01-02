@extends('layouts.app')

@section('custom-page')
    <div class="notfoundpanel">
        <h1>503!</h1>
        <h3>{{ __('¡El servicio no esta disponible!') }}</h3>
        <p>{{ __('Actualmente no es posible acceder a la aplicación debido a labores de mantenimiento.') }}</p>
        <button type="button" class="btn btn-sm bt-primary" onclick="window.history.back();">
            {{ __('Regresar') }}
        </button>
    </div>
@stop
