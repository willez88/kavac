#Manual de Documentación de Usuario Sistema KAVAC

El Manual de Documentación del sistema KAVAC a nivel de usuario tiene como objetivo facilitar la tarea de conocimiento, uso y aprendizaje del sistema desarrollado. Presenta información acerca de todas las operaciones básicas que el sistema ofrece, así como capturas de pantallas útiles para el seguimiento de la explicación de los procesos.


##Comenzando

Este manual de usuario ha sido desarrollado usando el generador de sitios estáticos "Mkdocs" y el tema "Material-Mkdocs", a continuación se listan los requisitos e instrucciones para la instalación de los paquetes y gestión de manuales de usuarios.


##Pre-requisitos

	* Python 

MkDocs es compatible con las versiones 3.5, 3.6, 3.7, 3.8 y pypy3 de Python.

##Instalación

###Instalar pip

Si se utiliza una versión reciente de Python, el administrador de paquetes de Python, pip , probablemente esté instalado de forma predeterminada.  Para actualizar pip a su última versión se debe ejecutar el siguiente comando:

	pip install --upgrade pip

Si se requiere instalar pip por primera vez, debe hacer uso de curl y ejecutar los siguientes comandos:

	curl https://bootstrap.pypa.io/get-pip.py -o get-pip.py

Ejecutar el siguiente comando en el mismo directorio donde se ha descargado el archivo get-pip.py

	python get-pip.py  


###Instalación de Mkdocs

Instale Mkdocs usando pip

	pip install mkdocs

Ejecute el siguiente comando para verificar que todo funciona bien

	mkdocs--version


###Instalación de Material-Mkdocs

Ejecute el siguiente comando para instalar mkdocs-material en la versión usada para la generación de los manuales de usuario del sistema KAVAC

	pip install mkdocs-material==5.4.0

Ejecute el siguiente comando si desea instalar la última versión estable de mkdocs-material  

	pip install mkdocs-material


###Instalación de mkdocs-minify-plugin

	pip install mkdocs-minify-plugin
	

##Ejecuntando pruebas

###Comandos básicos de Mkdocs

Ejecute el siguiente comando para crear un nuevo proyecto de documentación

	mkdocs new [nombre del manual]

Ejecute el siguiente comando en el mismo directorio de su proyecto para iniciar el servidor, (Ingrese en la ruta http://127.0.0.1:8000/ de su navegador para ver la página inicial)

	mkdocs serve

Ejecute el siguiente comando en el mismo directorio de su proyecto para construir la documentación ya finalizada

	mkdocs build

Ejecute el siguiente comando para ver una lista de comandos disponibles

	mkdocs --help

	mkdocs build --help

###Configurar el tema Material-Mkdocs

Para agregar el tema a un nuevo archivo de documentación basta con añadir las siguientes líneas al archivo .yml de configuración de la documentación.

	theme:
		name: material

##Construcción del sitio

###Documentación de usuario KAVAC

Para la gestión de los manuales de documentación del sistema KAVAC se deben seguir los siguientes pasos:

* Ingresar al directorio donde se ubica el manual de documentación e iniciar el servidor ejecutando el comando:

		mkdocs serve

* Ingrese en la ruta http://127.0.0.1:8000/ de su navegador para ver la página inicial.  Al realizar cambios en los archivos de documentación o el archivo de configuración (archivo .yml), se cargarán automáticamente y serán visibles en el navegador.  

* Una vez finalizado los cambios construya el sitio ejecutando el comando:

		mkdocs build

###Tema Material-Mkdocs

Para realizar modificaciones en el tema se recomienda seguir la documentación de [Material for Mkdocs](https://squidfunk.github.io/mkdocs-material/)

	
##Construido con

	*	[Mkdocs](https://www.mkdocs.org/) 	
	*	[Material for Mkdocs](https://squidfunk.github.io/mkdocs-material/)

	