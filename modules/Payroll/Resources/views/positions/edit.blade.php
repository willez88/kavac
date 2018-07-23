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
	Cargos
@stop

@section('content')
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Actualizar Cargo</h6>
				<div class="card-btns">
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
					   data-toggle="tooltip">
    					<i class="now-ui-icons arrows-1_minimal-up"></i>
    				</a>
				</div>
			</div>
			{!! Form::model($model_position,$header_position) !!}
				<div class="card-body">
					@include('layouts.form-errors')
					<div id="kv-avatar-errors-logo_id" class="kv-avatar-errors center-block"></div>
					<div id="kv-avatar-errors-banner_id" class="kv-avatar-errors center-block"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} is-required">
								{!! Form::label('name', 'Nombre', []) !!}
								{!! Form::text('name',(isset($model_staff_type))?$model_staff_type->name:old('name'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'required' => 'required',
										'title' => 'Indique el nombre del cargo'
									]
								) !!}
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group{{ $errors->has('description') ? ' has-error' : '' }} is-required">
								{!! Form::label('description', 'Descripción', []) !!}
								{!! Form::text('description',(isset($model_staff_type))?$model_staff_type->description:old('description'),
									[
										'class' => 'form-control input-sm',
										'data-toggle' => 'tooltip',
										'required' => 'required',
										'title' => 'Indique la descripción del cargo'
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
