@extends('citizenservice::layouts.master')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	{{ __('Atención / Ciudadano') }}
	
@stop

@section('maproute-title')
	{{ __('Configuración') }}

@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card" id="helpCodeSettingForm">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Formatos de Códigos') }}
						@include('buttons.help', [
					    'helpId' => 'CitizenServiceCodeSetting',
					    'helpSteps' => get_json_resource('ui-guides/settings/code_setting.json', 'citizenservice')
			    		])
			    	</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['id' => 'form-codes', 'route' => 'citizenservice.settings.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-12">
								<h6>{{ __('Código de solicitud') }}</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4" id="helpCodeRequest">
								<div class="form-group">
									{!! Form::label('request_code', 'Código de la solicitud', []) !!}
									{!! Form::text('request_code', ($sCode) ? $sCode->format_code : old('request_code'), [
										'class' => 'form-control input-sm', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de la solicitud',
										'placeholder' => 'Ej. XXX-00000000-YYYY',
										'readonly' => ($sCode) ? true : false
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
			<div class="card" id="helpCommonForm">
				<div class="card-header">
					<h6 class="card-title">
					{{ __('Registros Comunes') }}
					@include('buttons.help', [
					    'helpId' => 'Common',
							'helpSteps' => get_json_resource('ui-guides/settings/common.json', 'citizenservice')
					])
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						{{-- Configuración de tipos de solicitud --}}
						<citizenservice-request-types id="helpCitizenServiceRequestTypes"></citizenservice-request-types>
						{{-- Configuración de departamentos --}}
						<citizenservice-departments id="helpCitizenServiceDepartments"></citizenservice-departments>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
