@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Bienes
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Formatos de Códigos</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['route' => 'asset.setting.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-12">
								<h6>Gestión de Bienes</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									{!! Form::label('asignation_code', 'Código de las asignaciones', []) !!}
									{!! Form::text('asignations_code', ($asCode) ? $asCode->format_code : old('asignations_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de las asignaciones',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($asCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{!! Form::label('disincorporation_code', 'Código de las desincorporaciones', []) !!}
									{!! Form::text('disincorporations_code', ($dsCode) ? $dsCode->format_code : old('disincorporations_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de las desincorporaciones',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($dsCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{!! Form::label('request_code', 'Código de las solicitudes', []) !!}
									{!! Form::text('requests_code', ($rqCode) ? $rqCode->format_code : old('requests_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de las solicitudes',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($rqCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{!! Form::label('inventory_code', 'Código de los registros de inventario', []) !!}
									{!! Form::text('inventories_code', ($ivCode) ? $ivCode->format_code : old('inventories_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de los registros de inventario',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($ivCode) ? true : false
									]) !!}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{!! Form::label('report_code', 'Código de los reportes', []) !!}
									{!! Form::text('reports_code', ($rpCode) ? $rpCode->format_code : old('reports_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de los reportes',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($rpCode) ? true : false
									]) !!}
								</div>
							</div>
						</div>
						@include('layouts.help-text', ['codeSetting' => true])
					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Parámetros Generales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Configuración de la Condición Física de un Bien --}}
						<asset-conditions></asset-conditions>

						{{-- Configuración del Status de Uso de un Bien --}}
						<asset-status></asset-status>

						{{-- Configuración de la Función de Uso de un Bien --}}
						<asset-use-functions></asset-use-functions>

						{{-- Configuración del Tipo de Adquisición de un Bien --}}
						<asset-acquisition-types></asset-acquisition-types>

					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Parámetros Específicos del Clasificador de Bienes</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Configuración de Tipos de Bienes --}}
						<asset-types></asset-types>

						{{-- Configuración de Categorías Generales de Bienes --}}
						<asset-categories></asset-categories>

						{{-- Configuración de Subcategorías de Bienes --}}
						<asset-subcategories></asset-subcategories>

						{{-- Configuración de Categorías Específicas de Bienes --}}
						<asset-specific-categories></asset-specific-categories>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop
