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
			<div class="card" id="helpCheckupBalanceFrom">
				<div class="card-header">
					<h6 class="card-title">
						Balance de comprobación
						@include('buttons.help', [
							'helpId' => 'AccountingCheckup',
							'helpSteps' => get_json_resource('ui-guides/reports/finance_statements/checkup_balance.json', 'accounting')
						])
					</h6>
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
			<div class="card" id="helpStateOfResultsFrom">
				<div class="card-header">
					<h6 class="card-title">
						Estado de resultados
						@include('buttons.help', [
							'helpId' => 'AccountingState',
							'helpSteps' => get_json_resource('ui-guides/reports/finance_statements/state_of_results.json', 'accounting')
						])
					</h6>
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
			<div class="card" id="helpBalanceSheetFrom">
				<div class="card-header">
					<h6 class="card-title">
						Balance general
						@include('buttons.help', [
							'helpId' => 'AccountingBalance',
							'helpSteps' => get_json_resource('ui-guides/reports/finance_statements/balance_sheet.json', 'accounting')
						])
					</h6>
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
