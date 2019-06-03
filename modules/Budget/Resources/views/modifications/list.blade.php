@extends('layouts.app')

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
					<h6 class="card-title">Listado de Créditos Adicionales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('budget.aditional-credits.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-modification-list route_list='{{ url('budget/aditional-credits/vue-list') }}' 
											  route_delete="{{ url('budget/modifications') }}" 
											  route_edit="{{ url('budget/aditional-credits/{id}/edit') }}"/>
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
						@include('buttons.new', ['route' => route('budget.reductions.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-modification-list route_list='{{ url('budget/reductions/vue-list') }}' 
											  route_delete="{{ url('budget/modifications') }}" 
											  route_edit="{{ url('budget/reductions/{id}/edit') }}"/>
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
						@include('buttons.new', ['route' => route('budget.transfers.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-modification-list route_list='{{ url('budget/transfers/vue-list') }}' 
											  route_delete="{{ url('budget/modifications') }}" 
											  route_edit="{{ url('budget/transfers/{id}/edit') }}"/>
				</div>
			</div>
		</div>
	</div>
@stop