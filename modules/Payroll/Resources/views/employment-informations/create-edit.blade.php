@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Nómina
@stop

@section('maproute-title')
	Datos Laborales
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<payroll-employment-information :payroll_employment_information_id="{!! (isset($payroll_employment_information)) ? $payroll_employment_information->id : "null" !!}"
                route_list='{{ url('payroll/employment-informations') }}'>
            </payroll-employment-information>
		</div>
	</div>
@stop
