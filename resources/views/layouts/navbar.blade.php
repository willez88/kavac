{{-- Barra de Navegación Superior --}}
<nav class="navbar navbar-expand-lg bg-info fixed-top">
	{{-- <div>
		<img src="{{ App\Models\Institution::where('default', true)->first()->banner->url }}" alt="">
	</div> --}}
	<div class="container-left">
		<a href="{{ route('index') }}" class="logo">
            <img src="{{ asset('images/logo-white.png') }}" alt="" />
            <img src="{{ asset('images/app-name-white.png') }}" alt="" />
        </a>
        <div class="float-right">
            <div class="menu-collapse" data-toggle="tooltip" data-placement="right" title="Minimizar panel de menú">
                <i class="now-ui-icons arrows-1_minimal-left"></i>
            </div>
        </div>
	</div>
	<button class="navbar-toggler navbar-toggler-right" type="button"
				data-toggle="collapse" data-target="#app-navbar-info"
				aria-controls="navbarSupportedContent" aria-expanded="false"
				aria-label="Toggle navigation">
			<i class="fa fa-navicon" style="position:relative;top:-5px;"></i>
		</button>
	<div class="container">
		<div class="navbar-translate">
			@php
				$institution = App\Models\Institution::where('active', true)
													 ->where('default', true)->first();
			@endphp
			@if ($institution)
				<div class="navbar-brand">
					@if ($institution->has('logo'))
						<img src="{{ $institution->logo->url }}" alt="logo" class="img-fluid">
					@endif
					{!! $institution->acronym !!} | {!! $institution->name !!}
				</div>
			@endif
		</div>
		<div class="collapse navbar-collapse justify-content-end"
			 id="app-navbar-info" data-nav-image="{{ asset('images/blurred-image.jpg') }}">

			<ul class="navbar-nav">
				@if (App\Models\Parameter::where([
					'active' => true, 'required_by' => 'core', 'p_key' => 'notify', 'p_value' => 'true'
				])->first())
					<li class="nav-item">
						<a class="nav-link btn btn-sm btn-info" href="#" title="Notificaciones del sistema" data-toggle="tooltip">
							<i class="now-ui-icons ui-1_bell-53"></i>
							<!-- Mensajes de notificaciones del sistema -->
							<span class="badge badge-primary badge-notify">2</span>
						</a>
					</li>
				@endif
				<li class="nav-item">
					<a class="nav-link btn btn-sm btn-info" href="#" title="Mensajes de procesos o usuarios" data-toggle="tooltip">
						<i class="now-ui-icons ui-1_email-85"></i>
						<!-- Mensajes de Notificación de procesos o usuarios -->
						<span class="badge badge-primary badge-notify">2</span>
					</a>
				</li>
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle btn btn-sm btn-info" id="list_options_language"
					   data-toggle="dropdown" aria-expanded="false" title="Idioma">
					   	<i class="fa fa-flag-o" aria-hidden="true"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right"
						 aria-labelledby="list_options_language">
						<a class="dropdown-header">IDIOMAS</a>
						<a class="dropdown-item" href="#" title="Español"
						   data-toggle="tooltip">Español</a>
						<a class="dropdown-item" href="#" title="Inglés"
						   data-toggle="tooltip">Inglés</a>
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
						<a class="nav-link btn btn-sm btn-info" href="#" title="chat" data-toggle="tooltip">
							<i class="now-ui-icons ui-2_chat-round"></i>
						</a>
					</li>
				@endif
				@if (App\Models\Parameter::where([
		            'active' => true, 'required_by' => 'core',
		            'p_key' => 'support', 'p_value' => 'true'
		        ])->first())
					<li class="nav-item">
						<a class="nav-link btn btn-sm btn-info" href="#" title="Contacte con soporte técnico" data-toggle="tooltip">
							<i class="now-ui-icons objects_support-17"></i>
						</a>
					</li>
				@endif
				@if(Auth::user()->hasRole('admin'))
					<li class="nav-item">
						<a class="nav-link btn btn-sm btn-info"
						   href="{{ route('backup.index') }}"
						   title="Respaldos de Base de Datos"
						   data-toggle="tooltip">
							<i class="fa fa-database"></i>
						</a>
					</li>
				@endif
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle btn btn-sm btn-info" id="list_options_user"
					   data-toggle="dropdown" aria-expanded="false" title="Mi configuración y datos">
					   	<i class="now-ui-icons users_single-02" aria-hidden="true"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right"
						 aria-labelledby="list_options_user">
						<a class="dropdown-header">USUARIO</a>
						<a class="dropdown-item" href="#" title="Establecer configuración personalizada"
						   data-toggle="tooltip" data-placement="left">
							<i class="ion-gear-a"></i>Configurar Cuenta</a>
						<a class="dropdown-item" href="{{ url('users') . "/" . Auth::user()->id }}"
						   title="Actualizar datos de perfil del usuario"
						   data-toggle="tooltip" data-placement="left">
							<i class="ion-person"></i>Mi Perfil</a>
						<a class="dropdown-item" href="{{ url('users') . "/" . Auth::user()->id }}#activity" title="Ver actividad en la aplicación"
						   data-toggle="tooltip" data-placement="left">
							<i class="ion-ios-star"></i>Registro de Actividad</a>
						<a class="dropdown-item" href="#" title="Bloquear pantalla de la aplicación"
						   data-toggle="tooltip" data-placement="left">
							<i class="ion-android-lock"></i>Bloquear Pantalla</a>
						<a class="dropdown-item" href="#" title="Ayuda / Manual de usuario"
						   data-toggle="tooltip" data-placement="left">
							<i class="ion-help-circled"></i>Ayuda</a>
						<div class="divider"></div>
						<a href=""
                                                >
                                                Logout
                                            </a>
						<a class="dropdown-item" href="{{ route('logout') }}" title="Salir de la aplicación"
						   data-toggle="tooltip" data-placement="left"
						   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
							<i class="ion-log-out"></i>Salir
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
