@extends('citizenservice::layouts.master')

@section('maproute-icon')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-actual')
	Atención al Ciudadano
@stop

@section('maproute-title')
	Gestión de Atención al Ciudadano
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('citizenservice.request.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<citizenservice-request-list
						route_list="{{ url('citizenservice/requests/vue-list') }}"
						route_edit="{{ url('citizenservice/requests/edit/{id}') }}"
						route_delete="{{ url('citizenservice/requests/delete') }}">
					</citizenservice-request-list>
				</div>
			</div>
		</div>
	</div>

	@role(['admin','citizenservice'])
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitudes de Pendientes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<citizenservice-request-list-pending
							route_list='citizenservice/requests/vue-pending-list'
							route_update='citizenservice/requests'>
					</citizenservice-request-list-pending>
				</div>
			</div>
		</div>
	</div>

	{{--<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Cierre de Solicitudes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<citizenservice-request-list-pending
							route_list='citizenservice/requests/extensions/vue-pending-list'
							route_update='citizenservice/requests/extensions'>
					</citizenservice-request-list-pending>
				</div>
			</div>
		</div>
	</div>--}}


	@endrole
@stop
