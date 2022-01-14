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
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Facturas emitidas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('sale.bills.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-bill-list
                        route_list="{{ url('sale/bills/vue-list') }}"
                        route_edit="{{ url('sale/bills/edit/{id}') }}"
                        route_delete="{{ url('sale/bills/delete') }}">
                    </sale-bill-list>
                </div>
            </div>
        </div>
    </div>
    @role(['admin','sale'])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Facturas pendientes</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-bill-pending-list
                        route_list="sale/bills/vue-list"
                        route_update='sale/bills'>
                    </sale-bill-pending-list>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Solicitudes de facturas rechazadas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-bill-rejected-list
                        route_list="sale/bills/vue-rejected-list"
                        route_update='sale/bills'>
                    </sale-bill-rejected-list>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Facturas aprobadas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-bill-approved-list
                        route_list="sale/bills/vue-approved-list"
                        route_update='sale/bills'>
                    </sale-bill-approved-list>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Facturas emitidas por pagos de anticipos</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <!--sale-bill-advance-payment-list
                        route_list="sale/bills/vue-list"
                        route_update='sale/bills'>
                    </sale-bill-advance-payment-list-->
                </div>
            </div>
        </div>
    </div>
     <sale-bill-accept-pending
        ref="BillAccept">
    </sale-bill-accept-pending>
    <sale-bill-rejected-pending
        ref="BillRejected">
    </sale-bill-rejected-pending>
    @endrole
    <sale-bill-info
        ref="BillInfo">
    </sale-bill-info>
@stop
