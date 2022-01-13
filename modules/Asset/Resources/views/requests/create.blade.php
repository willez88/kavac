@extends('asset::layouts.master')

@section('maproute-icon')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-pricetags-outline"></i>
@stop

@section('maproute-actual')
	Bienes
@stop

@section('maproute-title')
	Gestión de Bienes
@stop

@section('content')
    <div class="row">
    	<div class="col-12">
    		<div class="card" id="cardAssetRequestForm">
    			<div class="card-header">
    				<h6 class="card-title text-uppercase">Solicitudes de Bienes
    					@include('buttons.help', [
    					    'helpId' => 'AssetRequestForm',
    					    'helpSteps' => get_json_resource('ui-guides/requests/request_form.json', 'asset')
    				    ])
    				</h6>

    				<div class="card-btns">
    					@include('buttons.previous', ['route' => url()->previous()])
    					@include('buttons.minimize')
    				</div>
    			</div>
    			<asset-request-create
    				route_list="{{ url('asset/requests') }}"
    				:requestid ="{!! (isset($request)) ? $request->id : 'null' !!}">
    			</asset-request-create>
    		</div>
    	</div>
    </div>
@stop

@section('extra-js')
    @parent
    {!! Html::script('js/ckeditor.js', [], Request::secure()) !!}
@stop
