@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-actual')
	Almacén
@stop

@section('maproute-title')
	Gestión de Almacenes
@stop


@section('content')
	<div class="row">
		<div class="col-12">
			@if(!isset($staff))
				<warehouse-request-create
					route_list='{{ url('warehouse/requests') }}'
					:requestid ="{!! (isset($warehouse_request)) ? $warehouse_request->id : 'null' !!}">
				</warehouse-request-create>
			@else
				<warehouse-request-staff-create
					route_list='{{ url('warehouse/requests') }}'
					:requestid ="{!! (isset($warehouse_request)) ? $warehouse_request->id : 'null' !!}">
				</warehouse-request-staff-create>
			@endif
		</div>
	</div>
@stop
