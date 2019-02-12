@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Bienes
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Configuración General de Almacén</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Configuración de Almacenes --}}
						<warehouse></warehouse>

						{{-- Configuración de Productos Almacenables --}}
						<warehouse-product></warehouse-product>

						{{-- Configuración de Unidades Métricas de Productos --}}
						<warehouse-unit></warehouse-unit>

						{{-- Configuración de Reglas de Almacén --}}
						{{-- <warehouse-rule></warehouse-rule> --}}

						{{-- Configuración de Cierres de Almacén --}}
						<warehouse-close></warehouse-close>

					</div>
				</div>
			</div>
		</div>
	</div>

@stop