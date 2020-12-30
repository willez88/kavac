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
                    <h6 class="card-title">Facturas</h6>
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
                    <h6 class="card-title">Facturas Pendientes</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-bill-pending-list
                        route_list="{{ url('sale/bills/vue-list') }}"
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
                    <h6 class="card-title">Facturas Aprobadas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-bill-approved-list
                        route_list="{{ url('sale/bills/vue-approved-list') }}"
                        route_update='sale/bills'>
                    </sale-bill-approved-list>
                </div>
            </div>
        </div>
    </div>
    @endrole
@stop