<h1>Bienvenido a {{ $appName }}</h1>

<p>Se ha registrado un usuario en la plataforma con las siguientes credenciales de acceso:</p>

<ul>
    <li>Usuario: {{ $user->username }}</li>
    <li>Contraseña: {{ $password }}</li>
</ul>

<p>Para acceder visite la URL {{ $appUrl }} e indique sus credenciales de acceso.</p>

<p>Se le ha asignado los siguientes roles:</p>

<ul>
    @foreach ($user->getRoles() as $role)
        <li>{{ $role->name }}</li>
    @endforeach
</ul>

<p>y se le han otorgado los siguientes permisos de acceso:</p>

<ul>
    @foreach ($user->getPermissions() as $permission)
        <li>{{ $permission->name}}</li>
    @endforeach
</ul>

<p><strong>NOTA:</strong> Una vez acceda al sistema, se recomienda modificar la contraseña generada.</p>

<p>Este correo es enviado de manera automática por la aplicación {{ $appName }}.</p>
