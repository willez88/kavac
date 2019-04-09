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
						@include('buttons.new', ['route' => route('accounting.accounts.create')])
						{{-- <a href="{{ route('accounting.seating.approveSeats') }}" class="btn btn-sm btn-primary btn-custom" title="Asientos contables por aprobar" data-toggle="tooltip">
							<i class="fa fa-list"></i>
						</a> --}}
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<accounting-seat />
				</div>
			</div>
		</div>
	</div>
@stop