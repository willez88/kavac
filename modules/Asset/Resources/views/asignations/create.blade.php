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
		<div class="card" id="cardAssetAsignationForm">
			<div class="card-header">
				<h6 class="card-title text-uppercase">Asignación de Bienes
					@include('buttons.help', [
					    'helpId' => 'AssetAsignationForm',
					    'helpSteps' => get_json_resource('ui-guides/asignations/asignation_form.json', 'asset')
				    ])
				</h6>
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<asset-asignation-create
				route_list="{{ url('asset/asignations')}}"
				:asignationid ="{!! (isset($asignation)) ? $asignation->id : 'null' !!}"
				:assetid ="{!! (isset($asset)) ? $asset->id : 'null' !!}">
			</asset-asignation-create>
		</div>
	</div>
</div>
@stop
