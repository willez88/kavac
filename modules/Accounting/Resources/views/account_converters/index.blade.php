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
	Convertidor
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Convertidor de cuentas</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('accounting.converter.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-index :accounting_accounts="{{ $accountingList }}" :budget_accounts="{{ $budgetList }}"
					route_edit="{{ url('accounting/converter/{id}/edit') }}" />
				</div>
			</div>
		</div>
	</div>
@stop
