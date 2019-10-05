@extends('budget::layouts.master')

@section('maproute-icon')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
	Presupuesto
@stop

@section('maproute-title')
	Acciones Específicas
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						Acción Específica
						@include('buttons.help')
					</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									{!! Form::label('project', 'Proyecto') !!}
									<div class="col-12">
										{!! Form::radio('project_centralized_action', 'project', null, [
											'class' => 'form-control bootstrap-switch sel_project_centralized_action',
											'data-on-label' => 'SI', 'data-off-label' => 'NO',
											'id' => 'sel_project'
										]) !!}
									</div>
								</div>
								<div class="form-group">
									{!! Form::select('project_id', $projects, (isset($model))?$model->specificable_id:old('project_id'), [
										'class' => 'select2', 'data-toggle' => 'tooltip', 'id' => 'project_id',
										'title' => 'Seleccione un proyecto',
										'disabled' => (!$errors->has('project_id'))?'disabled':false
									]) !!}
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									{!! Form::label('centralized_action', 'Acción Centralizada') !!}
									<div class="col-12">
										{!! Form::radio('project_centralized_action', 'centralized_action', null, [
											'class' => 'form-control bootstrap-switch sel_project_centralized_action',
											'data-on-label' => 'SI', 'data-off-label' => 'NO',
											'id' => 'sel_centralized_action'
										]) !!}
									</div>
								</div>
								<div class="form-group">
									{!! Form::select('centralized_action_id', $centralized_actions, (isset($model))?$model->specificable_id:old('centralized_action_id'), [
										'class' => 'select2', 'data-toggle' => 'tooltip',
										'id' => 'centralized_action_id',
										'title' => 'Seleccione una acción centralizada',
										'disabled' => (!$errors->has('centralized_action_id'))?'disabled':false
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-2">
								<div class="form-group is-required">
									{!! Form::label('from_date', 'Fecha de inicio', ['class' => 'control-label']) !!}
									{!! Form::date('from_date', (isset($model))?$model->from_date:old('from_date'), [
										'class' => 'form-control', 'placeholder' => 'dd/mm/YYYY',
										'data-toggle' => 'tooltip',
										'title' => 'Fecha en la que inicia la acción específica'
									]) !!}
								</div>
							</div>
							<div class="col-2">
								<div class="form-group is-required">
									{!! Form::label('to_date', 'Fecha final', ['class' => 'control-label']) !!}
									{!! Form::date('to_date', (isset($model))?$model->from_date:old('to_date'), [
										'class' => 'form-control', 'placeholder' => 'dd/mm/YYYY',
										'data-toggle' => 'tooltip',
										'title' => 'Fecha en la que finaliza la acción específica'
									]) !!}
								</div>
							</div>
							<div class="col-2">
								<div class="form-group is-required">
									{!! Form::label('code', 'Código', ['class' => 'control-label']) !!}
									{!! Form::text('code', old('code'), [
										'class' => 'form-control', 'placeholder' => 'Código de la acción específica',
										'data-toggle' => 'tooltip',
										'title' => 'Código que identifica la acción específica'
									]) !!}
								</div>
							</div>
							<div class="col-6">
								<div class="form-group is-required">
									{!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
									{!! Form::text('name', old('name'), [
										'class' => 'form-control', 'placeholder' => 'Nombre de la acción específica',
										'data-toggle' => 'tooltip',
										'title' => 'Nombre que identifica la acción específica'
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group is-required">
									{!! Form::label('description', 'Descripción', ['class' => 'control-label']) !!}
									{!! Form::textarea('description', old('description'), [
										'class' => 'form-control', 'rows' => '4',
										'placeholder' => 'Descripción de la acción específica',
										'data-toggle' => 'tooltip',
										'title' => 'Descripción de la acción específica'
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
@stop

@section('extra-js')
	@parent
	<script>
		$(document).ready(function() {
			$('.sel_project_centralized_action').on('switchChange.bootstrapSwitch', function(e) {
				$('#project_id').attr('disabled', (e.target.id!=="sel_project"));
				$('#centralized_action_id').attr('disabled', (e.target.id!=="sel_centralized_action"));

				if (e.target.id === "sel_project") {
					$("#centralized_action_id").closest('.form-group').removeClass('is-required');
					$("#project_id").closest('.form-group').addClass('is-required');
				}
				else if (e.target.id === "sel_centralized_action") {
					$("#centralized_action_id").closest('.form-group').addClass('is-required');
					$("#project_id").closest('.form-group').removeClass('is-required');
				}
			});
		});
	</script>
@endsection
