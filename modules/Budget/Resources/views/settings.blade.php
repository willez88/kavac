@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Presupuesto
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Parámetros Generales</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-12">
							<h6>Formulación</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('formulation_code', 'Código de Formulación', []) !!}
								{!! Form::text('formulation_code', old('formulation_code'), [
									'class' => 'form-control', 'data-toggle' => 'tooltip',
									'title' => 'Formato para el código de la formulación de presupuesto'
								]) !!}
							</div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-12">
							<h6>Ejecución</h6>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('duty_code', 'Código de Compromiso', []) !!}
								{!! Form::text('duty_code', old('duty_code'), [
									'class' => 'form-control', 'data-toggle' => 'tooltip',
									'title' => 'Formato para el código del causado'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('transfer_code', 'Código de Traspaso', []) !!}
								{!! Form::text('transfer_code', old('transfer_code'), [
									'class' => 'form-control', 'data-toggle' => 'tooltip',
									'title' => 'Formato para el código del traspaso'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('reduction_code', 'Código de Reducción', []) !!}
								{!! Form::text('reduction_code', old('reduction_code'), [
									'class' => 'form-control', 'data-toggle' => 'tooltip',
									'title' => 'Formato para el código de reducciones'
								]) !!}
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								{!! Form::label('credit_code', 'Código de Crédito Adicional', []) !!}
								{!! Form::text('credit_code', old('credit_code'), [
									'class' => 'form-control', 'data-toggle' => 'tooltip',
									'title' => 'Formato para el código de créditos adicionales'
								]) !!}
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Unidades Administrativas</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr>
								<th></th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Proyectos / Acciones Centralizadas</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr>
								<th></th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Proyecto - Acciones Específicas</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr>
								<th></th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Acción Centralizada - Acciones Específicas</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr>
								<th></th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
@stop