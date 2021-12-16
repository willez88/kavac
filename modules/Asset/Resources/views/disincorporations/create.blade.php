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
		<div class="card" id="cardAssetDisincorporationForm">
			<div class="card-header">
				<h6 class="card-title text-uppercase">Desincorporación de Bienes
					@include('buttons.help', [
					    'helpId' => 'AssetDisincorporationForm',
					    'helpSteps' => get_json_resource('ui-guides/disincorporations/disincorporation_form.json', 'asset')
				    ])
				</h6>
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<asset-disincorporation-create
				route_list="asset/disincorporations"
				:disincorporationid ="{!! (isset($disincorporation)) ? $disincorporation->id : 'null' !!}"
				:assetid ="{!! (isset($asset)) ? $asset->id : 'null' !!}">
			</asset-disincorporation-create>
		</div>
	</div>
</div>
@stop

@section('extra-js')
    @parent
    {!! Html::script('js/ckeditor.js', [], Request::secure()) !!}
@stop
