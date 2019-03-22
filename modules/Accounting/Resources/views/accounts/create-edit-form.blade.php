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
	Catálogo de Cuentas
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Cuentas Patrimoniales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				@if(empty($account))
					<accounting-create-edit-form :accounts="{{$accounting_accounts}}" />
				@else
					<accounting-create-edit-form :accounts="{{$accounting_accounts}}" 								 :account="{{$account}}" />
				@endif
			</div>
		</div>
	</div>
@stop
