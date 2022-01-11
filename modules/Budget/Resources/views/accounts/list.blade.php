@extends('budget::layouts.master')

@section('maproute-icon')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
	{{ __('Presupuesto') }}
@stop

@section('maproute-title')
	{{ __('Catálogo de Cuentas') }}
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Catálogo de Cuentas Presupuestarias') }}
						@include('buttons.help')
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('budget.accounts.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<budget-accounts-list route_list="{{ url('budget/accounts/vue-list') }}"
										  route_delete="{{ url('budget/accounts') }}"
										  route_edit="{{ url('budget/accounts/{id}/edit') }}"/>
				</div>
			</div>
		</div>
	</div>
@stop
