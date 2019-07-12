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
	Datos Socioeconómicos
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Datos Socioeconómicos</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('payroll.socioeconomic-informations.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<payroll-socioeconomic-informations-list route_list="{{ url('payroll/socioeconomic-informations/show/vue-list') }}"
						route_delete="{{ url('payroll/socioeconomic-informations') }}"
						route_edit="{{ url('payroll/socioeconomic-informations/{id}/edit') }}"
						route_show="{{ url('payroll/socioeconomic-informations/{id}') }}">
					</payroll-socioeconomic-informations-lit>
				</div>
			</div>
		</div>
	</div>
@stop
