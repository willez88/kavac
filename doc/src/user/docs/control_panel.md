# Administración del Sistema 
****************************
<div style="text-align: justify;" >

La aplicación inicialmente contará con una configuración por defecto que el usuario administrador debe completar a través de los elementos funcionales del sistema, que permitirán ajustar el uso del KAVAC a la estructura organizativa y características de la institución usuaria.   A través del **Panel de Control** y la **Configuración** se definirán los parámetros útiles para la consolidación del sistema con relación a las instituciones, sus sedes y características organizacionales.   


##Panel de control  


El **Panel de Control** es una herramienta de administración del sistema KAVAC que permite observar los datos de transacción de operaciones conjuntas a los distintos módulos que integran el sistema.   Las distintas secciones de este módulo permiten visualizar, buscar y organizar datos relacionados con el acceso a la aplicación, auditoria de registros, operaciones en los módulos de contabilidad, bienes y almacén, estatus de datos que se muestran a través de gráficos o datos tabulados.   Además; posee una sección útil para el manejo de elementos del sistema destinada para desarrolladores. 


###Herramientas para desarrolladores 


Esta sección está dirigida para usuarios desarrolladores, muestra elementos útiles para la construcción de nuevas funcionalidades de la aplicación.  A través de esta sección se administran las herramientas de la interfaz gráfica como los iconos disponibles para usar a lo largo del sistema, botones, gestión de formularios, registro de eventos, estructura de gráficos y tablas.   Asimismo, se muestra una opción de ajustes para configurar el estado del sistema ya sea modo mantenimiento, demostración o depuración. 


![Screenshot](img/herramientas-desarrolladores.png)
<div style="text-align: center;font-weight: bold">Figura: Herramientas para Desarrolladores</div>


##Control de acceso a la aplicación 

###Acceso a la aplicación

Esta sección permite llevar un control de acceso a la aplicación, además de visualizar y gestionar información de cuentas de usuarios registradas. Desde esta herramienta el usuario administrador puede visualizar los roles de usuarios, nombre de usuarios, direcciones IP, estatus (usuario conectado o desconectado) y ultima conexión.   La sección permite al usuario administrador gestionar la cuenta de usuario haciendo uso de los botones ubicados en la columna titulada **Acción**.


![Screenshot](img/acceso-aplicacion.png)
<div style="text-align: center;font-weight: bold">Fig. Acceso a la Aplicación</div>


Los botones ubicados en la columna titulada **Acción** son herramientas que permiten:  

 - Enviar mensaje 
 - Configurar cuenta de usuario 
 - Enviar notificación 
 - Ver información del usuario  
 - Asignar permisos de acceso 	      
 


###Auditoría de registros 


Esta sección es una herramienta que permite visualizar e inspeccionar los registros realizados desde una cuenta de usuario.    Es versátil al momento de filtrar nuestras búsquedas a través de parámetros establecidos por el usuario. 


![Screenshot](img/auditoria-registros.png)
<div style="text-align: center;font-weight: bold">Figura: Auditoría de Registros</div>

Para realizar una auditoría o seguimiento de un registro de cuenta usuario, es necesario seguir los siguientes pasos: 
 
 - Acceder al **Panel de Control** y ubicarse en la sección **Auditoría de Registro**
 - Proceder a buscar el registro en los datos tabulados.   Es posible filtrar la información indicando los parámetros de búsqueda como la fecha comprendida del registro, nombre de usuario o módulo al que pertenece. 
 - De igual manera se muestra una serie de datos tabulados con información asociada a los registros de cuenta usuario  
 - Haciendo uso del botón ubicado en la columna titulada **Acción** es posible observar de forma más detallada la información del registro  


###Restaurar registros eliminados 


Esta sección permite restaurar los registros que han sido eliminados, la sección presenta un historial de registros eliminados con información detallada del registro de forma tabulada.  


![Screenshot](img/restaurar-registros.png)
<div style="text-align: center;font-weight: bold">Figura: Restaurar Registros Eliminados</div>

Para completar la restauración de un registro es necesario:

- Ingresar al **Panel de Control** del sistema 
- Dirigirse a la sección de **Restaurar Registros Eliminados**  
- A través de los parámetros de búsqueda es posible filtrar los datos y facilitar la búsqueda.    
- Para completar la restauración de un registro, hacemos uso del boton ubicado en la columna titulada **Acción**


##Módulo de contabilidad


###Operaciones módulo de contabilidad


A través del **Panel de Control** es posible realizar un seguimiento de los asientos contables registrados en el sistema a partir de la sección de **Operaciones en Módulo de Contabilidad** del **Panel de Control**.   En esta sección se muestra en forma tabulada registros de los asientos contables con información relacionada con la fecha de registro, referencia, concepto referente a la operación, total relacionado con la partida doble (debe y haber del asiento) y el estado  del asiento contable. Es posible generar una impresión haciendo uso del botón ubicado en la columna titulada **Acción** para obtener más detalles. 


![Screenshot](img/operaciones-contabilidad.png)
<div style="text-align: center;font-weight: bold">Figura: Asientos Contables</div>

###Reportes de contabilidad


El **Panel de Control** permite visualizar los diferentes reportes generados a partir del módulo de contabilidad.    En la sección de **Reportes de Contabilidad** se muestra de forma tabulada los reportes generados e información relacionada a cada uno de ellos. 


![Screenshot](img/reportes-contabilidad.png)
<div style="text-align: center;font-weight: bold">Figura: Reportes de Contabilidad</div>

Los reportes son generados desde el **Módulo de contabilidad**, y a través del **Panel de Control** es posible visualizar detalles de estos reportes. 


##Módulo de bienes 

###Gráficos del inventario de bienes 


El **Panel de Control** presenta una sección relacionada con los bienes institucionales.  La sección de **Gráficos del Inventario de Bienes Institucionales**, representa la cantidad de recursos en función de los bienes institucionales. Es posible seleccionar los datos que el sistema representará gráficamente ya sean bienes existentes, más solicitados o menos solicitados, haciendo uso de los botones de selección. 


![Screenshot](img/graficos-bienes.png)

![Screenshot](img/graphics.png)
<div style="text-align: center;font-weight: bold">Figura Gráficos del Inventario de Bienes</div>

El sistema permite seleccionar un modo de visualización de gráficas, ya sea gráfica de barras, circular o lineal (estas gráficas son configuradas previamente por el desarrollador en el **Panel de Control**). 



###Historial de operaciones módulo de bienes


El sistema permite contar con un seguimiento de las operaciones en el **Módulo de Bienes**, a través de la sección **Histórico de Operaciones del Módulo de Bienes**. Los datos tabulados muestran una descripción y fecha de la operación, haciendo uso de los botones ubicados en la columna titulada **Acción**, donde es posible generar un reporte y ver más detalles de la operación.      


![Screenshot](img/operaciones-bienes.png)
<div style="text-align: center;font-weight: bold">Figura: Historial de Operaciones en el Módulo de Bienes</div>

##Módulo de almacén 

El **Panel de Control** permite llevar un seguimiento de las operaciones que se llevan a cabo sobre el módulo de almacén.  La sección del **Estado del inventario** permite visualizar la disponibilidad de productos expresado en términos porcentuales, además de expresar estos datos de manera gráfica, en la sección de **Gráficos del Inventario de Productos en Almacén** y a través de la sección **Histórico de Operaciones del Módulo de Almacén** podemos observar cada una de las operaciones registradas sobre el módulo. Los datos tabulados muestran una descripción y fecha de la operación, haciendo uso de los botones ubicados en la columna titulada **Acción**, donde es posible generar un reporte y ver más detalles de la operación.

![Screenshot](img/inventario-almacen.png)
<div style="text-align: center;font-weight: bold">Figura: Estado del Inventario de Almacén</div>

![Screenshot](img/operaciones-almacen.png)
<div style="text-align: center;font-weight: bold">Figura: Histórico de Operaciones del Módulo de Almacén</div>

</div>






