<h1>Bienvenido a {{ $appName }}</h1>

<p>
    Se ha registrado un usuario en la plataforma con las siguientes credenciales de acceso:

    <ul>
        <li>Usuario: {{ $usuario }}</li>
        <li>Contraseña: {{ $password }}</li>
    </ul>
</p>

<p>Para acceder visite la URL: {{ $appUrl }}</p>

<p>
    Una vez acceda al sistema, se recomienda modificar la contraseña generada
</p>
