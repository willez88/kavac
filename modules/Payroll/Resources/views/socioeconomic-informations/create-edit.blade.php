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
	Datos Socioeconómicos
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Registrar los Datos Socioeconómicos</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($socioeconomic_information))?Form::open($header):Form::model($socioeconomic_information, $header) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
						<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
						<div class="row">
							<div class="col-md-4">
						        <div class="form-group {{ $errors->has('nationality_id') ? ' has-error' : '' }} is-required">
									{!! Form::label('staff_id', 'Trabajador', []) !!}
						            {!! Form::select('staff_id',(isset($staffs))?$staffs:[], (isset($staff))?$staff->first_name:null,
						                [
						                    'class' => 'form-control select2',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Seleccione al trabajador'
						                ]
						            ) !!}
						        </div>
						    </div>
						    <div class="col-md-4">
						        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
						            {!! Form::label('first_name_twosome', 'Nombre', []) !!}
						            {!! Form::text('first_name_twosome',(isset($socioeconomic_information))?$socioeconomic_information->name:old('first_name_twosome'),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Indique el nombre de la pareja del trabajador'
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
