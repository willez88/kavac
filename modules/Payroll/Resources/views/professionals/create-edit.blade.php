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
	Datos Profesionales
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<payroll-professional :payroll_professional_id="{!! (isset($payrollProfessional)) ? $payrollProfessional->id : "null" !!}"
                route_list="{{ url('payroll/professionals') }}">
            </payroll-professional>
		</div>
	</div>
@stop
