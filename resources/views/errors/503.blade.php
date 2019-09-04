@extends('layouts.app')

@section('custom-page')
    <div class="notfoundpanel">
        <h1>503!</h1>
        <h3>¡El servicio no esta disponible!</h3>
        <p>Actualmente no es pocible acceder a la aplicación debido a labores de mantenimiento.</p>
        <button type="button" class="btn btn-sm bt-primary" onclick="window.history.back();">Regresar</button>
    </div>
@stop
