# KAVAC | Sistema de Gestión Administrativa

## Sobre la aplicación

Kavac es una aplicación para la gestión administrativa de entes públicos, permite registrar y controlar todos los procesos de la formulación y ejecución de presupuesto institucional, así como toda la información relevante de operatividad. Este proyecto surge como iniciativa en la mejora de los procesos administrativos apuntando al uso de nuevas tecnologías.
Se encuentra desarrollado bajo patrones de diseño MVC con un esquema agradable y comprensible usando el framework Laravel y una documentación extensa tanto para desarrolladores o personal técnico, así como también para usuarios del sistema.
Provee de la mayoría de las herramientas requeridas para una correcta gestión de los recursos institucionales y de los procesos inherentes a estos.

## Antecedentes

Mencionar al SAID y sus distintos enlaces

- [enlace 1](http://enlace1).
- [enlace 2](http://enlace2).
- [enlace 3](http://enlace3).

## Pre-requisitos

Requerimientos previos para la instalación

## Instalación

Para poder ejectutar la instalación es importante contar con el paquete [composer](https://getcomposer.org/) el cual permite gestionar las distintas dependencias y/o paquetes requeridos por el sistema y una conexión externa a Internet. Cabe destacar que para mejores resultados, se debe tener instalado composer de manera global.

Abrir un terminal o consola y posicionarse en la ruta base del proyecto "/", luego ejecuta la siguiente instrucción:

	composer install
	
Una vez instalada la aplicación, ejecuta el comando:

	php artisan key:generate

Esto generará un identificador único para la aplicación y creará (si no existe), el archivo de configuración .env

En el archivo .env, localizado en la raíz del sistema, se deben establecer los parámetros de configuración necesarios bajo los cuales se ejecutará la aplicación.

> APP_NAME
> APP_ENV
> APP_KEY
> APP_DEBUG
> APP_LOG_LEVEL
> APP_URL
> 
> DB_CONNECTION
> DB_HOST
> DB_PORT
> DB_DATABASE
> DB_USERNAME
> DB_PASSWORD
>
> BROADCAST_DRIVER
> CACHE_DRIVER
> SESSION_DRIVER
> QUEUE_DRIVER
> 
> REDIS_HOST
> REDIS_PASSWORD
> REDIS_PORT
> 
> MAIL_DRIVER
> MAIL_HOST
> MAIL_PORT
> MAIL_USERNAME
> MAIL_PASSWORD
> MAIL_ENCRYPTION
> 
> PUSHER_APP_ID
> PUSHER_APP_KEY
> PUSHER_APP_SECRET
> PUSHER_APP_CLUSTER

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for helping fund on-going Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell):

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[British Software Development](https://www.britishsoftware.co)**
- [Fragrantica](https://www.fragrantica.com)
- [SOFTonSOFA](https://softonsofa.com/)
- [User10](https://user10.com)
- [Soumettre.fr](https://soumettre.fr/)
- [CodeBrisk](https://codebrisk.com)
- [1Forge](https://1forge.com)
- [TECPRESSO](https://tecpresso.co.jp/)
- [Pulse Storm](http://www.pulsestorm.net/)
- [Runtime Converter](http://runtimeconverter.com/)
- [WebL'Agence](https://weblagence.com/)

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## Licencia

Kavac es una aplicación de código abierto y se distribuye estrictamente bajo la licencia [MIT license](https://opensource.org/licenses/MIT).
