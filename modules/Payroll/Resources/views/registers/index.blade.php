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
    Nómina
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title">Registros de Nómina</h6>
                    <div class="card-btns">
                        @include('buttons.previous', ['route' => url()->previous()])
                        @include('buttons.new', ['route' => route('payroll.registers.create')])
                        @include('buttons.minimize')
                    </div>
                </div>
                <div class="card-body">
                    <payroll-registers-list
                        route_list="payroll/registers/vue-list"
                        route_show="payroll/registers/show/{id}"
                        route_edit="payroll/registers/edit/{id}"
                        route_delete="payroll/registers">
                    </payroll-registers-lit>
                </div>
            </div>
        </div>
    </div>
@stop
