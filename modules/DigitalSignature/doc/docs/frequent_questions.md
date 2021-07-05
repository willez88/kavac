??? question "¿Por qué al momento de procesar información de un formulario el sistema muestra o indica un mensaje de alerta indicando que los datos que se están intentando registrar ya existen?"
	
	Cuando el sistema emite un mensaje de alerta indicando que los datos que se están intentando registrar ya existen, se debe a dos posibles situaciones:

	1. Alguno de los campos contiene información única que ya se encuentra registrada en el sistema y por tanto no permitirá realizar el registro.
	2. Ya existe un registro con la misma información, sin embargo fue eliminado del sistema pero sigue estando en la base de datos; por lo que se debe proceder a restaurar el registro a través de la sección **Restaurar Registros Eliminados** del **Panel de Control**.

??? question "¿Qué requisitos previos son necesarios para la verificación y firma electrónica de PDF?"

	La verificación de firma electrónica puede realizarse normalmente utilizando los pasos descritos en este manual. Sin embargo, para la firma electrónica de documentos PDF es necesario contar con un certificado .p12 suministrado por una entidad nacional autorizada.