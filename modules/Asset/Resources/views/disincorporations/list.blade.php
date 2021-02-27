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
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Desincorporación de Bienes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('asset.disincorporation.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<asset-disincorporation-list
						route_list="{{ url('asset/disincorporations/vue-list') }}"
						route_edit="{{ url('asset/disincorporations/edit/{id}') }}"
						route_delete="{{ url('asset/disincorporations/delete') }}">
					</asset-disincorporation-list>
				</div>
			</div>
		</div>
	</div>
@stop
