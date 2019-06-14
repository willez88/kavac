@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Nómina
@stop

@section('maproute-title')
	Datos Profesionales
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Datos Profesionales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('payroll.professional-informations.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<payroll-professional-informations-list route_list="{{ url('payroll/professional-informations/show/vue-list') }}"
										  route_delete="{{ url('payroll/professional-informations') }}"
										  route_edit="{{ url('payroll/professional-informations/{id}/edit') }}"
										  route_show="{{ url('payroll/professional-informations/{id}') }}">
					</payroll-professional-informations-list>
				</div>
			</div>
		</div>
	</div>
@stop
