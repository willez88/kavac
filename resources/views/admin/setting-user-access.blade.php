@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Usuario
@stop

@section('maproute-title')
	Permisos de Acceso
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Usuario ({{ $user->name }}) - Roles y Permisos</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				{!! Form::open(['route' => 'roles.permissions.assign', 'method' => 'POST']) !!}
					{!! Form::token() !!}
					{!! Form::hidden('user', $user->id) !!}
					<div class="card-body">
						@include('layouts.form-errors')
						<h5 class="card-title text-center">Roles</h5>
						<div class="row">
							@foreach ($roles as $role)
								<div class="col-md-2 text-center">
									<div class="form-group">
										<label for="" class="control-label">{{ $role->name }}</label>
										<div class="col-12 bootstrap-switch-mini">
											{!! Form::checkbox('role[]', $role->id, null, [
												'class' => 'form-control bootstrap-switch bootstrap-switch-mini role',
												'data-on-label' => 'SI', 'data-off-label' => 'NO'
											]) !!}
										</div>
									</div>
								</div>
							@endforeach
						</div>
						<h5 class="card-title text-center">Permisos</h5>
						@php
							$module = "";
						@endphp
						<div class="row">
							@foreach ($permissions as $permission)
								@if ($module != $permission->model_prefix)
									@php
										$module = $permission->model_prefix;
									@endphp
									<div class="col-12" style="padding:20px 0">
										<hr>
										<h6 class="card-title text-center">
											MÓDULO [{{ strtoupper((substr($module, 0,1) != '0')?$module:substr($module, 1)) }}]
										</h6>
										<hr>
									</div>
								@endif
								<div class="col-md-4 text-center">
									<div class="form-group">
										<label for="" class="control-label">{{ $permission->name }}</label>
										<div class="col-12 bootstrap-switch-mini">
											{!! Form::checkbox('permission[]', $permission->id, null, [
												'class' => 'form-control bootstrap-switch bootstrap-switch-mini permission',
												'data-on-label' => 'SI', 'data-off-label' => 'NO'
											]) !!}
										</div>
									</div>
								</div>
							@endforeach
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