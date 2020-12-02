@extends('purchase::layouts.master')

@section('maproute-icon')
    <i class="ion-social-dropbox-outline"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-social-dropbox-outline"></i>
@stop

@section('maproute-actual')
    Compra
@stop

@section('maproute-title')
    Requerimientos
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Gestión de presupuesto base</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => route('purchase.requirements.index')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    @if(!isset($tax))
                        <br>
                        <div class="alert alert-danger">
                            <div class="container">
                                <div class="alert-icon">
                                    <i class="now-ui-icons objects_support-17"></i>
                                </div>
                                <strong>Atención!</strong><br> Para el correcto funcionamiento del presupuesto base debe configurar previamente el IVA, para esto dirigirse a la configuración general del sistema y buscar el botón 
                                <a href="{{ route('settings.index') }}" style="color: black;"><strong>UNIDADES TRIBUTARIAS</strong></a>
                            </div>
                        </div>
                    @endif

                    @if(isset($baseBudget))
                        <purchase-base-budget-form :records="{{ $requirements }}"
                                                   :record_tax="{{ $tax }}"
                                                   :currencies="{{ $currencies }}"
                                                   :base_budget_edit="{{ $baseBudget }}" />
                    @else
                        <purchase-base-budget-form :records="{{ $requirements }}"
                                                   :record_tax="{{ $tax }}"
                                                   :currencies="{{ $currencies }}" />
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop
