??? question "¿Por qué el nombre de Kavac?"
    El nombre hace referencia a las Cuevas de Kavac, formaciones rocosas ubicadas en el sureste del Auyántepuy en el valle de Kamarata, cerca de la aldea indígena de Kavac en el Parque Nacional Canaima, Estado Bolívar, Venezuela.

??? question "¿Cómo adaptar el sistema KAVAC a cualquier organización?"
   	El sistema KAVAC está diseñado de forma modular, incluso cuando los módulos se relacionan entre si, existe independencia entre ellos.  Su diseño y estructura de desarrollo permite la extensión de nuevos módulos y funcionalidades que se puedan adaptar a una institución con requerimientos específicos.

??? question "¿Cómo usar la funcionalidad de registro de formato de códigos?"
    El **Formato de Códigos** es una funcionalidad que posee la mayoría de módulos del sistema, se usa para generar referencias sobre los registros.  Cada sección de **Formato de Códigos** posee una descripción de los parámetros a seguir para establecer un formato.

    Cada código debe establecerse de acuerdo a un formato específico el cual se divide en tres (3) secciones:
    prefijo-dígitos-año.

    * **Prefijo:** debe contener entre 1 a 3 caracteres y debe ser único.
    * **Dígitos:** Establece el número del registro y comprende una longitud de entre 4 a 8 caracteres como máximo. Para establecer la longitud de la numeración se debe indicar con ceros (0) de acuerdo a la cantidad de dígitos máximos que se desea registrar.
    * **Año:** Indica el formato del año para el código el cual se debe indicar con la letra "**Y**" de acuerdo al formato deseado. Los valores posibles son: **YY** para formato de año corto y **YYYY** para el formato de año largo.

    Por Ejemplo: Se podría establecer un formato para solicitudes como SOL-00000000-YYYY. **SOL** hace referencia al prefijo de la solicitud, **00000000** será el número de la solicitud de 8 caracteres de longitud máxima y **YYYY** corresponde al formato del año.

??? question "¿Por qué el sistema muestra un mensaje de alerta indicando que los datos que está intentando registrar ya existen, al momento de procesar información de un formulario?"
	
	Cuando el sistema emite un mensaje de alerta indicando que los datos que se están intentando registrar ya existen, se debe a dos posibles situaciones:

	1. Alguno de los campos contiene información única que ya se encuentra registrada en el sistema y por tanto no permitirá realizar el registro.
	2. Ya existe un registro con la misma información, sin embargo fue eliminado del sistema pero sigue estando en la base de datos; por lo que se debe proceder a restaurar el registro a través de la sección **Restaurar Registros Eliminados** del **Panel de Control**.
    
<!-- ??? question "¿Cómo generar un respaldo de Base de Datos?"

    El sistema KAVAC incorpora una sección orientada a la administración de respaldos de base de datos, para ingresar a dicha sección el usuario debe dirigirse al panel superior del sistema e ingresar en la opción **Respaldos de Base de Datos**. 

    ![Screenshot](img/database_backups.png#imagen)

    A continuación se muestra la sección **Administración de Respaldos**.  Desde esta sección es posible crear un nuevo respaldo y gestionar los respaldos generados. 

    - Para crear un nuevo respaldo presione el botón **Crear un nuevo respaldo** ![Screenshot](img/new_database_backups.png#imagen)  -->

