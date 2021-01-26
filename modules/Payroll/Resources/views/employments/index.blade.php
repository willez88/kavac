@extends('payroll::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Talento Humano
@stop

@section('maproute-title')
	Datos Laborales
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Datos Laborales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('payroll.employments.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<payroll-employment-list route_list="{{ url('payroll/employments/show/vue-list') }}"
										  route_delete="{{ url('payroll/employments') }}"
										  route_edit="{{ url('payroll/employments/{id}/edit') }}"
										  route_show="{{ url('payroll/employments/{id}') }}">
					</payroll-employment-list>
				</div>
			</div>
		</div>
	</div>
@stop
