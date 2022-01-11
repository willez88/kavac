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
		<div class="card" id="cardCitizenServiceRegisterForm">
			<div class="card-header">
    				<h6 class="card-title">Cronograma de actividades
    					@include('buttons.help', [
    					    'helpId' => 'CitizenServiceRegisterForm',
    					    'helpSteps' => get_json_resource('ui-guides/registers/register_form.json', 'citizenservice')
    				    ])
    				</h6>

    				<div class="card-btns">
    					@include('buttons.previous', ['route' => url()->previous()])
    					@include('buttons.minimize')
    				</div>
    		</div>
			<citizenservice-register-create
			
					route_list="{{ url('citizenservice/register') }}"
					:requestid ="{!! (isset($request)) ? $request->id : 'null' !!}">
			</citizenservice-register-create>
		</div>
	</div>
</div>
@stop
