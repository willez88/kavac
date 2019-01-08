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
				{!! Form::open(['route' => 'budget.settings.store', 'method' => 'post']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<h6>Formulación</h6>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('formulations_code', 'Código de Formulación', []) !!}
									{!! Form::text('formulations_code', old('formulations_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de la formulación de presupuesto',
										'placeholder' => 'Ej. XXX-0000000000-YYYY'
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
									{!! Form::label('commitments_code', 'Código de Compromiso', []) !!}
									{!! Form::text('commitments_code', old('commitments_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código del causado',
										'placeholder' => 'Ej. XXX-0000000000-YYYY'
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('transfers_code', 'Código de Traspaso', []) !!}
									{!! Form::text('transfers_code', old('transfers_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código del traspaso',
										'placeholder' => 'Ej. XXX-0000000000-YYYY'
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('reductions_code', 'Código de Reducción', []) !!}
									{!! Form::text('reductions_code', old('reductions_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de reducciones',
										'placeholder' => 'Ej. XXX-0000000000-YYYY'
									]) !!}
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									{!! Form::label('credits_code', 'Código de Crédito Adicional', []) !!}
									{!! Form::text('credits_code', old('credits_code'), [
										'class' => 'form-control', 'data-toggle' => 'tooltip',
										'title' => 'Formato para el código de créditos adicionales',
										'placeholder' => 'Ej. XXX-0000000000-YYYY'
									]) !!}
								</div>
							</div>
						</div>
						@include('layouts.help-text', ['codeSetting' => true])
					</div>
					<div class="card-footer text-right">
						@include('layouts.form-buttons')
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
	{{-- <div class="row">
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
					<div class="row">
						<div class="col-12">
							<a href="#" 
							   class="btn btn-sm btn-primary btn-custom float-right" 
							   title="Crear nuevo registro" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
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
	</div> --}}
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Proyectos</h6>
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
							<a href="{{ route('budget.projects.create') }}" 
							   class="btn btn-sm btn-primary btn-custom float-right" 
							   title="Crear nuevo registro" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
					<budget-projects-list route_list='{{ url('budget/projects/vue-list') }}' 
										  route_delete="{{ url('budget/projects/delete') }}" 
										  route_edit="{{ url('budget/projects/{id}/edit') }}">
					</budget-projects-list>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Acciones Centralizadas</h6>
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
							<a href="#" 
							   class="btn btn-sm btn-primary btn-custom float-right" 
							   title="Crear nuevo registro" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
					<table class="table table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr>
								<th>Período</th>
								<th>Código</th>
								<th>Acción Central</th>
								<th>Responsable</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Acciones Específicas</h6>
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
							<a href="#" 
							   class="btn btn-sm btn-primary btn-custom float-right" 
							   title="Crear nuevo registro" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
					<table class="table table-hover table-striped dt-responsive nowrap datatable">
						<thead>
							<tr>
								<th>Período</th>
								<th>Proyecto / Acción Central</th>
								<th>Acción Específica</th>
								<th>Responsable</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	{{-- <div class="row">
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
					<div class="row">
						<div class="col-12">
							<a href="#" 
							   class="btn btn-sm btn-primary btn-custom float-right" 
							   title="Crear nuevo registro" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
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
	</div> --}}
@stop