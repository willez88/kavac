# Configuración Módulo de Almacén
********************************

![Screenshot](../img/logokavac.png#imagen)

## Formatos de códigos

La sección de **Formatos de Códigos** permite establecer un código de referencia para los registros posteriores (insumos en inventario, movimientos, solicitudes, reportes e inventario), para completar esta configuración el usuario debe dirigirse al módulo de **Almacén**, luego a **Configuración** y ubicarse en la sección **Formatos de Códigos**.

Cada código debe establecerse de acuerdo a un formato específico el cual se divide en tres (3) secciones: prefijo-dígitos-año.

-   **Prefijo**: debe contener entre 1 a 3 caracteres y debe ser único.
-   **Dígitos**: Establece el número del registro y comprende una longitud de entre 4 a 8 caracteres como máximo. Para establecer la longitud de la numeración se debe indicar con ceros (0) de acuerdo a la cantidad de dígitos máximos que se desea registrar.
-   **Año**: Indica el formato del año para el código el cual se debe indicar con la letra **"Y"** de acuerdo al formato deseado. Los valores posibles son: **YY** para formato de año corto y **YYYY** para el formato de año largo.

Ejemplos de códigos:

|Productos|Movimientos|Solicitudes|Reportes|Inventario|      
|--- |--- |--- |--- |--- |
|PRO-00000000-YYYY |MOV-00000000-YYYY |SOL-00000000-YYYY |REP-00000000-YYYY |INV-00000000-YYYY |

Una vez se establezca el formato de códigos deseado se puede ejecutar cualquier cambio haciendo uso de los **Botones de Acciones de Formulario**, ya sea **Borrar**, **Cancelar** o **Guardar** respectivamente. 

![Screenshot](../img/form_actions.png#imagen)