@extends('layouts.app')

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
	Gestión de Bienes Institucionales
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<asset-asignation-create
			route_list="{{ url('asset/asignations')}}"
			:asignationid ="{!! (isset($asignation)) ? $asignation->id : 'null' !!}"
			:assetid ="{!! (isset($asset)) ? $asset->id : 'null' !!}">
		</asset-asignation-create>

	</div>

</div>

@stop