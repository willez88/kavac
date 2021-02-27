@extends('payroll::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Talento Humano
@stop

@section('maproute-title')
	Datos Laborales
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<payroll-employment :payroll_employment_id="{!! (isset($payrollEmployment)) ? $payrollEmployment->id : "null" !!}">
            </payroll-employment>
		</div>
	</div>
@stop
