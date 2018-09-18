# KAVAC | Sistema de Gestión Administrativa

## Pendientes Modulo de Bienes

### Tipos de Bienes

# Es necesario codigo del tipo de un bien?

### Categorias de Bienes

# Codigo de la Categoria general de un bien sera solo númerico?
	Valor actual (string tam=10)

### Subcategorias de Bienes

# Codigo de la Subcategoria de un bien sera solo númerico?
	Valor actual (string tam=10)

### Categorias Especificas de Bienes

# Codigo de la categoria especifica de un bien sera solo númerico?
	Valor actual (string tam=10)




### Registro de Bienes
	Gestiona todos los bienes institucionales adquiridos por la institucion 

# En la migración de bienes: (assset)

		- Falta la referencia de orden_compra_id con la tabla orden de compra
		- Falta la referencia de proveedor_id con la tabla proveedor
		
		- Plantear tabla Condicion Fisica, Estatus de uso, Función de uso para poder añadir nuevo campo en caso de selecciónar otra condicion fisica u otro estatus de uso u otra función de uso

# En el controlador de Bienes: (AssetController)

		- Falta validar orden de compra
		- Falta validar Serial de Inventario (Institucion-Clasificacion-AñodeAdquisicion-NumerodeInventario)
		** Numero de Inventario???

		- Falta cambiar en metodo template_choices el (reg->serial) por una descripcion del bien, por ejemplo (Serial_Inventario-Marca-Modelo) para elementos del tipo select

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
		
		- Falta actualizar descripcion de bien (Serial_Inventario-Marca-Modelo)
		- Falta incluir los registros del trabajador en elementos del tipo select

### Configuracón de Bienes:
	Incluye:
		- La configuración del clasificador de bienes (Forma General) visto desde el panel de configuración inicial
		- La configuración del clasificador en la sección de bienes (Forma Específica) {Tipos-Categorias-Subcategorias-Categorias_Especificas}

# En la Vista de Configuracion:
	
		- Falta solucionar problemas con componentes vue.js  (Crear y borrar)



### Desincorporación de Bienes:

### Reportes de Bienes: