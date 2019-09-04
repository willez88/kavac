@extends('warehouse::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Almacén
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	@include('warehouse::settings-code-formats')
	@include('warehouse::settings-parameters')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Configuración General de Almacén</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Configuración de Almacenes --}}
						<warehouses></warehouses>

						{{-- Configuración de Productos Almacenables --}}
						<warehouse-products></warehouse-products>

						{{-- Configuración de Reglas de Almacén --}}
						<warehouse-rules></warehouse-rules>

						{{-- Configuración de Cierres de Almacén --}}
						<warehouse-closes></warehouse-closes>

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
