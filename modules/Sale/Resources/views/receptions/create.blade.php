@extends('sale::layouts.master')

@section('maproute-icon')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-actual')
	Comercialización
@stop

@section('maproute-title')
	Reportes
@stop


@section('content')
<div class="row">
	<div class="col-12">
		<div class="card" id="cardSaleWarehouseReceptionForm">
			<div class="card-header">
				<h6 class="card-title text-uppercase">Nuevo Ingreso al Almacén
					@include('buttons.help', [
					    'helpId' => 'SaleWarehouseReceptionForm',
					    'helpSteps' => get_json_resource('ui-guides/movements/sale_reception_form.json', 'sale')
				    ])
				</h6>
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<sale-warehouse-reception-create
				route_list='{{ url('sale/receptions')}}'
				:receptionid ="{!! (isset($reception)) ? $reception->id : 'null' !!}">
			</sale-warehouse-reception-create>
		</div>
	</div>
</div>
@stop
