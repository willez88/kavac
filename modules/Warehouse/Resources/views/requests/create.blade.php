@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-ios-list-outline"></i>
@stop

@section('maproute-actual')
	Almacén
@stop

@section('maproute-title')
	Gestión de Almacenes
@stop


@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Solicitud de Almacén</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
						   <i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>

				{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
					<div class="row">

						<div class="col-md-12">
							<b>Datos de la Solicitud</b>
						</div>

						<div class="col-md-4">
						    <div class="form-group {{ $errors->has('date') ? ' has-error' : '' }}">
						        {!! Form::label('date_label', 'Fecha de Solicitud', []) !!}
						        <div class="input-group input-sm">
						            <span class="input-group-addon">
						                <i class="now-ui-icons ui-1_calendar-60"></i>
						            </span>
						            {!! Form::date('date',(isset($request->created_at))?$request->created_at:\Carbon\Carbon::now(),
						                [
						                    'class' => 'form-control input-sm',
						                    'data-toggle' => 'tooltip',
						                    'title' => 'Fecha de la solicitud',
						                    'readonly' => 'readonly',
						                ]
						            ) !!}
						        </div>
						            
						    </div>
						</div>

					
						<div class="col-md-4">
						    <div class="form-group{{ $errors->has('motivo') ? ' has-error' : '' }} is-required">
						        {!! Form::label('motivo_label', 'Motivo de la solicitud', []) !!}
						        {!! Form::text('motive',(isset($request))?$request->motive:old('motive'),
						           [
						                'class' => 'form-control input-sm',
						                'data-toggle' => 'tooltip',
						                'title' => 'Indique el motivo de la solicitud'
						            ]
						        ) !!}
						    </div>
						</div>

						<div class="col-md-4">
							<div class="form-group   {{ $errors->has('dependence') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('solicitante_label', 'Solicitante', []) !!}
								{!! Form::select('solicitante', (isset($dependences))?$dependences:[], (isset($request->dependence_id))?$request->dependence_id:null, [		
									'class' => 'form-control select2',
									'data-toggle' => 'tooltip',
									'title' => 'Indique la dependencia que hace la solicitud',
									
								]) !!}
								
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group   {{ $errors->has('project') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('project_label', 'Proyecto', []) !!}
								{!! Form::select('project', (isset($projects))?$projects:[], (isset($request->project_id))?$request->project_id:null, [		
									'class' => 'form-control select2',
									'data-toggle' => 'tooltip',
									'title' => 'Indique el proyecto para el que se realiza la solicitud',
									
								]) !!}
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group   {{ $errors->has('project_acc') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('project_acc_label', 'Acción Centralizada', []) !!}
								{!! Form::select('project_acc', (isset($actions_c))?$actions_c:[], (isset($request->project_acc_id))?$request->project_acc_id:null, [		
									'class' => 'form-control select2',
									'data-toggle' => 'tooltip',
									'title' => 'Indique la acción centralizada relacionada al proyecto',
									
								]) !!}
								
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group   {{ $errors->has('project_acs') ? ' has-error' : '' }} is-required">
								
								{!! Form::label('project_acs_label', 'Acción Específica', []) !!}
								{!! Form::select('action_s', (isset($action_s))?$projects:[], (isset($request->project_acs_id))?$request->project_acs_id:null, [		
									'class' => 'form-control select2',
									'data-toggle' => 'tooltip',
									'title' => 'Indique la acción específica relacionada con el proyecto',
									
								]) !!}
								
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

	<div class="row">
		<div class="col-12">
			<warehouse-request></warehouse-request>
		</div>
	</div>

@stop