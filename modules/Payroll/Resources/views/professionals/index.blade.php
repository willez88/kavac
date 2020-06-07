@extends('payroll::layouts.master')

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
						@include('buttons.new', ['route' => route('payroll.professionals.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<payroll-professional-list route_list="{{ url('payroll/professionals/show/vue-list') }}"
										  route_delete="{{ url('payroll/professionals') }}"
										  route_edit="{{ url('payroll/professionals/{id}/edit') }}"
										  route_show="{{ url('payroll/professionals/{id}') }}">
					</payroll-professional-list>
				</div>
			</div>
		</div>
	</div>
@stop
