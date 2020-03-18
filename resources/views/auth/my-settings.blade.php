@extends('layouts.app')

@section('maproute-icon')
    <i class="ion-gear-a"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-gear-a"></i>
@stop

@section('maproute-actual')
    {{ __('Mi Configuración') }}
@stop

@section('maproute-title')
    {{ __('Mi Configuración') }}
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h6 class="card-title">{{ __('Notificaciones') }}</h6>
            <div class="card-btns">
                @include('buttons.previous', ['route' => url()->previous()])
                @include('buttons.minimize')
            </div>
            {!! Form::open($header_notify_settings) !!}
                <div class="card-body">
                    <div class="row">
                        @php
                            $section = 'GENERAL';
                        @endphp
                        @foreach ($notifySettings as $notifySetting)
                            @if ($section != $notifySetting->module)
                                <div class="col-12 mb-4">
                                    <h6 class="md-title text-center">{{ $section }}</h6>
                                </div>
                                @php
                                    $section = $notifySetting->module;
                                @endphp
                            @endif
                            <div class="col-2 mb-4" id="{{ $notifySetting->slug }}">
                                <div class="form-group">
                                    <label for="" class="control-label">{{ $notifySetting->name }}</label>
                                    <div class="col-12 bootstrap-switch-mini">
                                        {!! Form::checkbox($notifySetting->slug, true,
                                            null, [
                                            'id' => $notifySetting->slug, 'class' => 'form-control bootstrap-switch',
                                            'data-on-label' => __('SI'), 'data-off-label' => __('NO')
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer text-right">
                    <div class="row">
                        <div class="col-md-3 offset-md-9" id="settingParamButtons">
                            @include('layouts.form-buttons')
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@stop
