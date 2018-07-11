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
	Tipo de Personal
@stop

@section('content')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Tipos de Personal</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						   data-toggle="tooltip">
							<i class="now-ui-icons arrows-1_minimal-up"></i>
						</a>
					</div>
				</div>
				{{-- {!! Form::open($header) !!} --}}
					<div class="card-body">
						@php
							$roles = Ultraware\Roles\Models\Role::all();
							$permissions = Ultraware\Roles\Models\Permission::all();
							$module = "";
						@endphp
						<table class="table table-hover table-striped dt-responsive">
							<thead>
								<tr>
									<th>ROLES</th>
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
											<th>PERMISOS</th>
											<th class="text-center" colspan="{{ count($roles) }}">
												MÓDULO: {{ strtoupper($module) }}
											</th>
										</tr>
									@endif
									@if ($perm->slug_alt)
										<tr>
											<td title="{{ $perm->description }}" data-toggle="tooltip">
												{{ $perm->slug_alt }}
											</td>
											@foreach ($roles as $role)
												<td class="text-center">
													{!! Form::checkbox(
														'perm[]', $role->id . ":" . $perm->id, null, [
															'class' => 'form-control bootstrap-switch',
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
				{{-- {!! Form::close() !!} --}}
			</div>
		</div>
	</div>
@stop
