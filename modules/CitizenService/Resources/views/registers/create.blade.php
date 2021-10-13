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
	Ingresar Cronograma
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<citizenservice-register-create
		
				route_list="citizenservice/register"
				:requestid ="{!! (isset($request)) ? $request->id : 'null' !!}">
		</citizenservice-register-create>
	</div>
</div>
@stop
