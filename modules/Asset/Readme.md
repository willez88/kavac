# KAVAC | Sistema de Gestión Administrativa

### Pendientes Modulo de Bienes


# Configuracion General
	Incluye:
		- La configuración del clasificador de bienes (Forma General) visto desde el panel de configuración inicial
		- La configuración del clasificador en la sección de bienes (Forma Específica) {Tipos-Categorias-Subcategorias-Categorias_Especificas}

## Modelo de tabla pivote para recuperar toda la informacion (general)
## Cambiar Formulario para aceptar ingresos parciales


# Configuracion de Tipos de Bienes


### Registro de Bienes
	Gestiona todos los bienes institucionales adquiridos por la institucion 

# En la migración de bienes: (assset)

		- Falta la referencia de orden_compra_id con la tabla orden de compra
		- Falta la referencia de proveedor_id con la tabla proveedor
		
		- Tabla Condicion Fisica, Estatus de uso, Función de uso: Falta añadir nuevo campo en caso de selecciónar otra condicion fisica u otro estatus de uso u otra función de uso

# En el controlador de Bienes: (AssetController)

		- Falta validar orden de compra
		
# En la vista de registro de bienes: (register/create)

		- Falta definir select dependientes

### Asignacion de Bienes

	Gestiona la asignación de bienes dentro de alguna dependencia de la institución

# En la taba asignacion de bienes: (asset_asignation)

		- Falta la referencia de staff_id con la tabla payroll_staffs (nomina)
		- Plantear descripción de la asignación

# En el controlador de asignacion de bienes: (AssetAsignationController)

		- Falta incluir el modelo de payroll_staffs (nomina), para referenciar la informacion del trabajador al que se le asigna el bien

# En la vista de crear asignacion de bienes: (asignations/create)
		
		- Falta incluir los registros del trabajador en elementos del tipo select


### Desincorporación de Bienes:

		- Generar Asiento Contable

### Reportes de Bienes:
		
		- Falta funcion de formato de valor para reportes de bienes
		- Modificar scoope para integrar la busqueda por mes especifico 
