@extends('citizenservice::layouts.master')

@section('maproute-icon')
	<i class="icofont icofont-users-social"></i>
@stop

@section('maproute-icon-mini')
	<i class="icofont icofont-users-social"></i>
@stop

@section('maproute-actual')
	Atención/Ciudadano
@stop

@section('maproute-title')
	Reportes de Atención al Ciudadano
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card" id="cardCitizenServiceReportForm">
				<div class="card-header">
					<h6 class="card-title text-uppercase">Reportes
						@include('buttons.help', [
						    'helpId' => 'CitizenServiceReportForm',
						    'helpSteps' => get_json_resource('ui-guides/reports/report_form.json', 'citizenservice')
					    ])
					</h6>

					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<citizenservice-report-create route_list="{{ url('citizenservice/reports/vue-list')}}"></citizenservice-report-create>
				</div>
			</div>
		</div>
	</div>
@stop
