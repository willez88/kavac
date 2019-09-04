@extends('accounting::layouts.master')

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
	Convertidor de Cuentas
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Convertidor de cuentas</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])

						@if($has_budget)
							@include('buttons.new', ['route' => route('accounting.converter.create')])
						@endif

						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					@if(!$has_budget)
						<br>
						<div class="alert alert-danger">
							<div class="container">
								<div class="alert-icon">
									<i class="now-ui-icons objects_support-17"></i>
								</div>
								<strong>Atención!</strong><br> La funcionalidad de conversión de cuentas presupuestales con patrimoniales
								esta inhabilitada, para habilitarla debe instalar ó activar el modulo de
								<a href="{{ route('module.list') }}" style="color: black;"><strong>Presupuesto</strong></a>
							</div>
						</div>
					@else
						<accounting-converter-index />
					@endif
				</div>
			</div>
		</div>

		@if($has_budget)
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Lista de conversiones</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
						<accounting-conversion-list route_edit="{{ url('accounting/converter/{id}/edit') }}" />
				</div>
			</div>
		</div>
		@endif
	</div>
@stop
