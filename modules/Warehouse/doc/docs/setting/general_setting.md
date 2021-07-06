# Configuración Módulo de Almacén
********************************

![Screenshot](../img/logokavac.png#imagen)

## Configuración general de almacén 

### Almacenes

Desde esta sección se realiza la gestión de almacenes, es posible registrar un nuevo almacén, editar o eliminar algún registro.

**Para realizar un nuevo registro** 

- Dirigirse a la Configuración del módulo de Almacén
- Ingresar a Almacenes en la sección Configuración General de Almacén
- Completar el formulario   
- Presionar el botón Guardar y verificar que se haya almacenado en la lista de registros

![Screenshot](/img/figure_2.png)<div style="text-align: center;font-weight: bold">Figura: Almacenes</div>

Esta sección permite Editar o Eliminar cualquier registro, haciendo uso de los botones ubicados en la columna titulada Acción de la tabla de registros.    

### Productos

Desde esta sección se realiza la gestión de productos, es posible registrar uno o varios productos, editar o eliminar algún registro.

**Para realizar un nuevo registro** 

- Dirigirse a la Configuración del módulo de Almacén
- Ingresar a Productos en la sección Configuración General de Almacén
- Completar el formulario   
- Presionar el botón Guardar y verificar que se haya almacenado en la lista de registros

![Screenshot](/img/formulario.png)<div style="text-align: center;font-weight: bold">Figura: Formulario de Registro para Productos</div>

![Screenshot](/img/figure_200.png)<div style="text-align: center;font-weight: bold">Figura: Productos</div>

Esta sección permite Editar o Eliminar cualquier registro, haciendo uso de los botones ubicados en la columna titulada Acción de la tabla de registros.    

#### Importar registros

Mediante esta funcionalidad es posible cargar los registros de productos de forma masiva a tráves de una hoja de cálculo. Se sugiere que al momento de realizar una importación de registros, se sigan las recomendaciones que se señalan en esté manual para la funcionalidad importar registros.

**Funcionalidad para importar registros**

La carga de registros de forma masiva es una funcionalidad que se presenta en varios módulos de la aplicación. Es importante que el usuario encargado de hacer uso de esta funcionalidad tenga presente los parámetros y requerimientos a seguir para un correcto manejo de la misma. 

Se recomienda al usuario que va a importar un archivo; realizar antes una exportación de los registros (registros de productos) que se encuentran en el sistema. Esto le permitira al usuario editar esta copia del archivo de registros y usar esta información para realizar una importación.    

El formato de hoja de calculo establecido en el archivo a importar contiene una serie de columnas el cual deben estar identificadas, si el usuario ha exportado un archivo entonces este mantiene sus columnas identificadas por defecto y no es necesario cambiar algún valor.

Cada uno de los campos asociados a cada registro se encuentran identificados por un **id** el cual es un identificador único.

A continuación se muestra una tabla de registros con sus respectivos **id**. Para un nuevo registro basta solo con que el usuario complete los campos name (nombre del producto), description (descripción del producto) y measurement_unit_id (id de la unidad de medida); entonces el sistema completa de forma automática los campos faltantes.   

**Tabla de registros de productos**

|name|description|measurement_unit_id|measurement_unit|measurement_unit_acronym|measurement_unit_description| 
|--|--|--|--|--|--|
|Producto 1|Descripción|1|Bulto|bulto|Descripción de unidad de medida|
|Producto 2|Descripción|2|Caja|caja|Descripción de unidad de medida|
|Producto 3|Descripción|3|Galón|gal|Descripción de unidad de medida|
|Producto 4|Descripción|4|Litro|lts|Descripción de unidad de medida|
|Producto 5|Descripción|5|Metros cuadrados|mt2|Descripción de unidad de medida|
|Producto 6|Descripción|6|Metros lineales|m|Descripción de unidad de medida|
|Producto 7|Descripción|7|Paquete|pkg|Descripción de unidad de medida|
|Producto 8|Descripción|8|Quintal|qq|Descripción de unidad de medida|
|Producto 9|Descripción|9|Resma|res|Descripción de unidad de medida|
|Producto 10|Descripción|10|Servicio|srv|Descripción de unidad de medida|
|Producto 11|Descripción|11|Unidad|und|Descripción de unidad de medida|


Los **id** son generados cada vez que se realiza un nuevo registro en la configuración del módulo, es posible visualizarlos una vez se exporte un archivo de registros (registros de productos) desde el sistema. 

El archivo que el usuario ha exportado le permite editar esta infomación, es decir, puede actualizar cualquier registro que se ha realizado previamente.  Sin embargo, el manejo de este contenido se debe realizar con precaución, ya que los registros pueden encontrase asociados a través de sus **id**.  

!!! note "Nota"
	Las unidades de medida son registradas inicialmente en la Configuración General del Sistema KAVAC.

!!! warning "Advertencia"
	Los formatos permitidos para la carga de archivos son:  **csv**, **xls**, **xlsx** y **ods**.  

**Para importar registros**

- Dirigirse a la Configuración del módulo de Almacén
- Ingresar a Productos en la sección Configuración General de Almacén
- Presionar el botón Importar ubicado en la esquina superior derecha de esta sección  
- Seleccionar el archivo del directorio local, para transferir a la aplicación  
- Verificar que los registros se hayan almacenado en la lista de registros  

#### Exportar registros

Mediante esta funcionalidad es posible obtener una copia de todos los registros a tráves de una hoja de cálculo.

**Para exportar registros**

- Dirigirse a la Configuración del módulo de Almacén
- Ingresar a Productos en la sección Configuración General de Almacén**
- Presionar el botón Exportar ubicado en la esquina superior derecha de esta sección  
- Una copia del archivo se transfiera de la aplicación al equipo, este archivo contiene todos los registros de productos en el sistema  

### Reglas de abastecimiento 

Desde esta sección se realiza la gestión de reglas de abastecimiento, es posible establecer un numero mínimo y máximo en el stock.  Para los artículos considerados como almacenables, esta herramienta permite contar con reglas para asegurarse de que los productos con mas demanda nunca queden sin existencias o superen el máximo establecido de stock. Además, desde esta sección es posible editar o eliminar algún registro realizado.

**Para realizar un nuevo registro** 

- Dirigirse a la Configuración del módulo de Almacén
- Ingresar a Reglas de Abastecimiento en la sección Configuración General de Almacén
- Completar el formulario   
- Presionar el botón Guardar y verificar que se haya almacenado en la lista de registros

![Screenshot](/img/figure_2.png)<div style="text-align: center;font-weight: bold">Figura: Almacenes</div>

Esta sección permite Editar o Eliminar cualquier registro, haciendo uso de los botones ubicados en la columna titulada Acción de la tabla de registros.    



### Cierres de almacén 

Desde esta sección se realiza la gestión para cierre de almacén, es posible programar un cierre de almacén, editar o eliminar algún registro.

**Para programar un cierre de almacén**  

- Dirigirse a la Configuración del módulo de Almacén
- Ingresar a Cierres de Almacén en la sección Configuración General de Almacén
- Completar el formulario   
- Presionar el botón Guardar y verificar que se haya almacenado en la lista de registros

![Screenshot](/img/figure_2.png)<div style="text-align: center;font-weight: bold">Figura: Almacenes</div>

Esta sección permite Editar o Eliminar cualquier registro, haciendo uso de los botones ubicados en la columna titulada Acción de la tabla de registros.    

	
</div>