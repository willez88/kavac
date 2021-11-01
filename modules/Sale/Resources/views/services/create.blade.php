@extends('sale::layouts.master')

@section('maproute-icon')
    <i class="ion-ios-list-outline"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-ios-list-outline"></i>
@stop

@section('maproute-actual')
    Comercialización
@stop

@section('maproute-title')
    Solicitud de servicios
@stop


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" id="cardSaleServiceForm">
            <div class="card-header">
                <h6 class="card-title text-uppercase">Nueva Solicitud de Servicio
                    @include('buttons.help', [
                        'helpId' => 'SaleserviceForm',
                    ])
                </h6>
                </h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    @include('buttons.minimize')
                </div>
            </div>
            <sale-service-create
                :serviceid ="{!! (isset($services)) ? $services->id : 'null' !!}">
            </sale-service-create>
        </div>
    </div>
</div>
@stop
