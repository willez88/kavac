@extends('citizenservice::layouts.master')

@section('maproute-icon')
	<i class="icofont icofont-users-social"></i>
@stop

@section('maproute-icon-mini')
	<i class="icofont icofont-users-social"></i>
@stop

@section('maproute-actual')
	Atención al Ciudadano
@stop

@section('maproute-title')
	Cronograma de Actividades
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Cronograma</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('citizenservice.register.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<citizenservice-register-list
					 route_list="citizenservice/registers/vue-list"
					 route_edit="citizenservice/registers/edit/{id}"
					 route_delete="citizenservice/registers/delete">
					</citizenservice-register-list>
				</div>
			</div>
		</div>
	</div>
@stop
