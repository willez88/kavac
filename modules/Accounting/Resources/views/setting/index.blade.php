@extends('layouts.app')

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
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-6">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Origenes para Asientos Contables</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-setting-category :categories="{{$categories}}" />
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Tasas de cambio de monedas</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-setting-currency-exchange-rate :currency_default="{{ $currency_default }}" />
				</div>
			</div>
		</div>
	</div>
@stop