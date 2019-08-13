<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Acceso a la Aplicación</h6>
				<div class="card-btns">
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-4 panel-legend">
						<i class="fa fa-user text-success" title="Los usuarios con este estatus se encuentran conectados a la aplicación" data-toggle="tooltip"></i>
						<span>conectados</span>
					</div>
				</div>
				<div class="row mg-bottom-20">
					<div class="col-md-4 panel-legend">
						<i class="fa fa-user text-danger" title="Los usuarios con este estatus no están  conectados a la aplicación" data-toggle="tooltip"></i>
						<span>desconectados</span>
					</div>
				</div>
				<table class="table table-hover table-striped dt-responsive nowrap datatable">
					<thead>
						<tr class="text-center">
							<th>Usuario</th>
							<th>Nombre</th>
							<th>IP</th>
							<th>Estatus</th>
							<th>Última Conexión</th>
							<th>Acción</th>
						</tr>
					</thead>
					<tbody>
						@foreach(App\User::all() as $user)
							@php
	                            $user_session = App\Models\Session::getSessionData($user->id);
	                        @endphp
							<tr>
								<td class="">
									@if ($user->id !== auth()->user()->id)
										<a href="{{ route('users.edit', $user->id) }}">
											{{ $user->username }}
										</a>
									@else
										{{ $user->username }}
									@endif
								</td>
								<td class="">
									@if($user->employee_id)
	                                    {!! $user->employee->first_name. " " .$user->employee->last_name !!}
	                                @else
	                                    {{ $user->name }}
	                                @endif
								</td>
								<td class="text-center">
									@if(isset($user_session) && !is_null($user_session))
	                                    {{ $user_session->ip_address }}
	                                @else
	                                    N/A
	                                @endif
								</td>
								<td class="text-center">
									<i class="fa fa-user @if(isset($user_session) && !is_null($user_session)) text-success @else text-danger @endif"></i>
								</td>
								<td class="text-center">
									@if($user->last_login)
	                                    {{ $user->last_login->format('d/m/Y h:i:s A') }}
	                                @else
	                                    Nunca
	                                @endif
								</td>
								<td class="text-center" width="10%">
                                    @if($user->lock_screen)
                                    	{!! Form::button('<i class="fa fa-unlock"></i>', [
                                    		'class' => 'btn btn-success btn-xs btn-icon btn-action',
                                    		'data-toggle' => 'tooltip',
                                    		'title' => 'Bloquear pantalla de aplicación',
                                            'onclick' => '#'
                                        ]) !!}
                                    @endif
                                    {!! Form::button('<i class="fa fa-comment"></i>', [
                                        'class' => 'btn btn-default btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip', 'onclick' => '#',
                                        'title' => 'Enviar mensaje al usuario',
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-cogs"></i>', [
                                        'class' => 'btn btn-primary btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip', 'onclick' => '#',
                                        'title' => 'Configurar cuenta de usuario',
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-bell"></i>', [
                                        'class' => 'btn btn-danger btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip', 'onclick' => '#',
                                        'title' => 'Enviar notificación de proceso',
                                    ]) !!}
                                	{!! Form::button('<i class="fa fa-info-circle"></i>', [
                                        'class' => 'btn btn-info btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip',
                                        'onclick' => 'view_user_info('.$user->id.')',
                                        'title' => 'Ver información del usuario',
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-filter"></i>', [
                                        'class' => 'btn btn-warning btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip',
                                        'onclick' => 'location="' . route('assign.access', [
                                        	'user' => $user->id
                                        ]) . '"',
                                        'title' => 'Asignar permisos de acceso.',
                                        'disabled' => (auth()->user()->id === $user->id)
                                    ]) !!}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
