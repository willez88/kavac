@extends('payroll::layouts.master')

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
	Datos Profesionales
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<payroll-professional-information :payroll_professional_information_id="{!! (isset($payrollProfessionalInformation)) ? $payrollProfessionalInformation->id : "null" !!}"
                route_list='{{ url('payroll/professional-informations') }}'>
            </payroll-professional-information>
		</div>
	</div>
@stop
