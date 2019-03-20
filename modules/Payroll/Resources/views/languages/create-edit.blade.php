@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Nómina
@stop

@section('maproute-title')
	Idiomas
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar Idiomas</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($language))?Form::open($header):Form::model($language, $header) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
						<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
						<div class="row">
						    <div class="col-md-6">
						        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
						            {!! Form::label('name', 'Nombre', []) !!}
						            {!! Form::text('name',(isset($language))?$language->name:old('name'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el nombre del idioma'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-6">
						        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
						            {!! Form::label('acronym', 'Acrónimo', []) !!}
						            {!! Form::text('acronym',(isset($language))?$language->name:old('acronym'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el acrónimo'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-6">
						        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
									{!! Form::label('language_level_id', 'Nivel del idioma', []) !!}
						            {!! Form::select('language_level_id',(isset($language_levels))?$language_levels:[], null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Seleccione el nivel del idioma'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
@stop
