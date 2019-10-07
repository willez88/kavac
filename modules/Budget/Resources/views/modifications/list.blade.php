@extends('budget::layouts.master')

@section('maproute-icon')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
	Presupuesto
@stop

@section('maproute-title')
	Modificaciones Presupuestarias
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						Listado de Créditos Adicionales
						@include('buttons.help')
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include(
							'buttons.new', [
								'route' => route('budget.modifications.create', ['type' => 'AC'])
							]
						)
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-mod-list route_list='{{ url('budget/modifications/vue-list/AC') }}'
									 route_delete="{{ url('budget/modifications') }}"
									 route_edit="{{ url('budget/modifications/AC/{id}/edit') }}"/>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Listado de Reducciones</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include(
							'buttons.new', [
								'route' => route('budget.modifications.create', ['type' => 'RE'])
							]
						)
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-mod-list route_list='{{ url('budget/modifications/vue-list/RE') }}'
									 route_delete="{{ url('budget/modifications') }}"
									 route_edit="{{ url('budget/modifications/RE/{id}/edit') }}"/>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Listado de Traspasos</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include(
							'buttons.new', [
								'route' => route('budget.modifications.create', ['type' => 'TR'])
							]
						)
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-mod-list route_list='{{ url('budget/modifications/vue-list/TR') }}'
									 route_delete="{{ url('budget/modifications') }}"
									 route_edit="{{ url('budget/modifications/TR/{id}/edit') }}"/>
				</div>
			</div>
		</div>
	</div>
@stop
