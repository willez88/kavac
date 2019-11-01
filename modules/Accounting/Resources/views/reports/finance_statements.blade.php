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
	Reportes de estados finacieros
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Balance de comprobación</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-report-checkup-balance year_old="{{ $yearOld }}" :currencies="{{ $currencies }}" />
				</div>
			</div>
		</div>

		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Estado de resultados</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-report-balance-sheet-state-of-results :currencies="{{ $currencies }}" year_old="{{ $yearOld }}" type_report="{{ $type_report_2 }}" />
				</div>
			</div>
		</div>

		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Balance general</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-report-balance-sheet-state-of-results :currencies="{{ $currencies }}" year_old="{{ $yearOld }}" type_report="{{ $type_report_1 }}" />
				</div>
			</div>
		</div>
	</div>
@stop
