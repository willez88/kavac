@extends('citizenservice::layouts.master')

@section('maproute-icon')
	<i class="icofont icofont-users-social"></i>
@stop

@section('maproute-icon-mini')
	<i class="icofont icofont-users-social"></i>
@stop

@section('maproute-actual')
	Atención/Ciudadano
@stop

@section('maproute-title')
	Reportes de Atención al Ciudadano
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<citizenservice-report-create
				route_list="citizenservice/reports/vue-list">
		</citizenservice-report-create>
	</div>
</div>
@stop
