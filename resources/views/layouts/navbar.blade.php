{{-- Barra de Navegación Superior --}}
<nav class="navbar navbar-expand-lg bg-info fixed-top" id="app-nav">
	{{-- <div>
		<img src="{{ App\Models\Institution::where('default', true)->first()->banner->url }}" alt="">
	</div> --}}
	<div class="container-left">
		<a href="{{ route('index') }}" class="logo">
            <img src="{{ asset('images/logo-white.png') }}" alt="{{ __('Logo') }}" />
            <img src="{{ asset('images/app-name-white.png') }}" alt="{{ __('Logo') }}" />
        </a>
        <div class="float-right">
            <div class="menu-collapse" data-toggle="tooltip" data-placement="right" title="{{ __('Minimizar panel de menú') }}">
                <i class="now-ui-icons arrows-1_minimal-left"></i>
            </div>
        </div>
	</div>
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
			data-target="#app-navbar-info" aria-controls="navbarSupportedContent" aria-expanded="false"
			aria-label="Toggle navigation">
		<i class="fa fa-navicon" style="position:relative;top:-5px;"></i>
	</button>
	<div class="container">
		<div class="navbar-translate">
			@php
				$institution = App\Models\Institution::where(['active' => true, 'default' => true])->first();
			@endphp
			@if ($institution)
				<div class="navbar-brand">
					@if ($institution->logo()->exists())
						<img src="{{ asset($institution->logo->url, Request::secure()) }}" alt="{{ __('logo') }}"
                             class="img-fluid">
					@endif
					{!! $institution->acronym !!} | {!! $institution->name !!}
				</div>
			@endif
		</div>
		<div class="collapse navbar-collapse justify-content-end"
			 id="app-navbar-info" data-nav-image="{{ asset('images/blurred-image.jpg') }}">

			<ul class="navbar-nav">
				@if (Auth::user()->hasVerifiedEmail())
					@if (App\Models\Parameter::where([
						'active' => true, 'required_by' => 'core', 'p_key' => 'notify', 'p_value' => 'true'
					])->first())
                        <notifications></notifications>
					@endif

					<li class="nav-item dropdown dropdown-notify">
						<a href="#" class="nav-link dropdown-toggle btn btn-sm btn-info btn-notify" data-toggle="dropdown"
						   aria-expanded="false" title="{{ __('Mensajes') }}" id="list_messages">
						   	<i class="now-ui-icons ui-1_email-85"></i>
							<!-- Mensajes de Notificación de procesos o usuarios -->
							<span class="badge badge-primary badge-notify">2</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="list_messages">
							<a class="dropdown-header text-center">{{ __('Mensajes nuevos') }}</a>
							<div class="dropdown-item">
								<ul class="media-list msg-list">
		                            <li class="media unread">
		                                <div class="media-body">
		                                    <div class="float-right media-option">
		                                        <i class="fa fa-paperclip mr5"></i>
		                                        <small>Ayer 5:51am</small>
		                                    </div>
		                                    <h4 class="sender">Nombre persona</h4>
		                                    <p>
		                                        <strong class="subject">Asunto!</strong> Descripción breve del mensaje (max 50 carácteres)...
		                                    </p>
		                                </div>
		                            </li>
		                            <li class="media unread">
		                                <div class="media-body">
		                                    <div class="float-right media-option">
		                                        <i class="fa fa-paperclip mr5"></i>
		                                        <small>Ayer 5:51am</small>
		                                    </div>
		                                    <h4 class="sender">Nombre persona</h4>
		                                    <p>
		                                        <strong class="subject">Asunto!</strong> Descripción breve del mensaje (max 50 carácteres)...
		                                    </p>
		                                </div>
		                            </li>
		                        </ul>
							</div>
							<a class="dropdown-item dropdown-footer text-center"
							   href="{{ url('users/' . auth()->user()->id . '#messages') }}"
							   title="{{ __('Ver todos los mensajes') }}" data-toggle="tooltip" data-placement="left">
								{{ __('Ver todos los mensajes') }}
							</a>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a href="#" class="nav-link dropdown-toggle btn btn-sm btn-info" id="list_options_language"
						   data-toggle="dropdown" aria-expanded="false" title="{{ __('Idioma') }}">
						   	<i class="fa fa-flag-o" aria-hidden="true"></i>
						</a>
						<div class="dropdown-menu dropdown-menu-right"
							 aria-labelledby="list_options_language">
							<a class="dropdown-header">{{ __('IDIOMAS') }}</a>
							<a class="dropdown-item" href="#" title="{{ __('Español') }}"
							   data-toggle="tooltip">{{ __('Español') }}</a>
							<a class="dropdown-item" href="#" title="{{ __('Inglés') }}"
							   data-toggle="tooltip">{{ __('Inglés') }}</a>
						</div>
					</li>
					{{-- <li class="nav-item">
						<a class="nav-link btn btn-sm btn-info" href="#"
						   title="Configuración del Sistema, solo administradores"
						   data-toggle="tooltip">
							<i class="now-ui-icons ui-2_settings-90"></i>
						</a>
					</li> --}}
					@if (App\Models\Parameter::where([
			            'active' => true, 'required_by' => 'core',
			            'p_key' => 'chat', 'p_value' => 'true'
			        ])->first())
						<li class="nav-item">
							<a class="nav-link btn btn-sm btn-info" href="javascript:void(0)" title="{{ __('chat') }}"
                               data-toggle="tooltip">
								<i class="now-ui-icons ui-2_chat-round"></i>
							</a>
						</li>
					@endif
					@if (App\Models\Parameter::where([
			            'active' => true, 'required_by' => 'core',
			            'p_key' => 'support', 'p_value' => 'true'
			        ])->first())
						<li class="nav-item">
							<a class="nav-link btn btn-sm btn-info" href="javascript:void(0)"
                               title="{{ __('Contacte con soporte técnico') }}" data-toggle="tooltip">
								<i class="now-ui-icons objects_support-17"></i>
							</a>
						</li>
					@endif
					@if(Auth::user()->hasRole('admin'))
						<li class="nav-item">
							<a class="nav-link btn btn-sm btn-info"
							   href="{{ route('backup.index') }}"
							   title="{{ __('Respaldos de Base de Datos') }}"
							   data-toggle="tooltip">
								<i class="fa fa-database"></i>
							</a>
						</li>
					@endif
				@endif
				<li class="nav-item dropdown">
					<a href="javascript:void(0)" class="nav-link dropdown-toggle btn btn-sm btn-info"
                       id="list_options_user" data-toggle="dropdown" aria-expanded="false"
                       title="{{ __('Mi configuración y datos') }}">
					   	<i class="now-ui-icons users_single-02" aria-hidden="true"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right"
						 aria-labelledby="list_options_user">
						<a class="dropdown-header">{{ __('USUARIO') }}</a>
						@if (Auth::user()->hasVerifiedEmail())
							<a class="dropdown-item" href="javascript:void(0)" data-toggle="tooltip" data-placement="left"
                               title="{{ __('Establecer configuración personalizada') }}">
								<i class="ion-gear-a"></i>{{ __('Configurar Cuenta') }}</a>
							<a class="dropdown-item" href="{{ url('users') . "/" . Auth::user()->id }}"
							   title="{{ __('Actualizar datos de perfil del usuario') }}"
							   data-toggle="tooltip" data-placement="left">
								<i class="ion-person"></i>{{ __('Mi Perfil') }}</a>
							<a class="dropdown-item" href="{{ url('users') . "/" . Auth::user()->id }}#activity"
                               title="{{ __('Ver actividad en la aplicación') }}" data-toggle="tooltip"
                               data-placement="left">
								<i class="ion-ios-star"></i>{{ __('Registro de Actividad') }}</a>
							<a class="dropdown-item" href="javascript:void(0)"
                               title="{{ __('Bloquear pantalla de la aplicación') }}" data-toggle="tooltip"
                               data-placement="left">
								<i class="ion-android-lock"></i>{{ __('Bloquear Pantalla') }}</a>
							<a class="dropdown-item" href="javascript:void(0)"
                               title="{{ __('Ayuda') }} / {{ __('Manual de usuario') }}" data-toggle="tooltip"
                               data-placement="left">
								<i class="ion-help-circled"></i>{{ __('Ayuda') }}</a>
							<div class="divider"></div>
						@endif
						<a class="dropdown-item" href="{{ route('logout') }}" title="{{ __('Salir de la aplicación') }}"
						   data-toggle="tooltip" data-placement="left"
						   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
							<i class="ion-log-out"></i> {{ __('Salir') }}
						</a>
						<form id="logout-form" action="{{ route('logout') }}" method="POST"
							  style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>
