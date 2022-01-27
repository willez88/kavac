@extends('sale::layouts.master')

@section('maproute-icon')
    <i class="ion-social-usd-outline"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-social-usd-outline"></i>
@stop

@section('maproute-actual')
    Comercialización
@stop

@section('maproute-title')
    Registrar pago
@stop


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" id="cardSaleServiceForm">
            <div class="card-header">
                <h6 class="card-title text-uppercase">Nuevo Registro de pago
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
            <payment-registered-create
                :paymentid ="{!! (isset($payment)) ? $payment->id : 'null' !!}">
            </payment-registered-create>
        </div>
    </div>
</div>
@stop
