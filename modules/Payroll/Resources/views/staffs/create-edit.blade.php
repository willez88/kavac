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
	Personal
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<payroll-staff :payroll_staff_id="{!! (isset($payrollStaff)) ? $payrollStaff->id : "null" !!}"
				route_list='payroll/staffs'>
			</payroll-staff>
		</div>
	</div>
@stop
