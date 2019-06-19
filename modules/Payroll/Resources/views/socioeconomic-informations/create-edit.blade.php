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
			<payroll-socioeconomic-information :socioeconomic_information_id="{!! (isset($socioeconomic_information)) ? $socioeconomic_information->id : "null" !!}"
                route_list='{{ url('payroll/socioeconomic-informations') }}'>
            </payroll-socioeconomic-information>
		</div>
	</div>
@stop
