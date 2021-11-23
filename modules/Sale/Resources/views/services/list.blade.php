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
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Solicitud de servicios</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('sale.services.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-service-list
                        route_list="{{ url('sale/services/vue-list') }}"
                        route_edit="{{ url('sale/services/edit/{id}') }}"
                        route_delete="{{ url('sale/servicess/delete') }}">
                    </sale-service-list>
                </div>
            </div>
        </div>
    </div>
    @role(['admin','sale'])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Solicitudes Pendientes</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-service-pending-list
                        route_list="{{ url('sale/services/vue-pending-list/Pendiente') }}"
                        route_update='sale/services'>
                    </sale-service-pending-list>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Solicitudes Rechazadas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-service-rejected-list
                        route_list="{{ url('sale/services/vue-pending-list/Rechazado') }}"
                        route_update='sale/services'>
                    </sale-service-rejected-list-->
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Propuestas técnicas</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <sale-technical-proposal-list
                        route_list="{{ url('sale/services/vue-pending-list/Aprobado') }}"
                        route_update='sale/services'>
                    </sale-technical-proposal-list>
                </div>
            </div>
        </div>
    </div>
    <sale-service-info
        ref="ServiceInfo">
    </sale-service-info>
    @endrole
@stop