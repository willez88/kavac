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
    Facturas
@stop


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" id="cardSaleBillForm">
            <div class="card-header">
                <h6 class="card-title text-uppercase">Nueva Factura
                    @include('buttons.help', [
                        'helpId' => 'SaleBillForm',
                        'helpSteps' => get_json_resource('ui-guides/bills/sale_bill_form.json', 'sale')
                    ])
                </h6>
                </h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    @include('buttons.minimize')
                </div>
            </div>
            <sale-bill-create
                route_list='{{ url('sale/bills')}}'
                :billid ="{!! (isset($sale_bills)) ? $sale_bills->id : 'null' !!}">
            </sale-bill-create>
        </div>
    </div>
</div>
@stop
