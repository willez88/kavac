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
    Gestión de Almacenes
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card" id="cardSaleReportForm">
            <div class="card-header">
                <h6 class="card-title text-uppercase">Productos Registrados en Almacén
                    @include('buttons.help', [
                        'helpId' => 'SaleReportForm',
                        'helpSteps' => get_json_resource('ui-guides/reports/report_form.json', 'sale')
                    ])
                </h6>
                <div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
                    @include('buttons.minimize')
                </div>
            </div>
            <sale-report-products
                route_list="{{ url()->previous() }}">
            </sale-report-products>
        </div>
    </div>
</div>
@stop
