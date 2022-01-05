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
            <payroll-registers-form
                :payroll_id="{!! (isset($payroll)) ? $payroll->id : 'null' !!}"
                route_list="{{ url('payroll/registers') }}">
            </payroll-registers-form>
        </div>
    </div>
@stop
