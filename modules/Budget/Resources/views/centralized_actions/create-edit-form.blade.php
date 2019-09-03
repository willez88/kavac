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
	Acciones Centralizadas
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Acción Centralizada</h6>
					<div class="card-btns">
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! (!isset($model))?Form::open($header):Form::model($model, $header) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<div class="row">
							<div class="col-3">
								<div class="form-group is-required">
									{!! Form::label('institution_id', 'Institución', ['class' => 'control-label']) !!}
									{!! Form::select('institution_id', $institutions, null, [
										'class' => 'select2', 'data-toggle' => 'tooltip',
										'title' => 'Seleccione una institución'
									]) !!}
								</div>
							</div>
							<div class="col-3">
								<div class="form-group is-required">
									{!! Form::label('department_id', 'Dependencia', ['class' => 'control-label']) !!}
									{!! Form::select('department_id', $departments, null, [
										'class' => 'select2', 'data-toggle' => 'tooltip',
										'title' => 'Seleccione un departamento o dependencia'
									]) !!}
								</div>
							</div>
							@if (Module::has('Payroll') && Module::enabled('Payroll'))
								<div class="col-3">
									<div class="form-group is-required">
										{!! Form::label('payroll_position_id', 'Cargo de Responsable', [
											'class' => 'control-label'
										]) !!}
										{!! Form::select('payroll_position_id', $positions, null, [
											'class' => 'select2', 'data-toggle' => 'tooltip',
											'title' => 'Seleccione el cargo de la persona responsable del proyecto'
										]) !!}
									</div>
								</div>
								<div class="col-3">
									<div class="form-group is-required">
										{!! Form::label('payroll_staff_id', 'Responsable', ['class' => 'control-label']) !!}
										{!! Form::select('payroll_staff_id', $staffs, null, [
											'class' => 'select2', 'data-toggle' => 'tooltip',
											'title' => 'Seleccione una persona responsable del proyecto'
										]) !!}
									</div>
								</div>
							@endif
						</div>
						<div class="row">
							<div class="col-3">
								<div class="form-group is-required">
									{!! Form::label('custom_date', 'Fecha de creación', ['class' => 'control-label']) !!}
									{!! Form::date('custom_date', old('custom_date'), [
										'class' => 'form-control', 'placeholder' => 'dd/mm/YY',
										'data-toggle' => 'tooltip',
										'title' => 'Fecha en la que se creó la acción centralizada'
									]) !!}
								</div>
							</div>
							<div class="col-3">
								<div class="form-group is-required">
									{!! Form::label('code', 'Código', ['class' => 'control-label']) !!}
									{!! Form::text('code', old('code'), [
										'class' => 'form-control', 'placeholder' => 'Código de proyecto',
										'data-toggle' => 'tooltip', 'title' => 'Código que identifica el proyecto'
									]) !!}
								</div>
							</div>
							<div class="col-6">
								<div class="form-group is-required">
									{!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
									{!! Form::text('name', old('name'), [
										'class' => 'form-control', 'placeholder' => 'Nombre del proyecto',
										'data-toggle' => 'tooltip',
										'title' => 'Nombre que identifica el proyecto'
									]) !!}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-3">
								<div class="form-group">
									<label for="" class="control-label">Activo</label>
									<div class="col-12">
										{!! Form::checkbox('active', true, (isset($model))?$model->active:true, [
											'id' => 'active', 'class' => 'form-control bootstrap-switch',
											'data-on-label' => 'SI', 'data-off-label' => 'NO'
										]) !!}
									</div>
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
