# Gestión de Registros de Bienes Institucionales 
************************************************
<div style="text-align: justify;">

![Screenshot](img/logokavac.png#imagen)

## Bienes institucionales 

En esta sección se listan todos los registros realizados y se muestra información relevante sobre los mismos. La tabla de registros contiene datos del bien como lo son: condición física, estatus de uso, serial, marca y módelo; tambien se muestra un código de registro y el nombre de la institución involucrada. 

![Screenshot](/img/figure_1.png)<div style="text-align: center;font-weight: bold">Figura 1: Registros de Bienes Institucionales</div>

A través de los botones ubicados en la columna titulada **Acción** el encargado de bienes institucionales o usuario con permisos especiasles puede: observa información detallada, asignar, desincorporar, editar o eliminar el bien registrado.   

###Crear un nuevo registro

**Para crear un nuevo registro**

- Dirigirse al **Módulo de Bienes**, luego a **Registros** y ubicarse en la sección **Bienes Institucionales**
- Haciendo uso del botón **Crear** ubicado en la esquina superior derecha de esta sección, se procede a realizar un nuevo registro 
- Se completa el formulario
- Se presiona el botón **Guardar** para para completar el registro, y se verifica en la lista de registros  

![Screenshot](/img/figure_2.png)<div style="text-align: center;font-weight: bold">Figura 2: Registro Manual de Bienes Institucionales</div>


Este registro corresponde al método de forma manual, a través de esta funcionalidad es posible registrar solo un bien institucional.  Es importante considerar, que en el formulario de esta sección se solicita información asociada al bien (tipo de bien, ), que debe ser añadida previamente en la configuración del módulo. 	  

###Importar registro

El sistema permite realizar una carga masiva de registros de bienes, para realizar esta importación de registros se debe tomar en cuenta seguir un formato de hoja de calculo y cumplir con los formatos permitidos para la carga del archivo.

!!! warning "Advertencia"
	Los formatos permitidos para la carga de archivos son:  **csv**, **xls**, **xlsx** y **ods**.   

###Funcionalidad para importar registros

La carga de registros de forma masiva es una funcionalidad que se presenta en varios módulos de la aplicación. Es importante que el usuario encargado de hacer uso de esta funcionalidad tenga presente los parámetros y requerimientos a seguir para un correcto manejo de la misma. 

Se recomienda al usuario que va a importar un archivo; realizar antes una exportación de los registros (registros de bienes) que se encuentran en el sistema. Esto le permitira al usuario editar esta copia del archivo de registros y usar esta infomarción para realizar una importación.    

El formato de hoja de calculo establecido en el archivo a importar contiene una serie de columnas el cual deben estar identificadas, si el usuario ha exportado un archivo entonces este mantiene sus columnas identificadas por defecto y no es necesario cambiar algun valor.

Cada uno de los campos asociados a cada registro se encuentran identificados por un **id** el cual es un identificador único.

A continuación se muestra una tabla con dos tipos de bienes registrados con sus respectivos id y las categorias asociadas a cada tipo de bien con su respectivo id. 

|asset_type_id |asset_type |asset_category_id |asset_category|          
|---|---|---|---|  
|1 |Mueble  |1 |Maquinaria y demás equipos de construcción, campo, industria y taller|         
|  |        |2 |Equipos de transporte, tracción y elevación                          |         
|  |        |3 |Equipos de comunicaciones y de señalamiento                          |     
|  |        |4 |Equipos médicos - quirúrgicos, dentales y veterinarios               |         
|  |        |5 |Equipos científicos, religiosos, de enseñanza y recreación           |   
|  |        |6 |Equipos de defensa y seguridad del Estado                            |     
|  |        |7 |Máquinas, muebles y demás equipos de oficina y de alojamiento        |         
|  |        |8 |Semovientes                                                          |   
|2 |Inmueble|1 |Edificaciones, Tierras y Terrenos                                    |  


Los id son generados cada vez que se realiza un nuevo registro en la configuración del módulo, es posible visualizarlos una vez se exporte un archivo de registros (registros de bienes) desde el sistema. 

El archivo que el usuario ha exportado le permite editar esta infomación, es decir, puede actualizar cualquier registro que se ha realizado previamente.  Sin embargo, el manejo de este contenido se debe realizar con precaución, ya que los registros pueden encontrase asociados a través de sus id.  


**Para Importar un registros**

- Dirigirse al **Módulo de Bienes**, luego a **Registros** y ubicarse en la sección **Bienes Institucionales**
- Haciendo uso del botón **Importar** ubicado en la esquina superior derecha de esta sección, se procede a realizar la carga masiva  
- Seleccionar el archivo del directorio local, para transferir a la aplicación  
- Verificar que los registros se hayan almacenado en la lista de registros 


###Exportar registro

La aplicación permite obtener una hoja de calculo con una carga masiva desde el sistema con todos los registros realizados, y la información asociada a cada registro. 

**Exportar registros**

- Dirigirse al **Módulo de Bienes**, luego a **Registros** y ubicarse en la sección **Bienes Institucionales**
- Haciendo uso del botón **Exportar** ubicado en la esquina superior derecha de esta sección, se procede a realizar la carga masiva  
- Una copia del archivo se transfiera de la aplicación al equipo, este archivo contiene todos los registros de bienes en el sistema 

</div>























   