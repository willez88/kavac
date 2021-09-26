# Configuración Módulo de Talento Humano
****************************************

![Screenshot](../img/logokavac.png#imagen)

## Parámetros generales de nómina

### Parámetros globales

A través de esta funcionalidad se gestiona los diferentes parámetros globales de nómina a ser utilizados en el módulo.  La funcionalidad incluye tres (3) tipos de parámetros distintos con diferentes datos asociados según el tipo de parámetro. 

Crear un parámetro global de nómina:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Parámetros Globales** en la sección **Parámetros Generales de Nómina**.
-   Completar el formulario de registro.
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

![Screenshot](../img/image27.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Parámetro Global de Nómina</div>

!!! info ""
    El formulario de registro de **Parámetro Global de Nómina** incluye tres (3) tipos de parámetros: 

    -   Valor global: Se debe indicar **Nombre**, **Código**, **Acrónimo** y el **Valor**(se hace uso del botón de selección para indicar un valor porcentual).
    -   Variable reiniciable a cero por período de nómina: Se indica **Nombre**, **Código** y **Acrónimo**.
    -   Variable procesada: Se debe indicar **Nombre**, **Código**, **Acrónimo** y se establece una **Formula** a través de calculadora habilitada para esta opción. 

    **Nota**: Para el caso de la variable procesada, haciendo uso de los botónes de selección se habilitan parámetros a ser utilizados en la calculadora, se debe indicar los operadores y valores a ser asignados. Los parámetros establecidos se incluyen como un nuevo botón dentro de la calculadora, haciendo uso de estos botónes se genera una sentencia dentro del campo **Formula**.   Las sentencias se establecen como un condicional, por lo que las instrucciones deben indicarse dentro de los llaves **{}**.

    Ejemplo:

    **Registro**: Género.
    **Operador**: igualdad.
    **Valor**: Venezolano(a). 

    if(GENDER == 1){ **Instrucción** }      



Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 

### Escalafones salariales 

A través de esta funcionalidad se lleva a cabo la administración salarial de la organización, estableciendo los indicadores que señalan la relación entre el salario y la categoría o jerarquía.    

Crear un escalafón salarial:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Escalafones Salariales** en la sección **Parámetros Generales de Nómina**.
-   Indicar el **Nombre** de la agrupación, **Estado** e **Institución**.
-   Indicar el tipo de agrupación, ejemplo: Cargo.
-   Agregar una o más escalas.      
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

![Screenshot](../img/image28.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Escalafón Salarial</div>

!!! info ""
    En la sección **Nueva Escala** es posible agregar una o más escalas, para ello es necesario indicar un **Nombre** y el **Valor** por cada escala, las opciones del campo **Valor** son definidas a partir del tipo de agrupación seleccionado en el campo anterior **Agrupar por**. 

    ![Screenshot](/img/image29.png#imagen)


Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 


### Tabulador de nómina

Esta funcionalidad permite señalar los valores monetarios que corresponden a las diferentes categorías de puestos en la organización.  Se divide en dos secciones: **Definir Tabulador** y **Cargar Tabulador**.

A través de la sección **Definir Tabulador** se establecen los parámetros que definen las categorías a considerar dentro del tabulador.   

En la sección **Cargar Tabulador** se establecen valores numéricos para el tabulador salarial. 

Definir tabulador de nómina:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Tabulador de Nómina** en la sección **Parámetros Generales de Nómina**.
-   Completar campos de la sección **Definir Tabulador**.
-   Completar campos de la sección **Cargar Tabulador**.      
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

!!! info ""
    Para definir un tabulador de nómina es necesario contar con registros previos de **Escalafones Salariales**. 

![Screenshot](../img/image30.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Tabulador de Nómina(Definir Tabulador)</div>

![Screenshot](../img/image31.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Tabulador de Nómina(Cargar Tabulador)</div>

 
Gestión de registros:

Para **Descargar** tabulador, **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_3.png#imagen) 

### Tipos de conceptos

Permite definir un tipo de concepto que será utilizado para la formulación de conceptos con incidencias sobre un salario. 

Definir un tipo de concepto:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Tipos de Concepto** en la sección **Parámetros Generales de Nómina**.
-   Completar el formulario indicando **Nombre**, **Signo** y **Descripción** del concepto.
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

![Screenshot](../img/image32.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Tipo de Concepto</div>

Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 

### Conceptos

A través de esta funcionalidad se establecen los diferentes conceptos con incidencias sobre los salarios. Esta sección requiere de registros previos como tipo de concepto, cuentas contables, presupuestarias y tabulador de nómina.   

Definir un concepto:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Conceptos** en la sección **Parámetros Generales de Nómina**.
-   Completar el formulario de **Concepto**.
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

!!! info ""
    El formulario de registro incluye dos formas de cálculo : 

    *      Fórmula
    *      De acuerdo a tabulador

![Screenshot](../img/image33.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Concepto</div>

Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 
### Tipos de pago 

Desde esta sección se establecen los diferentes tipos de pagos de nómina.  Esta funcionalidad permite establecer un código de identificación unico para el tipo de pago en cuestión, programar períodos de pago y establecer las incidencias sobre las diferentes categorías.   

Definir un tipo de pago:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Tipos de Pago** en la sección **Parámetros Generales de Nómina**.
-   Completar el formulario de **Tipos de Pago Nómina**.
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

!!! info ""
    Para completar el formulario se requiere al menos un registro previo de **Concepto**.

![Screenshot](../img/image34.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Tipo de Pago</div>

![Screenshot](../img/image35.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Período de Pago Definido</div>

Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 

### Política vacacional 

Esta funcionalidad permite establecer parámetros (disposiciones legales) que faciliten los mecanismos para la solicitud de vacaciones y beneficien el empleado y no afecten el desarrollo de las operaciones de la organización.

Se encuentra compuesta por tres secciones: **Política vacacional**, **Pago de vacaciones** y **Solicitud de vacaciones**

Definir política vacacional:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Tipos de Pago** en la sección **Parámetros Generales de Nómina**.
-   Completar el formulario de la sección **Política Vacacional**.
-   Completar el formulario de la sección **Pago de Vacaciones**.
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

!!! info ""

    -   Para completar el formulario se requiere al menos un registro previo de **Tipo de Pago**.
    -   Para agregar períodos vacacionales presione el botón añadir de la sección **Política Vacacional**.

    ![Screenshot](/img/add.png#imagen)


![Screenshot](../img/image36.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Políticas Vacacionales</div>

![Screenshot](../img/image37.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Pago de Vacaciones</div>

Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 

### Políticas de prestaciones 

Esta funcionalidad permite establecer parámetros (disposiciones legales) que están orientadas a cubrir pagos económicos indirectos que se pagan a los empleados por parte de la organización como: seguros, gastos médicos, vacaciones, pensiones o planes de educación.
    
Definir políticas de prestaciones:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Políticas de Prestaciones** en la sección **Parámetros Generales de Nómina**.
-   Completar el formulario de la sección **Definir Política de Prestaciones Sociales**.
-   Completar el formulario de la sección **Definir Pago de Prestaciones Sociales**.
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

!!! info ""

    Para completar el formulario se requiere al menos un registro previo de **Tipo de Pago**.

![Screenshot](../img/image38.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Definir Política de Prestaciones Sociales</div>

![Screenshot](../img/image39.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Definir Pago de Prestaciones Sociales</div>

Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 
### Políticas de permisos

A través de esta funcionalidad se definen los parámetros a seguir para la solicitud de permisos.

Definir políticas de permisos:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Políticas de Permisos** en la sección **Parámetros Generales de Nómina**.
-   Completar el formulario de la sección **Políticas de Permisos** .
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

![Screenshot](../img/image40.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Política de Permisos</div>

Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 
### Tipos de liquidación 

En esta sección se realiza el registro de diferentes tipos de liquidaciones que pueden representar el cierre de un proceso.  Para el registro de un tipo de liquidación se requiere un registro previo de **Concepto**. 

Definir un tipo de liquidación:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Tipos de Liquidación** en la sección **Parámetros Generales de Nómina**.
-   Completar el formulario de la sección **Tipo de Liquidación** .
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

![Screenshot](../img/image41.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Tipo de Liquidación</div>

Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](../img/manage_1.png#imagen) 


