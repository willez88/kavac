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
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Movimientos de Almacén</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('warehouse.movement.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<warehouse-movement-list
						route_list="{{ url('warehouse/movements/vue-list') }}"
						route_edit="{{ url('warehouse/movements/edit/{id}') }}"
						route_delete="{{ url('warehouse/movements/delete') }}">
					</warehouse-movement-list>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Movimientos de Almacén Pendientes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<warehouse-movement-pending-list
						route_list="{{ url('warehouse/movements/vue-list') }}"
						route_update='warehouse/movements'>
					</warehouse-movement-pending-list>
				</div>
			</div>
		</div>
	</div>
@stop
