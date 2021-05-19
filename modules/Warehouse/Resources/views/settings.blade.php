@extends('warehouse::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	{{ __('Almacén') }}
@stop

@section('maproute-title')
	{{ __('Configuración') }}
@stop

@section('content')
	@include('warehouse::settings-code-formats')
	@include('warehouse::settings-parameters')
	<div class="row">
		<div class="col-12">
			<div class="card" id="helpConfigParamsForm">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Configuración General de Almacén') }}
						@include('buttons.help', [
						    'helpId' => 'ConfigParamsForm',
						    'helpSteps' => get_json_resource('ui-guides/settings/config_parameters.json', 'warehouse')
				    	])
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Configuración de almacenes --}}
						<warehouses id="helpWarehouses"></warehouses>

						{{-- Configuración de insumos almacenables --}}
						<warehouse-products id="helpWarehouseProducts"></warehouse-products>

						{{-- Configuración de reglas de almacén --}}
						<warehouse-rules id="helpWarehouseRules"></warehouse-rules>

						{{-- Configuración de cierres de almacén --}}
						<warehouse-closes id="helpWarehouseCloses"></warehouse-closes>

					</div>
				</div>
			</div>
		</div>
	</div>

@stop
@section('extra-js')
	@parent
	<script>
		$(document).ready(function() {
			$('#multi_warehouse').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Gestionar multiples almacenes',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
		});
	</script>
@endsection
