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
	Personal
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<payroll-staff :payroll_staff_id="{!! (isset($payroll_staff)) ? $payroll_staff->id : "null" !!}"
				route_list='{{ url('payroll/staffs') }}'>
			</payroll-staff>
		</div>
	</div>
@stop
