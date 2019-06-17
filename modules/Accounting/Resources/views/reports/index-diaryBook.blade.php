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
	Reporte
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Libro Diario</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-report-diary-book />
				</div>
			</div>
		</div>
	</div>
@stop
