@extends('payroll::layouts.master')

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
			<warehouse-movement-create
				route_list='{{ url('warehouse/movements')}}'
				:movementid ="{!! (isset($movement)) ? $movement->id : 'null' !!}">

				</warehouse-movement-create>
		</div>
	</div>


@stop
