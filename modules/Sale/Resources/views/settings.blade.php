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

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Registros Comúnes</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Configuración de Almacén--}}
						<sale-warehouse-method></sale-warehouse-method>
						{{-- Configuración de Formas de cobro --}}
						<register-clients></register-clients>
						{{-- Configuración de Formas de cobro--}}
						<sale-payment-method></sale-payment-method>
<<<<<<< HEAD
						{{-- Configuración de Productos--}}
						<sale-setting-product></sale-setting-product>
						{{-- Configuración de Tipos de productos--}}
						<sale-setting-product-type></sale-setting-product-type>
=======
						{{-- Configuración de Clientes --}}
						<register-formatcode></register-formatcode>
>>>>>>> 5c732fcb8a1ef17b5d59d4fb66b06c060f1ba4ab
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
