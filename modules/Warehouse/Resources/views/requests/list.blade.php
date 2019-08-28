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
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes por Departamento</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('warehouse.request.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<warehouse-request-list
						route_list="{{ url('warehouse/requests/vue-list') }}"
						route_edit="{{ url('warehouse/requests/edit/{id}') }}"
						route_delete="{{ url('warehouse/requests/delete') }}">
					</warehouse-request-list>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes por Usuario</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('warehouse.request.staff.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<warehouse-request-staff-list
						route_list="{{ url('warehouse/requests/staff/vue-list') }}"
						route_edit="{{ url('warehouse/requests/staff/edit/{id}') }}"
						route_delete="{{ url('warehouse/requests/delete') }}">
					</warehouse-request-staff-list>
				</div>
			</div>
		</div>
	</div>

	@role(['admin', 'warehouse'])
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h6 class="card-title">Solicitudes Pendientes</h6>
						<div class="card-btns">
							@include('buttons.previous', ['route' => url()->previous()])
							@include('buttons.minimize')
						</div>
					</div>
					<div class="card-body">
						<warehouse-request-pending-list
							route_list="{{ url('warehouse/requests/vue-pending-list') }}"
							route_update='warehouse/requests'>
						</warehouse-request-pending-list>
					</div>
				</div>
			</div>
		</div>
	@endrole
@stop
