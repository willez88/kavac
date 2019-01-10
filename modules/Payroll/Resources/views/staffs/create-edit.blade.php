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
					<h6 class="card-title">Registrar Personal</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				{!! (!isset($staff))?Form::open($header):Form::model($staff, $header) !!}
					<div class="card-body" id="example">
						@include('layouts.form-errors')
						<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
						<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('code') ? ' has-error' : '' }} is-required">
						            {!! Form::label('code', 'Código', []) !!}
						            {!! Form::text('code',(isset($staff))?$staff->code:old('code'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el código del personal'
						                ]
						            ) !!}
						        </div>
						    </div>
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
						</div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('nacionality') ? ' has-error' : '' }} is-required">
						            {!! Form::label('nationality', 'Nacionalidad', []) !!}
						            {!! Form::text('nationality',(isset($staff))?$staff->nationality:old('nationality'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la nacionalidad'
						                ]
						            ) !!}
						        </div>
						    </div>
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
						</div>
						<div class="row">
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
						        <div class="form-group {{ $errors->has('sex') ? ' has-error' : '' }} is-required">
						            {!! Form::label('sex', 'Sexo', []) !!}
						            {!! Form::select('sex', ['' => 'Seleccione...', 'M' => 'Masculino', 'F' => 'Femenino'],
						            (isset($staff))?$staff->sex:old('sex'),
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el sexo'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('marital_status_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('marital_status_id', 'Estado Civil', []) !!}
						            {!! Form::select('marital_status_id',(isset($marital_status))?$marital_status:[], null,
						                [
						                    'class' => 'form-control select2',
						                    'placeholder' => 'Seleccione...',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el estado civil'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('profession_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('profession_id', 'Profesión', []) !!}
						            {!! Form::select('profession_id',(isset($professions))?$professions:[], null,
						                [
						                    'class' => 'form-control select2',
						                    'placeholder' => 'Seleccione...',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la profesión'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group">
						            {!! Form::label('active', 'Activo', []) !!}
						            <div class="col-12">
						                {!! Form::checkbox('active', true, null, [
						                    'id' => 'active', 'class' => 'form-control bootstrap-switch',
						                    'data-on-label' => 'SI', 'data-off-label' => 'NO'
						                ]) !!}
						            </div>
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('website') ? ' has-error' : '' }}">
						            {!! Form::label('website', 'Sitio Web', []) !!}
						            {!! Form::text('website',(isset($staff))?$staff->website:old('website'),
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el sitio web'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('sons') ? ' has-error' : '' }}">
						            {!! Form::label('sons', 'Número de hijos', []) !!}
						            {!! Form::number('sons',(isset($staff))?$staff->sons:old('sons'),
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el número de hijos'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('start_date_adm_public') ? ' has-error' : '' }} is-required">
						            {!! Form::label('start_date_public_adm', 'Fecha de Ingreso a la Administración Pública', []) !!}
						            {!! Form::date('start_date_public_adm',(isset($staff))?$staff->start_date_public_adm:old('start_date_public_adm'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la fecha de ingreso a la administración pública'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }} is-required">
						            {!! Form::label('start_date', 'Fecha de Ingreso a la Institución', []) !!}
						            {!! Form::date('start_date',(isset($staff))?$staff->start_date:old('start_date'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la fecha de ingreso a la institución'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
						            {!! Form::label('end_date', 'Fecha de Egreso de la Institución', []) !!}
						            {!! Form::date('end_date',(isset($staff))?$staff->end_date:old('end_date'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la fecha de egreso de la institución'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('country_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('country_id', 'País', []) !!}
						            {!! Form::select('country_id',(isset($countries))?$countries:[], null,
						                [
											'v-model' => 'country_id',
											'@change' => 'getEstates()',
						                    'class' => 'form-control select2',
						                    'placeholder' => 'Seleccione...',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el país donde vive'
						                ]
						            ) !!}
						        </div>
						    </div>
						</div>
						<div class="row">
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('estate_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('estate_id', 'Estado', []) !!}
						            {!! Form::select('estate_id',(isset($estates))?$estates:[], null,
						                [
						                    'class' => 'form-control select2',
						                    'placeholder' => 'Seleccione...',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el estado donde vive'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('city_id') ? ' has-error' : '' }} is-required">
						            {!! Form::label('city_id', 'Ciudad', []) !!}
						            {!! Form::select('city_id',(isset($cities))?$cities:[], null,
						                [
						                    'class' => 'form-control select2',
						                    'placeholder' => 'Seleccione...',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique la ciudad donde vive'
						                ]
						            ) !!}
						        </div>
							</div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('direction') ? ' has-error' : '' }} is-required">
						            {!! Form::label('direction', 'Dirección', []) !!}
						            {!! Form::text('direction',(isset($staff))?$staff->direction:old('direction'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el país donde vive'
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

@section('extra-js')
	<script>
		var app = new Vue({
			el: '#example',
			data() {
				return {
					country_id: '',
				}
			},
			methods: {
				getEstates() {
					if (this.country_id) {
						axios.get('/get-estates/' + this.country_id).then(response => {
							this.estates = response.data;
						});
					}
				},
			}
		})
	</script>
@stop
