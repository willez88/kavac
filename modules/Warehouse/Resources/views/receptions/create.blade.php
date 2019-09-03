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
			<warehouse-reception-create
				route_list='{{ url('warehouse/receptions')}}'
				:receptionid ="{!! (isset($reception)) ? $reception->id : 'null' !!}">
				</warehouse-reception-create>
		</div>
	</div>

@stop
