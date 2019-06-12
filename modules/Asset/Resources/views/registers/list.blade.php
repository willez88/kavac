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
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Bienes Institucionales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('asset.register.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<asset-list
						route_list="{{ url('asset/registers/vue-list') }}"
						route_edit="{{ url('asset/registers/edit/{id}') }}"
						route_delete="{{ url('asset/registers/delete') }}">
					</asset-list>
				</div>
			</div>
		</div>
	</div>
@stop