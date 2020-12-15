@extends('accounting::layouts.master')

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">
					Operaciones en modulo de contabilidad
					@include('buttons.help', [
							'helpId' => 'AccountingEntryHistories',
							'helpSteps' => get_json_resource('ui-guides/dashboard/entry_histories.json', 'accounting')
						])
				</h6>
				<div class="card-btns">
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body" id="helpEntryHistories">
				<div class="row">
					<div class="col-12">
						<dashboard-accounting-info />
					</div>
				</div>
				<hr>
			</div>
		</div>
	</div>

	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">
					Reportes de contabilidad
					@include('buttons.help', [
							'helpId' => 'AccountingReportHistories',
							'helpSteps' => get_json_resource('ui-guides/dashboard/report_histories.json', 'accounting')
						])
				</h6>
				<div class="card-btns">
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body" id="helpReportHistories">
				<div class="row">
					<div class="col-12">
						<dashboard-accounting-report-histories />
					</div>
				</div>
				<hr>
			</div>
		</div>
	</div>
</div>
@endsection
