# Gestión de Recepción e Ingreso de Artículos 
*********************************************

![Screenshot](img/logokavac.png#imagen)

## Ingresos de almacén 

En esta sección se listan las formulaciones de solicitudes para ingreso de artículos.	A través de esta sección es posible crear una nueva solicitud, ver información detallada del registro, editar y eliminar un registro. Esta tabla de solicitudes incluye información detallada en sus columnas que permite realizar un seguimiento del las diferentes solicitudes, como lo es el código de la solicitud, descripción de la solicitud, almacén involucrado, fecha de formulación y estado de la solicitud. 

![Screenshot](img/figure_ingreso.png)<div style="text-align: center;font-weight: bold">Figura: Ingresos de Almacén</div>

Los **Estados de Solicitud** que puede tomar un registro son: **Pendiente**, **Rechazado** o **Aprobado**, permitiendo así; poder realizar un seguimiento de las solicitudes. 

Una vez se realiza una nueva solicitud esta toma el estado **Pendiente**, luego puede cambiar el estado como **Rechazado** o **Aprobado** dependiendo de la decisión del encargado de almacén.   

### Crear una nueva solicitud

A través de esta funcionalidad se formula una nueva solicitud para ingresos de productos, es importante saber que los productos deben estar registrados previamente al igual que los almacenes,	de no estar registrados es necesario adjuntar esta información en la **Configuración** del módulo.  

**Para crear un nuevo registro**

- Dirigirse al módulo de **Almacén**, luego a **Recepciones de Almacén** y ubicarse en la sección **Ingresos de Almacén**.
- Haciendo uso del botón **Crear** ![Screenshot](img/create.png#imagen)
ubicado en la esquina superior derecha de esta sección, se procede a realizar una nueva solicitud.
- Se completa el formulario de registro de la sección **Nuevo Ingreso al Almacén**.
- Se agregan los productos a ingresar a la solicitud. 
- Se presiona el botón **Guardar** ![Screenshot](img/save.png#imagen) ubicado al final de esta sección, y se verifica en la lista de registros en **Ingresos de Almacén**.

![Screenshot](img/figure_nuevoingreso.png)<div style="text-align: center;font-weight: bold">Figura: Nuevo Ingreso al Almacén</div>

!!! note "Nota"
	Los tipos de moneda son registrados inicialmente en la **Configuración General** del Sistema KAVAC, específicamente en la opción "Monedas" de la sección de "Registros Comunes".
	
!!! info "Información"
	En el formulario de registro de la sección **Nuevo Ingreso al Almacén** es posible agregar todos los productos deseados, a través del botón:

	![Screenshot](img/add.png#imagen)

	Cada producto agregado se muestra en un tabla de registros, en la parte inferior de dicha sección.

![Screenshot](img/figure_productosingresar.png)<div style="text-align: center;font-weight: bold">Figura: Productos Agregados</div>


Los productos que han sido agregados pueden ser editados o eliminados, a través de los botones ubicados en la columna titulada **Acción** de la tabla de **Productos Agregados**.  

### Gestión de registros

Para **Ver información detallada**, **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de registros en la sección de **Ingresos de Almacén**.  

![Screenshot](img/manage.png#imagen)

## Ingresos de almacén pendientes

Esta sección lista todos las solicitudes que han sido aprobadas rechazadas, o se encuentran pendientes por revisar.	Desde esta sección el encargado de bienes o el usuario con permisos especiales, puede **Aceptar** o **Rechazar** solicitudes que se encuentran en el estado **Pendiente**.

![Screenshot](img/solicitudes_pendientes.png)<div style="text-align: center;font-weight: bold">Figura: Ingresos de Almacén Pendientes</div>

Para **Ver información detallada**, **Aceptar** o **Rechazar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de registros en la sección de **Ingresos de Almacén Pendientes**.

![Screenshot](img/manage_1.png#imagen)


### Aceptar solicitud

- Dirigirse al módulo de **Almacén**. 
- Ingresar en **Recepciones de Almacén**.
- Ubicarse en la sección **Ingresos de Almacén Pendientes**. 
- Haciendo uso del botón **Aceptar** ![Screenshot](img/approve.png#imagen)
ubicado en la columna titulada **Acción** de la tabla de registros se aprueba la solicitud.


### Rechazar solicitud

- Dirigirse al módulo de **Almacén**. 
- Ingresar en **Recepciones de Almacén**.
- Ubicarse en la sección **Ingresos de Almacén Pendientes**. 
- Haciendo uso del botón **Rechazar** ![Screenshot](img/disapprove.png#imagen)
ubicado en la columna titulada **Acción** de la tabla de registros se rechaza la solicitud.
























   