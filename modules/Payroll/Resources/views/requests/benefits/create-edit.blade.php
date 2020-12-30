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
            <payroll-benefits-request-form
                :id="{!! (isset($payrollBenefitsRequest)) ? $payrollBenefitsRequest->id : 'null' !!}"
                route_list="{{ url('payroll/benefits-requests') }}">
            </payroll-benefits-request-form>
        </div>
    </div>
@stop
