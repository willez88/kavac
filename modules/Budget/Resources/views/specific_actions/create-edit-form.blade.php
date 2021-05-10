@extends('budget::layouts.master')

@section('maproute-icon')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-arrow-graph-up-right"></i>
@stop

@section('maproute-actual')
	{{ __('Presupuesto') }}
@stop

@section('maproute-title')
	{{ __('Acciones Específicas') }}
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">
						{{ __('Acción Específica') }}
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
									{!! Form::label('project', __('Proyecto')) !!}
									<div class="col-12">
                                        <div class="col-12 bootstrap-switch-mini">
    										{!! Form::radio('project_centralized_action', 'project', null, [
    											'class' => 'form-control bootstrap-switch sel_project_centralized_action',
    											'data-on-label' => __('SI'), 'data-off-label' => __('NO'),
    											'id' => 'sel_project'
    										]) !!}
                                        </div>
									</div>
								</div>
								<div class="form-group">
									{!! Form::select('project_id', $projects, (isset($model))?$model->specificable_id:old('project_id'), [
										'class' => 'select2', 'data-toggle' => 'tooltip', 'id' => 'project_id',
										'title' => __('Seleccione un proyecto'),
										'disabled' => (!$errors->has('project_id'))?'disabled':false
									]) !!}
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									{!! Form::label('centralized_action', __('Acción Centralizada')) !!}
									<div class="col-12">
                                        <div class="col-12 bootstrap-switch-mini">
    										{!! Form::radio('project_centralized_action', 'centralized_action', null, [
    											'class' => 'form-control bootstrap-switch sel_project_centralized_action',
    											'data-on-label' => __('SI'), 'data-off-label' => __('NO'),
    											'id' => 'sel_centralized_action'
    										]) !!}
                                        </div>
									</div>
								</div>
								<div class="form-group">
									{!! Form::select('centralized_action_id', $centralized_actions, (isset($model))?$model->specificable_id:old('centralized_action_id'), [
										'class' => 'select2', 'data-toggle' => 'tooltip',
										'id' => 'centralized_action_id',
										'title' => __('Seleccione una acción centralizada'),
										'disabled' => (!$errors->has('centralized_action_id'))?'disabled':false
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-2">
								<div class="form-group is-required">
									{!! Form::label('from_date', __('Fecha de inicio'), ['class' => 'control-label']) !!}
									{!! Form::date('from_date', (isset($model))?$model->from_date:old('from_date'), [
										'class' => 'form-control input-sm', 'placeholder' => 'dd/mm/YYYY',
										'data-toggle' => 'tooltip',
										'title' => __('Fecha en la que inicia la acción específica')
									]) !!}
								</div>
							</div>
							<div class="col-2">
								<div class="form-group is-required">
									{!! Form::label('to_date', __('Fecha final'), ['class' => 'control-label']) !!}
									{!! Form::date('to_date', (isset($model))?$model->to_date:old('to_date'), [
										'class' => 'form-control input-sm no-restrict', 'placeholder' => 'dd/mm/YYYY',
										'data-toggle' => 'tooltip',
										'title' => __('Fecha en la que finaliza la acción específica')
									]) !!}
								</div>
							</div>
							<div class="col-2">
								<div class="form-group is-required">
									{!! Form::label('code', __('Código'), ['class' => 'control-label']) !!}
									{!! Form::text('code', old('code'), [
										'class' => 'form-control input-sm',
                                        'placeholder' => __('Código de la acción específica'),
										'data-toggle' => 'tooltip',
										'title' => __('Código que identifica la acción específica')
									]) !!}
								</div>
							</div>
							<div class="col-6">
								<div class="form-group is-required">
									{!! Form::label('name', __('Nombre'), ['class' => 'control-label']) !!}
									{!! Form::text('name', old('name'), [
										'class' => 'form-control input-sm',
                                        'placeholder' => __('Nombre de la acción específica'),
										'data-toggle' => 'tooltip',
										'title' => __('Nombre que identifica la acción específica')
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group is-required">
									{!! Form::label('description', __('Descripción'), ['class' => 'control-label']) !!}
                                    <ckeditor :editor="ckeditor.editor" id="description" data-toggle="tooltip"
                                              title="{!! __('Descripción de la acción específica') !!}"
                                              :config="ckeditor.editorConfig" class="form-control" name="description"
                                              tag-name="textarea" rows="4"
                                              value="{!! (isset($model))?$model->description:old('description')  !!}"
                                              placeholder="{!! __('Descripción de la acción específica') !!}"></ckeditor>

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
