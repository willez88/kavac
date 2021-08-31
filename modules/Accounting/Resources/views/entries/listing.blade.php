@extends('accounting::layouts.master')

@section('maproute-icon')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
	Contabilidad
@stop

@section('maproute-title')
	Asientos contables
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Aprobar asientos contables</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => route('accounting.entries.index')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-entry-li 
					route_list = "{{ url('accounting/entries/Filter-Records') }}"
					route_edit = "{{ url('accounting/entries/{id}/edit') }}" 
					:entries = "{{ $entries }}"> </accounting-entry-li>
				</div>
			</div>
		</div>
	</div>
@stop
