@extends('sale::layouts.master')

@section('maproute-icon')
	<i class="ion-money-check-alt"></i>
@stop
{{-- money-check-alt--}}
@section('maproute-icon-mini')
	<i class="ion-money-check-alt"></i>
@stop

@section('maproute-actual')
	Comercialización
@stop

@section('maproute-title')
	Pagos
@stop

@section('content')

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Pagos Registrados') }}
						@include('buttons.help')
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
					<div class="card-body">
						<div class="row">
							{{-- Link--}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
