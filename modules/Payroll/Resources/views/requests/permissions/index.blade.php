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
    Permisos
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Solicitud de Permisos</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('payroll.permission-requests.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <payroll-permission-request-list
                        route_list="{{ url('payroll/permission-requests/vue-list') }}"
                        route_edit="{{ url('payroll/permission-requests/edit/{id}') }}"
                        route_delete="{{ url('payroll/permission-requests/delete') }}">
                    </payroll-permission-request-list>
                </div>
            </div>
        </div>
    </div>

    @role(['admin', 'payroll'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Solicitudes de permisos pendientes</h6>
                        <div class="card-btns">
                            @include('buttons.previous', ['route' => url()->previous()])
                            @include('buttons.minimize')
                        </div>
                    </div>
                    <div class="card-body">
                        <payroll-permission-request-pending-list
                            route_list="{{ url('payroll/permission-requests/vue-pending-list') }}"
                            route_update="{{ url('payroll/permission-requests') }}">
                        </payroll-permission-request-pending-list>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@stop
