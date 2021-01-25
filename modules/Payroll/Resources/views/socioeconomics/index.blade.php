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
						@include('buttons.new', ['route' => route('payroll.socioeconomics.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<payroll-socioeconomic-list route_list="{{ url('payroll/socioeconomics/show/vue-list') }}"
						route_delete="{{ url('payroll/socioeconomics') }}"
						route_edit="{{ url('payroll/socioeconomics/{id}/edit') }}"
						route_show="{{ url('payroll/socioeconomics/{id}') }}">
					</payroll-socioeconomic-lit>
				</div>
			</div>
		</div>
	</div>
@stop
