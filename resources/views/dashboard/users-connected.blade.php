<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">{{ __('Acceso a la Aplicación') }}</h6>
				<div class="card-btns">
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-4 panel-legend">
						<i class="fa fa-user text-success" data-toggle="tooltip"
                           title="{{ __('Los usuarios con este estatus se encuentran conectados a la aplicación') }}"></i>
						<span>{{ __('conectados') }}</span>
					</div>
				</div>
				<div class="row mg-bottom-20">
					<div class="col-md-4 panel-legend">
						<i class="fa fa-user text-danger" data-toggle="tooltip"
                           title="{{ __('Los usuarios con este estatus no están conectados a la aplicación') }}"></i>
						<span>{{ __('desconectados') }}</span>
					</div>
				</div>
				<table class="table table-hover table-striped dt-responsive nowrap datatable">
					<thead>
						<tr class="text-center">
							<th>{{ __('Usuario') }}</th>
							<th>{{ __('Nombre') }}</th>
							<th>{{ __('IP') }}</th>
							<th>{{ __('Estatus') }}</th>
							<th>{{ __('Última Conexión') }}</th>
							<th>{{ __('Acción') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach(App\Models\User::all() as $user)
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
                                    		'title' => __('Bloquear pantalla de aplicación'),
                                            'onclick' => 'javascript::void(0)'
                                        ]) !!}
                                    @endif
                                    {!! Form::button('<i class="fa fa-comment"></i>', [
                                        'class' => 'btn btn-default btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip', 'onclick' => 'javascript:void(0)',
                                        'title' => __('Enviar mensaje al usuario'),
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-cogs"></i>', [
                                        'class' => 'btn btn-primary btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip', 'onclick' => 'javascript:void(0)',
                                        'title' => __('Configurar cuenta de usuario'),
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-bell"></i>', [
                                        'class' => 'btn btn-danger btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip', 'onclick' => 'javascript:void(0)',
                                        'title' => __('Enviar notificación de proceso'),
                                    ]) !!}
                                	{!! Form::button('<i class="fa fa-info-circle"></i>', [
                                        'class' => 'btn btn-info btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip',
                                        'onclick' => 'view_user_info('.$user->id.')',
                                        'title' => __('Ver información del usuario'),
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-filter"></i>', [
                                        'class' => 'btn btn-warning btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip',
                                        'onclick' => 'location="' . route('assign.access', [
                                        	'user' => $user->id
                                        ]) . '"',
                                        'title' => __('Asignar permisos de acceso.'),
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
