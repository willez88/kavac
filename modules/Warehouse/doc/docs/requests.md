# Gestión de Solicitudes  
************************

![Screenshot](img/logokavac.png#imagen)

## Solicitudes por departamento

En esta sección se listan las solicitudes por requerimiento de artículos o materiales que un departamento o dependencia requiere, a través de esta sección es posible **Crear** una nueva solicitud, **Ver** información detallada del registro, **Editar** y **Eliminar** un registro. 

![Screenshot](img/solicitud_departamento.png)<div style="text-align: center;font-weight: bold">Figura: Solicitudes por Departamento</div>

**Estado de la solicitud**

Los **Estados de la Solicitud** que puede tomar un registro son: **Pendiente**, **Rechazado**, **Aprobado** o **Entregado**,  permitiendo así; tener un seguimiento de las solicitudes. 

Una vez se realiza una nueva solicitud esta toma el estado **Pendiente**, luego puede cambiar el estado como **Rechazado**, **Aprobado** o **Entregado** dependiendo de la decisión del encargado de almacén.  

### Crear una nueva solicitud

A través de esta funcionalidad se formula una nueva solicitud para productos o artículos que son requeridos por un departamento o dependencia.


**Para crear una nueva solicitud**

- Dirigirse al módulo de **Almacén**, luego a **Solicitudes de Almacén** y ubicarse en la sección **Solicitudes por Departamento**.
- Haciendo uso del botón **Crear** ![Screenshot](img/create.png#imagen)
ubicado en la esquina superior derecha de esta sección, se procede a realizar una nueva solicitud.
- Se completa el formulario de registro de la sección **Solicitud de Almacén**. 
- Se presiona el botón **Guardar** ![Screenshot](img/save.png#imagen) ubicado al final de esta sección, y se verifica en la lista de registros en **Solicitudes por Departamento**.

![Screenshot](img/solicitud.png)<div style="text-align: center;font-weight: bold">Figura: Solicitud de Almacén-Departamento</div>

### Sobre los datos de la solicitud

**Dependencia solicitante**

!!! note "Nota"
	Los datos correspondientes al campo Dependencia Solicitante (departamento), deben estar registrados previamente, de no estar registrados es necesario adjuntar esta información en la Configuración General del Sistema KAVAC, específicamente en la opción "Unidades/Dependencias" de la sección de "Registros Comunes".

**Proyecto y Acción Centralizada**
	
Si la solicitud se encuentra relacionada directamente con un **Proyecto** cambie el botón de selección a la opción **SI** e ingrese un **Proyecto** y **Acción Específica** (asegurese de que exista al menos una **Acción Específica** asociada al **Proyecto**). 

![Screenshot](img/proyecto.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Solicitud de Almacén-Proyecto</div>


Si la solicitud se encuentra relacionada directamente con una **Acción Centralizada** cambie el botón de selección a la opción **SI** e ingrese una **Acción Centralizada** y **Acción Específica** (asegurese de que exista al menos una **Acción Específica** asociada a la **Acción Centralizada**).

![Screenshot](img/accion_centralizada.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Solicitud de Almacén-Acción Centralizada</div>
	
!!! note "Nota"
	Los datos correspondientes al campo Proyecto, Acción Específica y Acción Centralizada, deben estar registrados previamente, de no estar registrados es necesario adjuntar esta información en la Configuración del módulo de Presupuesto. 

**Seleccionar artículos a solicitar**

Seleccione los artículos a solicitar usando el botón Checkbox ubicado en la primera columna de la tabla de artículos y a través del campo ubicado en la columna titulada **Solicitados** indique el número de artículos a solicitar. 

![Screenshot](img/rect302.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Selección de Artículos</div>

!!! warning "Advertencia"
	El número de artículos a solicitar debe ser menor o igual al número de artículos en Existencia


### Gestión de registros

Para **Ver información detallada**, **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de registros en la sección de **Solicitudes por Departamento**.  

![Screenshot](img/manage.png#imagen)


## Solicitudes por usuario

En esta sección se listan las solicitudes por requerimiento de artículos o materiales que un usuario requiere, a través de esta sección es posible **Crear** una nueva solicitud, **Ver** información detallada del registro, **Editar** y **Eliminar** un registro. 

![Screenshot](img/usuario.png)<div style="text-align: center;font-weight: bold">Figura: Solicitudes por Usuario</div>

**Estado de la solicitud**

Los **Estados de la Solicitud** que puede tomar un registro son: **Pendiente**, **Rechazado**, **Aprobado** o **Entregado**,  permitiendo así; tener un seguimiento de las solicitudes. 

Una vez se realiza una nueva solicitud esta toma el estado **Pendiente**, luego puede cambiar el estado como **Rechazado**, **Aprobado** o **Entregado** dependiendo de la decisión del encargado de almacén. 

### Crear una nueva solicitud

A través de esta funcionalidad se formula una nueva solicitud para productos o artículos que son requeridos por un usuario.

**Para crear una nueva solicitud**

- Dirigirse al módulo de **Almacén**, luego a **Solicitudes de Almacén** y ubicarse en la sección **Solicitudes por Usuario**.
- Haciendo uso del botón **Crear** ![Screenshot](img/create.png#imagen)
ubicado en la esquina superior derecha de esta sección, se procede a realizar una nueva solicitud.
- Se completa el formulario de registro de la sección **Solicitud de Almacén**. 
- Se presiona el botón **Guardar** ![Screenshot](img/save.png#imagen) ubicado al final de la sección y se verifica en la lista de registros de la sección **Solicitudes por Usuario**.

![Screenshot](img/solicitud_usuario.png)<div style="text-align: center;font-weight: bold">Figura: Solicitud de Almacén-Usuario</div>

### Sobre los datos de la solicitud

**Departamento**

!!! note "Nota"
	Los datos correspondientes al campo Departamento, deben estar registrados previamente, de no estar registrados es necesario adjuntar esta información en la Configuración General del Sistema KAVAC, específicamente en la opción "Unidades/Dependencias" de la sección de "Registros Comunes".

**Cargo y Solicitante**
	
!!! note "Nota"
	Los usuarios solicitantes deben estar registrados previamente en el expediente del módulo de Talento Humano.


**Seleccionar artículos a solicitar**

Seleccione los artículos a solicitar usando el botón Checkbox ubicado en la primera columna de la tabla de artículos y a través del campo ubicado en la columna titulada **Solicitados** indique el número de artículos a solicitar. 

![Screenshot](img/rect302.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Selección de Artículos</div>

!!! warning "Advertencia"
	El número de artículos a solicitar debe ser menor o igual al número de artículos en Existencia

### Gestión de registros

Para **Ver información detallada**, **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de registros en la sección de **Solicitudes por Usuario**.  

![Screenshot](img/manage.png#imagen)

!!! warning "Advertencia"
	El usuario encargo de la gestión de almacén debe ser cuidadoso a la hora de registrar y aprobar solicitudes, ya que debe tomar en consideración el número de existencia y el número de reserva que el insumo tiene asignado.  Si se excede en el número de reservas generadas por solicitud de acuerdo a la existencia del insumo el sistema generará un mensaje indicando el error. 

	![Screenshot](img/image125.png#imagen)

	**Consultar número de reserva y existencia del producto**

	Una vez se ingresa al formulario de **Solicitud de Almacén** para una solicitud por **Departamento** o por **Usuario**, cada **Insumo** indica información sobre su existencia y reserva en la columna titulada **Inventario**.

	![Screenshot](img/image127.png#imagen)

## Solicitudes pendientes 

Esta sección lista todos las solicitudes que han sido aprobadas rechazadas, o se encuentran pendientes por revisar.	Desde esta sección el encargado de bienes o el usuario con permisos especiales, puede **Consultar información de solicitud**, **Aceptar** o **Rechazar** solicitudes que se encuentran en el estado **Pendiente**.

![Screenshot](img/pendientes.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Solicitudes Pendientes</div>
 
Para **Ver** información detallada, **Aceptar** o **Rechazar** una solicitud se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de registros en la sección **Solicitudes Pendientes**.

![Screenshot](img/manage_1.png#imagen)


### Aceptar solicitud

- Dirigirse al módulo de **Almacén**. 
- Ingresar a **Solicitudes de Almacén**.
- Ubicarse en la sección **Solicitudes Pendientes**. 
- Haciendo uso del botón Aceptar ![Screenshot](img/approve.png#imagen)
ubicado en la columna titulada **Acción** de la tabla de registros se aprueba la solicitud seleccionada.


### Rechazar solicitud

- Dirigirse al módulo de **Almacén**. 
- Ingresar en **Solicitudes de Almacén**.
- Ubicarse en la sección **Solicitudes Pendientes**.
- Haciendo uso del botón **Rechazar** ![Screenshot](img/disapprove.png#imagen)
ubicado en la columna titulada **Acción** de la tabla de registros se rechaza la solicitud seleccionada


## Entregar productos 

Una vez la solicitud ha sido aceptada, y el artículo se encuentra disponible se habilita la opción **Entregar Producto** en la columna títulada **Acción**. 

![Screenshot](img/entregar.png)<div style="text-align: center">Figura: Solicitudes Pendientes</div>


### Entregar producto

- Dirigirse al módulo de **Almacén**. 
- Ingresar a **Solicitudes de Almacén**.
- Ubicarse en la sección **Solicitudes Pendientes**. 
- Presionar el botón **Entregar** ![Screenshot](img/deliver.png#imagen)
ubicado en la columna titulada **Acción** de la tabla de solicitudes.
- Ingresar una observación y presionar el botón **Guardar** para confirmar entrega. 

![Screenshot](img/confirmar.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Solicitudes Pendientes</div>

Luego que la entrega ha sido confirmada la solicitud cambia su estado a **Entregado** en la tabla de **Solicitudes por Departamento** o **Solicitudes por Usuario** según sea el caso.

![Screenshot](img/listo_entregado.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Estado de Solicitud-Entregado</div>
























   