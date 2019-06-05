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
	Personal
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar Datos Personales</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($staff))?Form::open($header):Form::model($staff, $header) !!}
					<div class="card-body" id="example">
						@include('layouts.form-errors')
						<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
						<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }} is-required">
						            {!! Form::label('first_name', 'Nombres', []) !!}
						            {!! Form::text('first_name',(isset($staff))?$staff->first_name:old('first_name'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique los nombres'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }} is-required">
						            {!! Form::label('last_name', 'Apellidos', []) !!}
						            {!! Form::text('last_name',(isset($staff))?$staff->last_name:old('last_name'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique los apellidos'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('nationality_id') ? ' has-error' : '' }} is-required">
									{!! Form::label('payroll_nationality_id', 'Nacionalidad', []) !!}
						            {!! Form::select('payroll_nationality_id',(isset($nationalities))?$nationalities:[], (isset($staff))?$staff->payroll_nationality_id:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la nacionalidad'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('id_number') ? ' has-error' : '' }} is-required">
						            {!! Form::label('id_number', 'Cédula de Identidad', []) !!}
						            {!! Form::text('id_number',(isset($staff))?$staff->id_number:old('id_number'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la cédula de identidad'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('passport') ? ' has-error' : '' }}">
						            {!! Form::label('passport', 'Pasaporte', []) !!}
						            {!! Form::text('passport',(isset($staff))?$staff->passport:old('passport'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el número del pasaporte'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
						            {!! Form::label('email', 'Correo Electrónico', []) !!}
						            {!! Form::email('email',(isset($staff))?$staff->email:old('email'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el correo electrónico'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('birthdate') ? ' has-error' : '' }} is-required">
						            {!! Form::label('birthdate', 'Fecha de Nacimiento', []) !!}
						            {!! Form::date('birthdate',(isset($staff))?$staff->birthdate:old('birthdate'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la fecha de nacimiento'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('gender_id') ? ' has-error' : '' }} is-required">
									{!! Form::label('payroll_gender_id', 'Género', []) !!}
						            {!! Form::select('payroll_gender_id',(isset($genders))?$genders:[], (isset($staff))?$staff->payroll_gender_id:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el género de la persona'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('emergency_contact') ? ' has-error' : '' }}">
						            {!! Form::label('emergency_contact', 'Nombres y apellidos de la persona de contacto', []) !!}
						            {!! Form::text('emergency_contact',(isset($staff))?$staff->emergency_contact:old('emergency_contact'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique nombres y apellidos de la persona de contacto'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
						<div class="row">
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('emergency_phone') ? ' has-error' : '' }}">
						            {!! Form::label('emergency_phone', 'Teléfono de la persona de contacto', []) !!}
						            {!! Form::text('emergency_phone',(isset($staff))?$staff->emergency_phone:old('emergency_phone'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el teléfono de la persona de contacto'
						                ]
						            ) !!}
						        </div>
						    </div>

						</div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('country_id', 'País', []) !!}
						            {!! Form::select('country_id',(isset($countries))?$countries:[], (isset($staff))?$staff->parish->municipality->estate->country_id:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Seleccione el país donde vive'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('estate_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('estate_id', 'Estado', []) !!}
						            {!! Form::select('estate_id',(isset($estates))?$estates:[], (isset($staff))?$staff->parish->municipality->estate_id:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Seleccione el estado donde vive'
						                ]
						            ) !!}
						        </div>
						    </div>
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('parish_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('municipality_id', 'Municipio', []) !!}
						            {!! Form::select('municipality_id',(isset($municipalities))?$municipalities:[], (isset($staff))?$staff->parish->municipality_id:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Seleccione el municipio donde vive'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
						<div class="row">
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('parish_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('parish_id', 'Parroquia', []) !!}
						            {!! Form::select('parish_id',(isset($parishes))?$parishes:[], (isset($staff))?$staff->parish_id:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Seleccione la parroquia donde vive'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('address') ? ' has-error' : '' }} is-required">
						            {!! Form::label('addres', 'Dirección', []) !!}
						            {!! Form::text('address',(isset($staff))?$staff->address:old('address'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la dirección donde vive'
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
