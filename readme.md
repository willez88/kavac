# KAVAC | Sistema de Gestión Administrativa

## Sobre la aplicación

Kavac es una aplicación para la gestión administrativa de entes públicos, permite registrar y controlar todos los procesos de la formulación y ejecución de presupuesto institucional, así como toda la información relevante de operatividad. Este proyecto surge como iniciativa en la mejora de los procesos administrativos apuntando al uso de nuevas tecnologías.
Se encuentra desarrollado bajo patrones de diseño MVC con un esquema agradable y comprensible usando el framework Laravel y una documentación extensa tanto para desarrolladores o personal técnico, así como también para usuarios del sistema.
Provee de la mayoría de las herramientas requeridas para una correcta gestión de los recursos institucionales y de los procesos inherentes a estos.

## Antecedentes

Esta aplicación cuenta con funcionalidades y mejoras con respecto a otras herramientas de las cuales se tomaron en consideración algunos de sus procesos, implementando nuevos parádigmas de desarrollo acordes a las tendencias tecnológicas del momento.

Como antecedentes de esta aplicación se considera como precursor a:

- [SAID - Sistema Administrativo Integrado Descentralizado](http://said.cenditel.gob.ve/wiki).

## Pre-requisitos

A continuación se listan los paquetes previos requeridos para la instalación y correcto funcionamiento de la aplicación

	* php >= 7.2.x
	* php-gd
	* php-mbstring
	* php-tokenizer
	* php-zip
	* composer
	* zip
	* unzip
	* nodejs
	* postgresql

## Instalación

Para poder ejectutar la instalación es importante contar con el paquete [composer](https://getcomposer.org/) el cual permite gestionar las distintas dependencias y/o paquetes requeridos por el sistema y una conexión externa a Internet. Cabe destacar que para mejores resultados, se debe tener instalado composer de manera global.

Por otro lado, se requiere contar con el paquete NodeJS para gestionar los paquetes requeridos para la reactividad en la gestión de datos de algunos procesos, para lo cual se requiere seguir la documentación de [nodejs](https://nodejs.org/) para el sistema operativo en el que se vaya a ejecutar la aplicación.

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

De igual manera se debe instalar los paquetes necesarios para la gestión reactiva de datos, para lo cual se debe ejecutar el siguiente comando (teniendo en cuenta que se debe contar con nodejs y npm previamente instalados):

	npm install

El comando anterior instala todas las dependencias de node requeridas por el sistema.

## Base de Datos

El Sistema Administrativo KAVAC puede ser ejecutado con diferentes gestores de Base de Datos tales como PostgreSQL, MySQL, SQLite, entre otros, sin embargo se recomienda el uso del gestor de Base de Datos PostgreSQL por su capacidad en la gestión de información.

Debe crear una base de datos en el gestor de su preferencia y configurarlo en el archivo .env con los datos de acceso. Ej:

> DB_CONNECTION=pgsql
> DB_HOST=localhost
> DB_PORT=5432
> DB_DATABASE=kavac
> DB_USERNAME=kavac
> DB_PASSWORD=kavac

Una vez configurado el gestor de base de datos, se deben ejecutar los siguientes comandos:

	php artisan migrate

Lo anterior creará la estructura de tablas de la base de datos necesaria para comenzar a gestionar la información.

## Registros Iniciales

KAVAC, cuenta con información inicial requerida para la gestión de la aplicación, para lo cual se debe ejecutar el comando:

	php artisan db:seed

El anterior comando ejecutara las acciones necesarias para ingresar al sistema los datos inicialmente requeridos por la aplicación base como son: usuario, roles, permisos, localidades, estados civiles, profesiones, sectores de instituciones y tipos de instituciones.

La aplicación cuenta con una cantidad de módulos independientes que permiten expandir sus funcionalidades, cada uno de estos módulos cuentan con sus registros iniciales por lo que es necesario ejecutar un comando adicional que permita registrar información de cada módulo instalado y habilitado en el sistema, para ello se ejecuta el siguiente comando:

	php artisan module:seed

Esto revisará que módulos del sistema estan habilitados y procederá a registrar la información requerida, inicialmente, por cada uno de ellos.

Una vez que hayan sido registrado los datos iniciales del sistema, se puede autenticar en el mismo con los siguientes datos de acceso como administrador (es recomendable modificar la contraseña en el primer acceso al sistema):

	usuario: admin
	clave: 123456

El primer paso, para el correcto funcionamiento del sistema, es registrar información básica de la institución que llevará a cabo la gestión de información dentro de la aplicación, para ello se debe ingresar al menú

	Configuración > General

Y allí, en el panel "CONFIGURAR INSTITUCIÓN" se deben indicar los datos de la Institución, una vez configurada la institución se mostrarán todas las opciones de los módulos disponibles en el sistema

## Documentación

La aplicación cuenta con una amplia documentación técnica y para usuarios del sistema, las cuales se encuentran bajo las siguientes rutas:

- [Técnica]()
- [Usuario]()


## Licencia

Kavac es una aplicación de código abierto y se distribuye estrictamente bajo la licencia [MIT license](https://opensource.org/licenses/MIT).

## Comandos básicos laravel-modules

Ejecutar las migraciones laravel-modules

	php artisan module:migrate

Crea un nuevo modelo para el módulo especificado junto con su migración

	php artisan module:make-model -m ModuleNameModelName ModuleName

Genera nuevo controlador restful para el módulo especificado

	php artisan module:make-controller ModuleNameModelName ModuleName

Genera nuevo seeder para el módulo especificado (nombre del modelo en plural)

	php artisan module:make-seed ModuleNameModelName ModuleName