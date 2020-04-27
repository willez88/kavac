<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'Estas credenciales no coinciden con nuestros registros. Tiene :attempts intento(s) mas.',
    //'throttle' => 'Demasiados intentos de acceso. Por favor intente nuevamente en :seconds segundos.',
    'throttle' => <<<EOT
        Demasiados intentos de acceso.
        Por medidas de seguridad su usuario ha sido bloqueado.
    EOT,
    'register' => [
        'register_title' => 'Register',
        'or_label' => 'or',
        'registerfacebook' => 'Register with facebook',
        'val_registerfacebook' => 'Sorry, your account with facebook cannot be registered because an ' .
                                  'email address is missing.',
        'register' => 'Registro',
        'firstname' => 'Nombre',
        'val_firstname' => 'Por favor ingrese su nombre',
        'lastname' => 'Apellido',
        'val_lastname' => 'Por favor ingrese su apellido',
        'email' => 'Email',
        'val_email' => 'Por favor ingrese un email valido',
        'mobilenumber' => 'Numero de Celular',
        'val_mobilenumber' => 'Por favor ingrese un numero de telefono valido',
        'password' => 'Password',
        'val_password' => 'You password is too short. Please use a password with at least 6 characters.',
        'retypepassword' => 'Retype password',
        'val_retypeppassword' => 'The passwords do not match',
        'btn_register' => 'S\' Inscrire',
        'login_registration' => 'You have an account?',
        'login' => 'Login'
    ],
    'login' => [
        'login_title' => 'Login',
        'login' => 'Login',
        'facebooklogin' => 'Facebook Login',
        'val_facebooklogin' => 'Sorry, your account with facebook cannot be registered because an ' .
                               'email address is missing.',
        'or_label' => 'or',
        'username' => 'Username',
        'val_username' => 'The user name you entered is wrong or does not exist',
        'password' => 'Password',
        'val_password' => 'The password you entered is incorrect',
        'forgot' => 'Forgot?',
        'noaccount' => 'Don\'t have an account?',
        'signup' => 'Signup here'
    ],
    'forgotpass' => [
        'title' => 'Request new password',
        'email' => 'Email',
        'val_email' => 'Please enter a valid email address.',
        'submit' => 'Sumit',
        'account' => 'You have an account?',
        'login' => 'Login'
    ],
    'user' => [
        'profile' => 'Mi Perfil',
        'address' => 'Mis direcciones',
        'reorder' => 'Mis ordenes',
        'login' => 'Ingresar',
        'logout' => 'Salir'
    ]
];
