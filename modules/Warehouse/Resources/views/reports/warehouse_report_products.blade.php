@extends('warehouse::layouts.master')

@section('maproute-icon')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-actual')
	Almacén
@stop

@section('maproute-title')
	Gestión de Almacenes
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card" id="cardWarehouseReportForm">
			<div class="card-header">
				<h6 class="card-title text-uppercase">Inventario de Productos Almacén
					@include('buttons.help', [
					    'helpId' => 'WarehouseReportForm',
					    'helpSteps' => get_json_resource('ui-guides/reports/report_form.json', 'warehouse')
				    ])
				</h6>
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<warehouse-reports
				route_list="{{ url()->previous() }}">
			</warehouse-reports>
		</div>
	</div>
</div>
@stop
