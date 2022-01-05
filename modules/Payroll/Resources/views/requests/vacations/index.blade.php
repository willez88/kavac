@extends('payroll::layouts.master')

@section('maproute-icon')
    <i class="ion-ios-folder-outline"></i>
@stop

@section('maproute-icon-mini')
    <i class="ion-ios-folder-outline"></i>
@stop

@section('maproute-actual')
    Talento Humano
@stop

@section('maproute-title')
    Vacaciones
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Solicitudes de vacaciones</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('payroll.vacation-requests.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <payroll-vacation-request-list
                        route_list="{{ url('payroll/vacation-requests/vue-list') }}"
                        route_show="{{ url('payroll/vacation-requests/show/{id}') }}"
                        route_edit="{{ url('payroll/vacation-requests/edit/{id}') }}"
                        route_delete="{{ url('payroll/vacation-requests') }}">
                    </payroll-vacation-request-list>
                </div>
            </div>
        </div>
    </div>

    @role(['admin', 'payroll'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Solicitudes de vacaciones pendientes</h6>
                        <div class="card-btns">
                            @include('buttons.previous', ['route' => url()->previous()])
                            @include('buttons.minimize')
                        </div>
                    </div>
                    <div class="card-body">
                        <payroll-vacation-request-pending-list
                            route_list="{{ url('payroll/vacation-requests/vue-pending-list') }}"
                            route_update="{{ url('payroll/vacation-requests') }}">
                        </payroll-vacation-request-pending-list>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@stop
