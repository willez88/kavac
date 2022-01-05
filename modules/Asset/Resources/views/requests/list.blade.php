@extends('asset::layouts.master')

@section('maproute-icon')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-actual')
	Bienes
@stop

@section('maproute-title')
	Gestión de Bienes
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes de Bienes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('asset.request.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<asset-request-list
						route_list="{{ url('asset/requests/vue-list') }}"
						route_edit="{{ url('asset/requests/edit/{id}') }}"
						route_delete="{{ url('asset/requests/delete') }}">
					</asset-request-list>
				</div>
			</div>
		</div>
	</div>

	@role(['admin','asset'])
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes de Bienes Pendientes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<asset-request-list-pending
							route_list="{{ url('asset/requests/vue-pending-list') }}"
							route_update="{{ url('asset/requests') }}">
					</asset-request-list-pending>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes de Prorrogas Pendientes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<asset-request-list-pending
							route_list="{{ url('asset/requests/extensions/vue-pending-list') }}"
							route_update="{{ url('asset/requests/extensions') }}">
					</asset-request-list-pending>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Entrega de Bienes Pendientes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<asset-request-delivery-list
							route_list="{{ url('asset/requests/deliveries') }}">
					</asset-request-delivery-list>
				</div>
			</div>
		</div>
	</div>
	@endrole
@stop
