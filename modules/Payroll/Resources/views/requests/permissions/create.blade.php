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
            <payroll-permission-request-create
                route_list="{{ url('payroll/permission-requests') }}"
                :requestid="{!! (isset($payrollPermissionRequest)) ? $payrollPermissionRequest->id : 'null' !!}">
            </payroll-permission-request-create>
        </div>
    </div>
@stop
