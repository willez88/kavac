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
    Cotizaciones
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Cotizaciones</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('sale.quotes.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-quote-list
                        route_list="{{ url('sale/quotes/vue-list') }}"
                        route_edit="{{ url('sale/quotes/edit/{id}') }}"
                        route_show="{{ url('sale/quotes/info/{id}') }}"
                        route_delete="{{ url('sale/quotes/delete') }}">
                    </sale-quote-list>
                </div>
            </div>
        </div>
    </div>
    @role(['admin','sale'])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Cotizaciones Pendientes</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-quote-list
                        route_list="{{ url('sale/quotes/vue-state-list/0') }}"
                        route_edit="{{ url('sale/quotes/edit/{id}') }}"
                        route_show="{{ url('sale/quotes/info/{id}') }}"
                        route_delete="{{ url('sale/quotes/delete') }}">
                    </sale-quote-list>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Cotizaciones aprobadas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-quote-list
                        route_list="{{ url('sale/quotes/vue-state-list/1') }}"
                        route_edit="{{ url('sale/quotes/edit/{id}') }}"
                        route_show="{{ url('sale/quotes/info/{id}') }}"
                        route_delete="{{ url('sale/quotes/delete') }}">
                    </sale-quote-list>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Cotizaciones rechazadas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-quote-list
                        route_list="{{ url('sale/quotes/vue-state-list/2') }}"
                        route_show="{{ url('sale/quotes/info/{id}') }}"
                        route_edit="{{ url('sale/quotes/edit/{id}') }}"
                        route_delete="{{ url('sale/quotes/delete') }}">
                    </sale-quote-list>
                </div>
            </div>
        </div>
    </div>
    @endrole
@stop
