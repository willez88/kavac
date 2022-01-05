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
	Datos Socioeconómicos
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<payroll-socioeconomic :payroll_socioeconomic_id="{!! (isset($payrollSocioeconomic)) ? $payrollSocioeconomic->id : "null" !!}"
                route_list="{{ url('payroll/socioeconomics') }}">
            </payroll-socioeconomic>
		</div>
	</div>
@stop
