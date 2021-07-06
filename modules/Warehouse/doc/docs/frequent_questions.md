??? question "¿Cómo usar la funcionalidad de registro de formato de códigos?"
    El **Formato de Códigos** es una funcionalidad que posee la mayoría de módulos del sistema, se usa para generar referencias sobre los registros.  Cada sección de **Formato de Códigos** posee una descripción de los parámetros a seguir para establecer un formato.

    Cada código debe establecerse de acuerdo a un formato específico el cual se divide en tres (3) secciones:
    prefijo-dígitos-año.

    * **Prefijo:** debe contener entre 1 a 3 caracteres y debe ser único.
    * **Dígitos:** Establece el número del registro y comprende una longitud de entre 4 a 8 caracteres como máximo. Para establecer la longitud de la numeración se debe indicar con ceros (0) de acuerdo a la cantidad de dígitos máximos que se desea registrar.
    * **Año:** Indica el formato del año para el código el cual se debe indicar con la letra "**Y**" de acuerdo al formato deseado. Los valores posibles son: **YY** para formato de año corto y **YYYY** para el formato de año largo.

    Por Ejemplo: Se podría establecer un formato para solicitudes como SOL-00000000-YYYY. **SOL** hace referencia al prefijo de la solicitud, **00000000** será el número de la solicitud de 8 caracteres de longitud máxima y **YYYY** corresponde al formato del año.

??? question "¿Por qué al momento de procesar información de un formulario el sistema muestra o indica un mensaje de alerta indicando que los datos que se están intentando registrar ya existen?"
	
	Cuando el sistema emite un mensaje de alerta indicando que los datos que se están intentando registrar ya existen, se debe a dos posibles situaciones:

	1. Alguno de los campos contiene información única que ya se encuentra registrada en el sistema y por tanto no permitirá realizar el registro.
	2. Ya existe un registro con la misma información, sin embargo fue eliminado del sistema pero sigue estando en la base de datos; por lo que se debe proceder a restaurar el registro a través de la sección **Restaurar Registros Eliminados** del **Panel de Control**.
