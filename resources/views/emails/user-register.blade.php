@component('mail::message')
<h1>{{ __('Bienvenido a :app', ['app' => $appName]) }}</h1>

<p>{{ __('Se ha registrado un usuario en la plataforma con las siguientes credenciales de acceso') }}:</p>

<ul>
    <li class="checkmark">{{ __('Usuario') }}: {{ $user->username }}</li>
    <li class="checkmark">{{ __('Contraseña') }}: {{ $password }}</li>
</ul>

<p>{{ __('Para acceder visite la URL :url e indique sus credenciales de acceso.', ['url' => $appUrl]) }}</p>

<p>{{ __('Se le ha asignado los siguientes roles') }}:</p>

<ul>
    @foreach ($user->getRoles() as $role)
        <li class="checkmark">{{ $role->name }}</li>
    @endforeach
</ul>

<p>{{ __('y se le han otorgado los siguientes permisos de acceso') }}:</p>

<ul>
    @foreach ($user->getPermissions() as $permission)
        @if (!empty($permission->name))
            <li class="checkmark">{{ $permission->name}}</li>
        @endif
    @endforeach
</ul>

<p>
    <strong>{{ __('NOTA') }}:</strong> {{ __('Una vez acceda al sistema, se recomienda modificar la contraseña generada') }}.
</p>

<p>{{ __('Este correo es enviado de manera automática por la aplicación :app', ['app' => $appName]) }}.</p>
@endcomponent
