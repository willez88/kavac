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
	Asientos contables
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">BUSCADOR DE ASIENTOS CONTABLES APROBADOS</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('accounting.entries.create')])
						<a href="{{ route('accounting.entries.unapproved') }}"
							class="btn btn-sm btn-primary btn-custom"
							title="Listado de asientos por aprobar"
							data-toggle="tooltip">
							NO APROBADOS <i class="fa fa-list"></i>
						</a>
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-entry :categories="{{ $categories }}" :currencies="{{ $currencies }}" :institutions="{{ $institutions }}" year_old="{{ $yearOld }}" route_edit="{{ url('accounting/entries/{id}/edit') }}" />
				</div>
			</div>
		</div>

		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Listado de asientos contables</h6>
					<div class="card-btns">
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-entry-listing />
				</div>
			</div>
		</div>
	</div>
@stop
