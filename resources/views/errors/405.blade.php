@extends('layouts.app')

@section('custom-page')
    <div class="notfoundpanel">
        <h1>405!</h1>
        <h3>{{ __('¡Método no permitido!') }}</h3>
        <p>
            {{ __('El método que estas usando para acceder no esta permitido.') }}
        </p>
        <button type="button" class="btn btn-sm bt-primary" onclick="window.history.back();">{{ __('Regresar') }}</button>
    </div>
@stop
