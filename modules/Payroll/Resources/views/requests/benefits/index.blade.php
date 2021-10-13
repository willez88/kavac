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
    Adelanto de prestaciones
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Solicitudes de adelanto de prestaciones</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('payroll.benefits-requests.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <payroll-benefits-request-list
                        route_list="payroll/benefits-requests/vue-list"
                        route_show="payroll/benefits-requests/show/{id}"
                        route_edit="payroll/benefits-requests/edit/{id}"
                        route_delete="payroll/benefits-requests">
                    </payroll-benefits-request-list>
                </div>
            </div>
        </div>
    </div>

    @role(['admin', 'payroll'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title">Solicitudes de adelanto de prestaciones pendientes</h6>
                        <div class="card-btns">
                            @include('buttons.previous', ['route' => url()->previous()])
                            @include('buttons.minimize')
                        </div>
                    </div>
                    <div class="card-body">
                        <payroll-benefits-request-pending-list
                            route_list="payroll/benefits-requests/vue-pending-list"
                            route_update='payroll/benefits-requests'>
                        </payroll-benefits-request-pending-list>
                    </div>
                </div>
            </div>
        </div>
    @endrole
@stop
