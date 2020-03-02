@extends('warehouse::layouts.master')

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
		<div class="card" id="cardWarehouseMovementForm">
			<div class="card-header">
				<h6 class="card-title text-uppercase">Nuevo Movimiento de Almacén
					@include('buttons.help', [
					    'helpId' => 'WarehouseMovementForm',
					    'helpSteps' => get_json_resource('ui-guides/movements/movement_form.json', 'warehouse')
				    ])
				</h6>
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<warehouse-movement-create
				route_list='{{ url('warehouse/movements')}}'
				:movementid ="{!! (isset($movement)) ? $movement->id : 'null' !!}">
			</warehouse-movement-create>
		</div>
	</div>
</div>
@stop
