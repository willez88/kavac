@extends('layouts.app')

@section('maproute-icon')
    <i class="now-ui-icons ui-1_bell-53"></i>
@stop

@section('maproute-icon-mini')
    <i class="now-ui-icons ui-1_bell-53"></i>
@stop

@section('maproute-actual')
    {{ __('Notificaciones') }}
@stop

@section('maproute-title')
    {{ __('Notificaciones') }}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">{{ __('Listado de notificaciones') }}</h6>
            <div class="card-btns">
                @include('buttons.minimize')
            </div>
        </div>
        <all-notifications></all-notifications>
    </div>
@stop
