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
			<budget-sub-specific-formulation :formulation-id="{!! (isset($formulation)) ? $formulation->id : "null" !!}"
											 route_list='{{ url('budget/subspecific-formulations') }}'></budget-sub-specific-formulation>
		</div>
	</div>
@stop
