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

![Screenshot](/img/image27.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Parámetro Global de Nómina</div>

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

![Screenshot](/img/manage_1.png#imagen) 

### Escalafones salariales 

A través de esta funcionalidad se lleva a cabo la administración salarial de la organización, estableciendo los indicadores que señalan la relación entre el salario y la categoría o jerarquía.    

Crear un escalafón salarial:

-   Dirigirse a la **Configuración** del módulo de **Talento Humano**.
-   Ingresar a **Escalafones Salariales** en la sección **Parámetros Generales de Nómina**.
-   Indicar el **Nombre** de la agrupación, **Estado** e **Institución**.
-   Indicar el tipo de agrupación, ejemplo: Cargo.
-   Agregar una o más escalas.      
-   Presionar el botón **Guardar** y verificar que se haya almacenado en la lista de registros.

![Screenshot](/img/image28.png#imagen)<div style="text-align: center;font-weight: bold">Figura: Registro de Escalafón Salarial</div>

!!! info ""
    En la sección **Nueva Escala** es posible agregar una o más escalas, para ello es necesario indicar un **Nombre** y el **Valor** por cada escala, las opciones del campo **Valor** son definidas a partir del tipo de agrupación seleccionado en el campo anterior **Agrupar por**. 

    ![Screenshot](/img/image29.png#imagen)


Gestión de registros:

Para **Editar** o **Eliminar** un registro se debe hacer uso de los botones ubicados en la columna titulada **Acción** de la tabla de Registros.

![Screenshot](/img/manage_1.png#imagen) 
