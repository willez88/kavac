@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Configuración
@stop

@section('maproute-title')
	Acceso al Sistema
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Roles y Permisos</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				{!! Form::open(['route' => 'roles.permissions.settings', 'method' => 'POST']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						@php
							$roles = Ultraware\Roles\Models\Role::where('slug', '<>', 'user')->get();
							$permissions = Ultraware\Roles\Models\Permission::orderBy('model_prefix')->get();
							$module = "";
						@endphp
						<table class="table table-hover table-striped dt-responsive">
							<thead>
								<tr>
									<th class="text-center border-right" rowspan="2">PERMISOS</th>
									<th class="text-center" colspan="{{ count($roles) }}">ROLES</th>
								</tr>
								<tr>
									@foreach ($roles as $role)
										<th class="text-center" title="{{ $role->description }}" 
											data-toggle="tooltip">
											{{ $role->name }}
										</th>
									@endforeach
								</tr>
							</thead>
							<tbody>
								@foreach ($permissions as $perm)
									@if ($module != $perm->model_prefix)
										@php
											$module = $perm->model_prefix;
										@endphp
										<tr>
											<th></th>
											<th class="text-center" colspan="{{ count($roles) }}">
												<span class="card-title">
													MÓDULO [{{ strtoupper((substr($module, 0,1) != '0')?$module:substr($module, 1)) }}]
												</span>
											</th>
										</tr>
									@endif
									@if ($perm->slug_alt)
										<tr>
											<td title="{{ $perm->description }}" data-toggle="tooltip" 
												class="border-right" style="width: 20%">
												{{ (!empty($perm->short_description))
													?strtoupper($perm->short_description)
													:strtoupper($perm->name) }}
											</td>
											@foreach ($roles as $role)
												<td class="text-center bootstrap-switch-mini">
													{!! Form::checkbox(
														'perm[]', $role->id . ":" . $perm->id, (
															$role->permissions()
																 ->where('permission_id', $perm->id)
																 ->first()),
														[
															'class' => 'form-control bootstrap-switch ' . 
																	   'bootstrap-switch-mini',
															'data-on-label' => 'SI', 
															'data-off-label' => 'NO'
														]
													) !!}
												</td>
											@endforeach
										</tr>
									@endif
								@endforeach
							</tbody>
						</table>
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
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Usuarios</h6>
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
							   title="Agregar nuevo usuario" data-toggle="tooltip">
								<i class="fa fa-plus-circle"></i>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
					<table class="table table-hover table-striped dt-responsive datatable">
						<thead>
							<tr class="text-center">
								<th>Usuario</th>
								<th>Unidad / Departamento</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach (App\User::all() as $user)
								<tr>
									<td>{{ $user->username }}</td>
									<td></td>
									<td></td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="card-footer text-right">
					@include('layouts.form-buttons')
				</div>
			</div>
		</div>
	</div>
@stop