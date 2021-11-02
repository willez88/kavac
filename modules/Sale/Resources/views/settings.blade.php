@extends('sale::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop


@section('maproute-actual')
	Comercialización
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')

	@include('sale::settings-code-formats')
	{{--@include('sale::general-configuration')--}}
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Registros Comunes') }}
						@include('buttons.help')
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
					<div class="card-body">
						<div class="row">
							{{-- Configuración de Almacén--}}
							<sale-warehouse-method></sale-warehouse-method>
							{{-- Configuración de Clientes--}}
							<register-clients></register-clients>
							{{-- Configuración de Formas de cobro--}}
							<!--  <sale-payment-method></sale-payment-method> -->
							{{-- Configuración de Productos--}}
							<sale-setting-product></sale-setting-product>
							{{-- Configuración de Tipos de productos--}}
							<sale-setting-product-type></sale-setting-product-type>
							{{-- Configuración de Clientes --}}
							<!--<register-formatcode></register-formatcode>-->
							{{-- Configuración de Descuento --}}
							<sale-discount></sale-discount>
	                        {{-- Solicitar cotización --}}
							<sale-quote></sale-quote>
							{{-- Configuración de Formas de pago--}}
							{{-- <sale-setting-deposit></sale-setting-deposit> --}}
							{{-- Configuración de Gestión de Pedidos--}}
							{{-- <sale-order-management-method></sale-order-management-method> --}}
							{{-- Configuración de Tipo de bien--}}
							<sale-type-good></sale-type-good>
							{{-- Configuración de Lista de subservicios--}}
							<sale-list-subservices-method></sale-list-subservices-method>
							{{-- Configuración de Costos Comunes--}}
							<sale-periodic-cost></sale-periodic-cost>
							{{-- Configuración de Método de Cobro--}}
							<sale-settings-charge-money></sale-settings-charge-money>
							{{-- Configuración de Formas de Cobro--}}
							<sale-settings-form-payment></sale-settings-form-payment>
							{{-- Configuración de Periodos de tiempo--}}
							<sale-frecuencies></sale-frecuencies>
							{{-- Configuración de Bienes a Comercialziar--}}
							<sale-goods-to-be-traded></sale-goods-to-be-traded>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
