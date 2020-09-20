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
            <payroll-vacation-request-form
                :id="{!! (isset($payrollVacationRequest)) ? $payrollVacationRequest->id : "null" !!}"
                route_list='{{ url('payroll/vacation-requests') }}'>
            </payroll-vacation-request-form>
        </div>
    </div>
@stop
