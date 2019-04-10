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
			<warehouse-request
				route_list='{{ url('warehouse/request') }}'
				:requestid ="{!! (isset($warehouse_request)) ? $warehouse_request->id : 'null' !!}">
			</warehouse-request>
		</div>
	</div>

@stop