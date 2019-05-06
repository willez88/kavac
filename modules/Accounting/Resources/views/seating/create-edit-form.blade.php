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
	Asientos contables
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Gestión de asientos contables</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					@if(!isset($seating))
						<accounting-seat-create :categories="{{ $categories }}" />
					@else
						<accounting-seat-create :categories="{{ $categories }}"
												category_edit="{{ $category }}"
												date_edit="{{ $date }}"
												reference_edit="{{ $reference }}"
												concept_edit="{{ $concept }}"
												observations_edit="{{ $observations }}"/>
					@endif
				</div>
			</div>
		</div>
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Asiento Contable</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					@if(!isset($seating))
					<accounting-seat-create-account :accounting_accounts="{{ $AccountingAccounts }}" />
					@else
						<accounting-seat-create-account :accounting_accounts="{{ $AccountingAccounts }}" :seating="{{ $seating }}" route_list="{{ url('accounting/seating/unapproved') }}"/>
					@endif
				</div>
			</div>
		</div>
	</div>
@stop