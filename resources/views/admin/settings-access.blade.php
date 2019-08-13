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
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.minimize')
					</div>
				</div>
				{!! Form::open(['route' => 'roles.permissions.settings', 'method' => 'POST']) !!}
					{!! Form::token() !!}
					<div class="card-body">
						@include('layouts.form-errors')
						@php
							$roles = App\Roles\Models\Role::where('slug', '<>', 'user')->get();
							$permissions = App\Roles\Models\Permission::orderBy('model_prefix')->get();
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
						@include('buttons.form-display', ['hide_clear' => true, 'hide_previous' => true])
						@include('layouts.form-buttons', ['hide_clear' => true, 'hide_previous' => true])
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
						@include('buttons.previous', ['route' => url()->previous()])
						@include('buttons.new', ['route' => route('users.create')])
						@include('buttons.minimize')
					</div>
				</div>
				<div class="card-body">
					<table class="table table-hover table-striped dt-responsive datatable">
						<thead>
							<tr class="text-center">
								<th class="col-md-3">Usuario</th>
								<th class="col-md-7">Unidad / Departamento</th>
								<th class="col-md-2">Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach (App\User::all() as $user)
								<tr>
									<td>{{ $user->username }}</td>
									<td></td>
									<td class="text-center">
										{!! Form::button('<i class="fa fa-info-circle"></i>', [
	                                        'class' => 'btn btn-info btn-xs btn-icon btn-action',
	                                        'data-toggle' => 'tooltip', 'type' => 'button',
	                                        'onclick' => 'view_user_info('.$user->id.')',
	                                        'title' => 'Ver información del usuario',
	                                    ]) !!}
	                                    @include('buttons.edit', ['route' => route('users.edit', $user->id)])
	                                    @include('buttons.delete', ['route' => route('users.destroy', $user->id)])
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop
