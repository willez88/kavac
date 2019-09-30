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
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Formatos de Códigos</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							@if(!is_null($refCode))
								<accounting-setting-code :ref_code="{{ $refCode }}"
													route_list="{{ url('accounting.settings.index') }}" />
							@else
								<accounting-setting-code route_list="{{ url('accounting.settings.index') }}" />
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Configuraciones del módulo de contabilidad</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<accounting-setting-category></accounting-setting-category>
						<accounting-setting-account></accounting-setting-account>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
