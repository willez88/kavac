@extends('layouts.app')

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
	Proyectos
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Proyecto</h6>
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
						</div>
						<div class="row">
							<div class="col-3">
								<div class="form-group is-required">
									{!! Form::label('code', 'Código', ['class' => 'control-label']) !!}
									{!! Form::text('code', (isset($model)) ? $model->code : old('code'), [
										'class' => 'form-control', 'placeholder' => 'Código de proyecto',
										'data-toggle' => 'tooltip', 'title' => 'Código que identifica el proyecto'
									]) !!}
								</div>
							</div>
							<div class="col-3">
								<div class="form-group is-required">
									{!! Form::label('onapre_code', 'Código ONAPRE', ['class' => 'control-label']) !!}
									{!! Form::text('onapre_code', (isset($model)) ? $model->onapre_code : old('onapre_code'), [
										'class' => 'form-control', 'placeholder' => 'Código de la ONAPRE',
										'data-toggle' => 'tooltip', 
										'title' => 'Código asignado por la Oficina Nacional de Presupuesto (ONAPRE)'
									]) !!}
								</div>
							</div>
							<div class="col-6">
								<div class="form-group is-required">
									{!! Form::label('name', 'Nombre', ['class' => 'control-label']) !!}
									{!! Form::text('name', (isset($model)) ? $model->name : old('name'), [
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
										{!! Form::checkbox('active', true, (isset($model))?$model->active:null, [
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