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
	Formulaciones
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						Formulaciones de Presupuesto
						@include('buttons.help')
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('budget.subspecific-formulations.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-formulation-list route_list='{{ url('budget/subspecific-formulations/vue-list') }}'
										  route_delete="{{ url('budget/subspecific-formulations') }}"
										  route_edit="{{ url('budget/subspecific-formulations/{id}/edit') }}"
										  route_show="{{ url('budget/subspecific-formulations/show/{id}') }}">
					</budget-formulation-list>
				</div>
			</div>
		</div>
	</div>
@stop
