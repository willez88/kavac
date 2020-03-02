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
	Gestión de Bienes Institucionales
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card" id="cardAssetForm">
			<div class="card-header">
				<h6 class="card-title text-uppercase">Registro Manual de Bienes Institucionales
					@include('buttons.help', [
					    'helpId' => 'AssetForm',
					    'helpSteps' => get_json_resource('ui-guides/registers/register_form.json', 'asset')
				    ])
				</h6>
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<asset-create
				route_list='{{ url('asset/registers')}}'
				:assetid ="{!! (isset($asset)) ? $asset->id : 'null' !!}">
			</asset-create>
		</div>
	</div>
</div>
@stop
