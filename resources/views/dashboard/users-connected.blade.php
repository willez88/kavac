<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">
                    {{ __('Acceso a la Aplicación') }}
                    @include('buttons.help', [
                        'helpId' => 'connectedUsers',
                        'helpSteps' => get_json_resource('ui-guides/connected_users.json')
                    ])
                </h6>
				<div class="card-btns">
                    @include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
                <div id="helpConnectedLeyend">
    				<div class="row" id="helpConnectedUser">
    					<div class="col-md-4 panel-legend">
    						<i class="fa fa-user text-success" data-toggle="tooltip"
                               title="{{ __('Los usuarios con este estatus se encuentran conectados a la aplicación') }}"></i>
    						<span>{{ __('Conectados') }}</span>
    					</div>
    				</div>
    				<div class="row mg-bottom-20" id="helpDisconneted">
    					<div class="col-md-4 panel-legend">
    						<i class="fa fa-user text-danger" data-toggle="tooltip"
                               title="{{ __('Los usuarios con este estatus no están conectados a la aplicación') }}"></i>
    						<span>{{ __('Desconectados') }}</span>
    					</div>
    				</div>
                </div>
                <send-messages></send-messages>
                <send-notifications></send-notifications>
                <user-settings></user-settings>
				<table class="table table-hover table-striped dt-responsive nowrap datatable" id="helpConnectedUserList">
					<thead>
						<tr class="text-center">
							<th id="helpTHUser">{{ __('Usuario') }}</th>
							<th id="helpTHName">{{ __('Nombre') }}</th>
							<th id="helpTHIP">{{ __('IP') }}</th>
							<th id="helpTHStatus">{{ __('Estatus') }}</th>
							<th id="helpTHLastAccess">{{ __('Última Conexión') }}</th>
							<th id="helpTHAction">{{ __('Acción') }}</th>
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
                                    @if($user->blocked_at)
                                    	{!! Form::button('<i class="fa fa-unlock"></i>', [
                                    		'class' => 'btn btn-success btn-xs btn-icon btn-action',
                                    		'data-toggle' => 'tooltip',
                                    		'title' => __('Desbloquear usuario'),
                                            'onclick' => 'unlockUser('.$user->id.')'
                                        ]) !!}
                                    @endif
                                    {!! Form::button('<i class="fa fa-comment"></i>', [
                                        'class' => 'btn btn-default btn-xs btn-icon btn-action',
                                        'data-toggle' => 'modal', 'data-target' => '#modalSendMessage',
                                        'title' => __('Enviar mensaje al usuario'),
                                        'onclick' => "setUserModalMessage(".$user->id.")",
                                        'disabled' => (auth()->user()->id === $user->id)
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-cogs"></i>', [
                                        'class' => 'btn btn-primary btn-xs btn-icon btn-action',
                                        'data-toggle' => 'modal', 'data-target' => '#modalUserSettings',
                                        'onclick' => 'setUser('.$user->id.')',
                                        'title' => __('Configurar cuenta de usuario'),
                                        'disabled' => (auth()->user()->id === $user->id)
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-bell"></i>', [
                                        'class' => 'btn btn-danger btn-xs btn-icon btn-action',
                                        'data-toggle' => 'modal', 'data-target' => '#modalSendNotification',
                                        'title' => __('Enviar notificación de proceso'),
                                        'onclick' => "setUserModalNotify(".$user->id.")",
                                        'disabled' => (auth()->user()->id === $user->id)
                                    ]) !!}
                                	{!! Form::button('<i class="fa fa-info-circle"></i>', [
                                        'class' => 'btn btn-info btn-xs btn-icon btn-action',
                                        'data-toggle' => 'tooltip',
                                        'onclick' => 'view_user_info('.$user->id.')',
                                        'title' => __('Ver información del usuario'),
                                        'disabled' => (auth()->user()->id === $user->id)
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