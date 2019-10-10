# Bienvenidos al Manual de Documentación Kavac. 

For full documentation visit [mkdocs.org](https://mkdocs.org).

## Commands

* `mkdocs new [dir-name]` - Create a new project.
* `mkdocs serve` - Start the live-reloading docs server.
* `mkdocs build` - Build the documentation site.
* `mkdocs help` - Print this help message.

## Project layout

    mkdocs.yml    # The configuration file.
    docs/
        index.md  # The documentation homepage.
        ...       # Other markdown pages, images and other files.
         
```
 <article class="text">
       <!-- title -->
        <hgroup>
          <h3>Instalación del sistema</h3>
        </hgroup>  
        <br>
       <!-- serie  -->
        <ul class="serie">
         <!-- Pre-requisitos -->
          <li><h4><b>Pre-requisitos.</b></h4></li><br>
            <p>A continuación se listan los paquetes previos requeridos para la instalación y correcto funcionamiento de la aplicación:</p><br>
              <ul>
                <li>PHP >= 7.2.x.</li>  	
                <li>PHP-gd.</li>
                <li>PHP-mbstring.</li>
                <li>PHP-tokenizer.</li>
                <li>PHP-zip.</li> 
                <li>PHP-pgsql.</li>
                <li>PHP-cli.</li>
                <li>PHP-curl.</li>                  
                <li>Composer.</li>                 
                <li>Zip.</li>                                                                             
                <li>Unzip.</li>                                                                             
                <li>Nodejs.</li>                                                                             
                <li>Postgresql.</li>                                                                             
                <li>Servidor de aplicaciones nginx, apache, etc.</li>       
              </ul>
              <br>
  		   <!-- /Pre-requisitos -->

         <!-- Glosario -->
          <li><h4><b>Glosario.</b></h4></li><br>
  		      <ul>
  		        <li>(ruta-absoluta-de-instalacion): Es la ruta en donde se va a instalar la aplicación, colocando la misma sin los (), por ejemplo:</li><br>
                <p>/srv/kavac/</p><br> 
              <li>(version-php-instalada): Es la versión del o los paquetes de PHP instalados, colocando la misma sin los (), por ejemplo:</li><br>
                <p>7.2 o en su defecto 7.3 </p>
	          </ul>
	          <br>
         <!-- /Glosario -->

         <!-- Configuración del servidor -->
	        <li><h4><b>Configuración del Servidor de Aplicaciones.</b></h4></li><br>
             <p>En esta documentación se explica cómo configurar un servidor de aplicaciones Nginx (para otro tipo de servidor se debe consultar la
             documentación pertinente para una configuración óptima en aplicaciones basadas en PHP).</p>
            <br>
         <!-- / -->

         <!-- Instalar Nginx -->
          <li><h4><b>Instalar Nginx.</b></h4></li><br>
  		      <ul>
  		        <li>Lo primero que se debe realizar es la instalación del servidor de aplicaciones con el comando:</li><br>
                <p>apt install nginx</p><br> 
              <li>Una vez completada la instalación, inicie el servicio nginx y agréguelo para que se inicie automáticamente con el sistema operativo mediante el comando systemctl:</li><br>
                <p>systemctl start nginx</p><br>
                <p>systemctl enable nginx</p><br>
              <li>El servidor Nginx se ejecutará en el puerto 80, para verificar si se ejecutó correctamente debe ejecutar el comando:</li><br>
                <p>netstat -plntu</p><br> 
              <li>Si todo lo muestra correctamente, nginx estará instalado y en ejecución.</li><br>
            </ul>
	          <br>
         <!-- /Instalar Nginx -->
         
         <!-- Instalar PHP-FPM -->
	        <li><h4><b>Instalar PHP-FPM.</b></h4></li><br>
  		      <ul>
  		        <li>Para instalar la extensión FPM (FastCGI Process Manager) de la versión de PHP instalada en el sistema operativo se debe ejecutar el comando:</li><br>
                <p>apt install php-fpm</p><br> 
              <li>El próximo paso es configurar el archivo php.ini de FPM, para lo cual se debe acceder a la ruta en donde fue instalado, por lo general esta ruta se encuentra en /etc/php/(version-php-instalada)/, para esto se debe editar ejecutando:</li><br>
                <p>nano/etc/php/(version-php-instalada)/php.ini , donde (version-php-instalada) es la versión de php instalada en el servidor.</p><br>             
              <li>En el contenido del archivo se debe buscar y descomentar la variable cgi.fix_pathinfo=1 y cambiar el valor a 0.</li><br>
                <p>cgi.fix_pathinfo=0</p><br> 
              <li>Guardar las modificaciones realizadas e inicializar el servicio FPM con los comandos:</li><br>
                <p>systemctl start php(version-php-instalada)-fpm</p>
                <p>systemctl enable php(version-php-instalada)-fpm</p><br>            
              <li>El primer comando inicializa el servicio y el segundo lo habilita para que se ejecute automáticamente al arrancar el servidor.</li><br>
              <li>Por defecto en sistemas operativos como Ubuntu el servicio PHP-FPM se ejecuta bajo un archivo socket, para verificar que el servicio PHP-FPM se haya inicializado correctamente deberá escribir el comando netstat de la siguiente forma:</li><br>
                <p>netstat -pl | grep php(version-php-instalada)-fpm</p><br>  
              <li>Con lo anterior, el servidor virtual para la aplicación fue creado, solo queda reiniciar el servidor nginx para que las modificaciones tengan efecto, para esto se debe ejecutar:</li><br>
                <p>systemctl restart nginx</p>
	          </ul>
	          <br>
         <!-- /Instalar PHP-FPM -->

         <!-- Configurar servidor virtual -->
	        <li><h4><b>Configurar el servidor virtual de Nginx.</b></h4></li><br>
  		      <p>Para que la aplicación se ejecute en el servidor de aplicaciones Nginx, se debe realizar una configuración adicional creando para ello un archivo que contendrá dicha configuración, para esto se ejecutará el siguiente comando:</p></li><br>
            <p> nano /etc/nginx/sites-available/kavac</p>
            <br> 
            <ul>
              <li>Se agregará el siguiente contenido:</li><br>
                <p>server {</p><br>
                  <ul class="steps">
                    <li>listen 80;</li>
                    <li># Descomentar si las peticiones solo aceptan el protocolo ipv6</li>
                    <li># listen [::]:80 ipv6only=on;</li><br>
                    <li># Log files for Debugging</li>
                    <li>access_log /var/log/nginx/kavac-access.log;</li>
                    <li>error_log /var/log/nginx/kavac-error.log;</li><br>
                    <li># Webroot Directory for kavac project</li>
                    <li>root (ruta-absoluta-de-instalacion)/public;</li>
                    <li>index index.php index.html index.htm;</li><br>
                    <li># Your Domain Name</li>
                    <li>server_name (nombre-de-dominio-que-atiende-las-peticiones);</li><br>
                    <li>location / {</li>
                      <p> try_files $uri $uri/ /index.php?$query_string;</p>
                    <li>}</li><br>
                    <li># PHP-FPM Configuration Nginx</li>
                    <li>location ~ \.php$ {</li>
                      <ul>
                        <li>try_files $uri =404;</li>
                        <li>fastcgi_split_path_info ^(.+\.php)(/.+)$;</li>
                        <li>fastcgi_pass unix:/run/php/php(version-php-instalada)-fpm.sock;</li>
                        <li>fastcgi_index index.php;</li>
                        <li>fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;</li>
                        <li>include fastcgi_params;</li>
                      </ul>
                    <li>}</li>
                   <p>Guardar las modificaciones y cierra el archivo.</p>   
                  </ul>
                <p>}</p><br>
              <li>Ahora para activar el servidor virtual se debe crear un enlace simbólico al archivo de configuración de la siguiente forma:</li><br>
                <p>ln -s /etc/nginx/sites-available/kavac /etc/nginx/sites-enabled/</p><br> 
              <li>Para que estos cambios tengan efecto se debe reiniciar el servidor de aplicaciones:</li><br>
                <p>systemctl restart nginx</p><br>  
            </ul> 
            <br>
         <!-- /Configurar servidor virtual -->

         <!-- Instalación -->
          <li><h4><b>Instalación.</b></h4></li><br>
  		        <p>	Para poder ejecutar la instalación es importante contar con el paquete [composer]<a target="_blank" href="https://getcomposer.org/">(https://getcomposer.org/)</a> el cual permite 
  		        gestionar las distintas dependencias y/o paquetes requeridos por el sistema y una conexión externa a Internet. Cabe destacar que 
  		        para mejores resultados, se debe tener instalado composer de manera global.</p><br> 
  		        <p>Por otro lado, se requiere contar con el paquete NodeJS para gestionar los paquetes requeridos para la reactividad en la gestión 
  		        de datos de algunos procesos, para lo cual se requiere seguir la documentación de [nodejs]<a target="_blank" href="https://nodejs.org/en/">(https://nodejs.org/)</a> para el sistema 
  		        operativo en el que se vaya a ejecutar la aplicación.</p><br> 
  		        <ul>
  		          <li>Abrir un terminal o consola y posicionarse en la ruta base del proyecto "/", luego ejecuta la siguiente instrucción:</p></li><br>
                  <p>composer install<br>
                <li>Una vez instalada la aplicación, ejecuta el comando:</li><br>
                  <p>php artisan key:generate</p><br>
                <li>Esto generará un identificador único para la aplicación y creará (si no existe), el archivo de configuración .env, en caso 
                de que no se genere dicho archivo, se debe ejecutar el comando:</li><br>
                  <p>cp .env.example .env</p><br> 
                  <p>Luego se debe repetir el paso anterior.</p><br>  
                <li>Para un mejor rendimiento de la aplicación en entornos de producción se recomienda utilizar el comando:</li><br>
                  <p>composer install --optimize-autoloader --no-dev</p><br> 
                  <p>Esto permitirá una carga más optimizada de los componentes del sistema.</p><br> 
                <li>En el archivo .env, localizado en la raíz del sistema, se deben establecer los parámetros de configuración necesarios bajo los cuales se ejecutará la aplicación.</li><br>
                  <ul>
                    <li>APP_NAME</li> 
                    <li>APP_ENV</li>                 
                    <li>APP_KEY</li>   
                    <li>APP_DEBUG</li>                 
                    <li>APP_LOG_LEVEL</li>                    
                    <li>APP_URL</li><br>  
                    <li>DB_CONNECTION</li> 
                    <li>DB_HOST</li>                 
                    <li>DB_PORT</li>   
                    <li>DB_DATABASE</li>                 
                    <li>DB_USERNAME</li>                    
                    <li>DB_PASSWORD</li><br>  
                    <li>BROADCAST_DRIVER</li>   
                    <li>CACHE_DRIVER</li>                 
                    <li>SESSION_DRIVER</li>                    
                    <li>QUEUE_DRIVER</li><br>  
                    <li>REDIS_HOST</li>                 
                    <li>REDIS_PASSWORD</li>                    
                    <li>REDIS_PORT</li><br> 
                    <li>MAIL_DRIVER</li> 
                    <li>MAIL_HOST</li>                 
                    <li>MAIL_PORT</li>   
                    <li>MAIL_USERNAME</li>                 
                    <li>MAIL_PASSWORD</li>                    
                    <li>MAIL_ENCRYPTION</li><br>
                    <li>PUSHER_APP_ID</li>   
                    <li>PUSHER_APP_KEY</li>                 
                    <li>PUSHER_APP_SECRET</li>                    
                    <li>PUSHER_APP_CLUSTER</li><br>
                  </ul>

                <li>De igual manera se debe instalar los paquetes necesarios para la gestión reactiva de datos, para lo cual se debe ejecutar el siguiente comando (teniendo en cuenta que se debe contar con nodejs y npm previamente instalados):</li><br> 
                  <p>npm install</p><br> 
                  <p>El comando anterior instala todas las dependencias de node requeridas por el sistema.</p><br>
                <li>El último paso en el proceso de instalación es modificar los usuarios y permisos para el acceso del servidor a la aplicación KAVAC, para lo cual le indicamos la permisología y usuario correspondiente.</li><br>  
                  <p>chown -R www-data:root (ruta-absoluta-de-instalacion)</p> 
                  <p>chmod 755 (ruta-absoluta-de-instalacion)/storage</p> 	 	
	            </ul>
	            <br>
           <!-- /Instalación -->

           <!-- Base de datos -->
	          <li><h4><b>Base de datos.</b></h4></li><br>
	            <p>El Sistema Administrativo KAVAC puede ser ejecutado con diferentes gestores de Base de Datos tales como PostgreSQL, MySQL,
	            SQLite, entre otros, sin embargo se recomienda el uso del gestor de Base de Datos PostgreSQL por su capacidad en la gestión de 
	            información.</p><br>
	            <ul> 
	              <li>Debe crear una base de datos en el gestor de su preferencia y configurarlo en el archivo .env con los datos de acceso. Ejemplo:</li><br>
	                <ul>
	                  <li>DB_CONNECTION=pgsql</li>
	                  <li>DB_HOST=localhost</li>
	                  <li>DB_PORT=5432</li>
	                  <li>DB_DATABASE=kavac</li>
	                  <li>DB_USERNAME=kavac</li>
	                  <li>DB_PASSWORD=kavac</li>	                	                	                	                 
	                </ul> 
	                <br>
	              <li>Una vez configurado el gestor de base de datos, se deben ejecutar el siguiente comando:</li><br>
	                <p>php artisan migrate</p><br>
	                <p>Lo anterior creará la estructura de tablas de la base de datos necesaria para comenzar a gestionar la información.</p>
	            </ul>
	            <br>
           <!-- /Base de datos -->

           <!-- Registros iniciales -->
	          <li><h4><b>Registros iniciales.</b></h4></li><br>
	            <ul>
                <li>KAVAC, cuenta con información inicial requerida para la gestión de la aplicación, para lo cual se debe ejecutar el comando:</li><br>
                  <p>php artisan db:seed</p><br>	
                  <p>	El anterior comando ejecutara las acciones necesarias para ingresar al sistema los datos inicialmente requeridos por la aplicación base como son: usuario, roles, permisos, localidades, estados civiles, profesiones, sectores de instituciones y tipos de instituciones.</p><br>     	                    
  		          <li>La aplicación cuenta con una cantidad de módulos independientes que permiten expandir sus funcionalidades, cada uno de estos módulos cuentan con sus registros iniciales por lo que es necesario ejecutar un comando adicional que permita registrar información de cada módulo instalado y habilitado en el sistema, para ello se ejecuta el siguiente comando:</li><br>
  		            <p>php artisan module:seed</p><br>	
  		            <p>Esto revisará que módulos del sistema están habilitados y procederá a registrar la información requerida, inicialmente, por cada uno de ellos.</p><br>
  	            <li>	Una vez que hayan sido registrado los datos iniciales del sistema, se puede autenticar en el mismo con los siguientes datos de acceso como administrador (es recomendable modificar la contraseña en el primer acceso al sistema):</li><br>	
  	              <p>Usuario: admin</p> 
  	              <p>Clave: 123456</p><br> 
  	            <li>El primer paso, para el correcto funcionamiento del sistema, es registrar información básica de la institución que llevará a cabo la gestión de información dentro de la aplicación, para ello se debe ingresar al menú:</li><br>
  	              <p>Configuración > General</p><br>
  	            <li>En el panel "CONFIGURAR INSTITUCIÓN" se deben indicar los datos de la Institución, una vez configurada la institución se mostrarán todas las opciones de los módulos disponibles en el sistema.</li> 
              </ul>
              <br>	
           <!-- /Registros iniciales -->

           <!-- Probando aplicaión -->
  	        <li><h4><b>Probando la aplicación.</b></h4></li><br>
  	          <ul>
                <li>Para identificar si la aplicación se encuentra correctamente instalada, puedes ejecutar el comando de artisan que te permite levantar un servidor en entornos de desarrollo de la siguiente forma:</li><br>
                  <p>php artisan serve</p><br>
                  <p>Este comando levanta un servidor en la dirección ip 127.0.0.1 o localhost y en el puerto 8000, para verificarlo puedes acceder a el enlace [127.0.0.1:8000](127.0.0.1:8000)</p><br> 
                <li>Puedes, de igual forma asignarle una dirección IP o dominio a este comando y un puerto en donde atenderá las peticiones para lo cual se puede agregar las opciones --host y/o --port, un ejemplo de su uso sería:</li><br>
                  <p>php artisan serve --port 192.168.1.1 --port 9000</p>   	            	          
  	          </ul>
  	          <br>
           <!-- /Probando aplicación -->
  	         
           <!-- Comandos básicos Laravel -->
            <li><h4><b>Comandos básicos laravel-modules</b></h4></li><br> 
   	      	  <ul>
  	      	    <li>Ejecutar las migraciones laravel-modules:</li><br> 	
  	      	      <p>php artisan module:migrate</p><br> 
  	      	    <li>Crea un nuevo modelo para el módulo especificado junto con su migración:</li><br>            
  	              <p>php artisan module:make-model -m ModuleNameModelName ModuleName</p><br> 
  	            <li>Genera nuevo controlador restful para el módulo especificado:</li><br> 
  	              <p>php artisan module:make-controller ModuleNameModelName ModuleName</p><br> 
  	            <li>Genera nuevo seeder para el módulo especificado (nombre del modelo en plural):</li><br>   
  	              <p>php artisan module:make-seed ModuleNameModelName ModuleName</p> 
  	          </ul>
  	        <br>
           <!-- /Comandos básicos Laravel  -->
	      </ul>
       <!-- /serie  -->
      </article>
```      