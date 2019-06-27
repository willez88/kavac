@extends('layouts.app')

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
	Reportes
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					@if($type_report == 'balanceSheet')
						<h6 class="card-title">Balance General</h6>
					@elseif($type_report == 'stateOfResults')
						<h6 class="card-title">Estado de Resultados</h6>
					@endif
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-report-balance-sheet-state-of-results year_old="{{ $year_old }}" type_report="{{ $type_report }}" />
				</div>
			</div>
		</div>
	</div>
@stop
