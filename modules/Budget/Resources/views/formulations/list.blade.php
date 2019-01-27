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
	Formulaciones
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Formulaciones de Presupuesto</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
						   <i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<a href="{{ route('budget.subspecific-formulations.create') }}" 
							   class="btn btn-sm btn-primary btn-custom float-right" 
							   title="Crear nuevo registro" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
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