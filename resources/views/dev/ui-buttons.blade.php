@extends('layouts.app')

@section('maproute-icon')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-icon-mini')
    <i class="icofont icofont-idea"></i>
@stop

@section('maproute-actual')
    {{ __('Botones') }}
@stop

@section('maproute-title')
    {{ __('Botones') }}
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">
                        {{ __('Botones') }}
                        @include('buttons.help', [
                            'helpId' => 'developmentButtons',
                            'helpSteps' => get_json_resource('ui-guides/dev_buttons.json')
                        ])
                    </h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => route('index')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body" id="helpButtons">
                    <h6 class="pad-top-10">{{ __('Estilos') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary" type="button">{{ __('Por defecto') }}</button>
                            <button class="btn btn-primary btn-round" type="button">{{ __('Redondeado') }}</button>
                            <button class="btn btn-primary btn-round" type="button">
                                <i class="now-ui-icons ui-2_favourite-28"></i> {{ __('Con Icono') }}
                            </button>
                            <button class="btn btn-primary btn-icon btn-round" type="button">
                                <i class="now-ui-icons ui-2_favourite-28"></i>
                            </button>
                            <button class="btn btn-primary btn-simple btn-round" type="button">{{ __('Simple') }}</button>
                        </div>
                    </div>
                    <h6 class="pad-top-10">{{ __('Tamaños') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm">{{ __('Pequeño') }}</button>
                            <button class="btn btn-primary">{{ __('Normal') }}</button>
                            <button class="btn btn-primary btn-lg">{{ __('Grande') }}</button>
                        </div>
                    </div>
                    <h6 class="pad-top-10">{{ __('Colores') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn">{{ __('Default') }}</button>
                            <button class="btn btn-primary">{{ __('Primary') }}</button>
                            <button class="btn btn-info">{{ __('Info') }}</button>
                            <button class="btn btn-success">{{ __('Success') }}</button>
                            <button class="btn btn-warning">{{ __('Warning') }}</button>
                            <button class="btn btn-danger">{{ __('Danger') }}</button>
                            <button class="btn btn-neutral">{{ __('Neutral') }}</button>
                        </div>
                    </div>
                    <h6 class="pad-top-10">{{ __('Enlaces') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-link">{{ __('Default') }}</button>
                            <button class="btn btn-link btn-primary ">{{ __('Primary') }}</button>
                            <button class="btn btn-link btn-info">{{ __('Info') }}</button>
                            <button class="btn btn-link btn-success">{{ __('Success') }}</button>
                            <button class="btn btn-link btn-warning">{{ __('Warning') }}</button>
                            <button class="btn btn-link btn-danger">{{ __('Danger') }}</button>
                        </div>
                    </div>
                    <h6 class="pad-top-10">{{ __('Acciones de formularios') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-default btn-icon btn-round">
                                <i class="fa fa-eraser"></i>
                            </button>
                            <button class="btn btn-warning btn-icon btn-round">
                                <i class="fa fa-ban"></i>
                            </button>
                            <button class="btn btn-success btn-icon btn-round">
                                <i class="fa fa-save"></i>
                            </button>
                        </div>
                    </div>
                    <h6 class="pad-top-10">{{ __('Acciones de Registros') }}</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-primary btn-custom btn-mini">
                                <i class="fa fa-reply"></i>
                            </button>
                            <button class="btn btn-sm btn-primary btn-custom btn-mini btn-new">
                                <i class="fa fa-plus-circle"></i>
                            </button>
                            <button class="btn btn-sm btn-primary btn-custom btn-mini btn-new">
                                <i class="fa fa-print"></i>
                            </button>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-warning btn-xs btn-icon btn-action">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-xs btn-icon btn-action">
                                <i class="fa fa-trash-o"></i>
                            </button>
                            <button class="btn btn-info btn-xs btn-icon btn-action">
                                <i class="fa fa-eye"></i>
                            </button>
                            <button class="btn btn-success btn-xs btn-icon btn-round">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-info btn-sm">
                                <i class="fa fa-search"></i>
                            </button>
                            <button class="btn btn-sm btn-info btn-import">
                                <i class="fa fa-upload"></i>
                            </button>
                            <button class="btn btn-sm btn-warning btn-import">
                                <i class="fa fa-download"></i>
                            </button>
                        </div>
                    </div>
                    <h6 class="pad-top-10">{{ __('Acciones en gráficos') }}</h6>
                    <div class="row" style="padding-bottom: 40px">
                        <div class="col-md-10 offset-2">
                            <div class="dropdown">
                                <a href="#" id="list_options_diagram" data-toggle="dropdown" aria-expanded="false"
                                   class="dropdown-toggle btn btn-sm btn-default btn-custom">
                                    <i aria-hidden="true" class="fa fa-bar-chart" style="color: white;"></i>
                                </a>
                                <div aria-labelledby="list_options_diagram" class="dropdown-menu dropdown-menu-right"
                                     x-placement="bottom-end" style="position: absolute; transform: translate3d(-122px, 30px, 0px); top: 0px; left: 0px; will-change: transform;">
                                    <div class="d-inline-flex">
                                        <a class="dropdown-item btn btn-sm btn-default">
                                            <i class="fa fa-bar-chart" style="color: white;"></i>
                                        </a>
                                        <a class="dropdown-item btn btn-sm btn-default">
                                            <i class="fa fa-refresh" style="color: white;"></i>
                                        </a>
                                        <a class="dropdown-item btn btn-sm btn-default">
                                            <i class="fa fa-pie-chart" style="color: white;"></i>
                                        </a>
                                        <a class="dropdown-item btn btn-sm btn-default">
                                            <i class="fa fa-line-chart" style="color: white;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
