/**
 * @class User
 * @brief Clase para gestionar datos de usuarios
 *
 * Gestiona información de usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class User {

	/**
	 * Método constructor de la clase
	 * @param  {string} name        Nombre de la persona
	 * @param  {string} username    Nombre del usuario
	 * @param  {string} email       Correo electrónico del usuario
	 * @param  {array}  roles       Roles que posee el usuario
	 * @param  {array}  permissions Permisos de acceso a la aplicación
	 */
	constructor(name, username, email, roles, permissions) {
		this.name = name;
		this.username = username;
		this.email = email;
		this.roles = roles || [];
		this.permissions = permissions || [];
	}

	/**
	 * Muestra un listado co los roles que posee el usuario
	 * @return {string} Listado de roles
	 */
	showRoles() {
		let roles = `
			<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="col-12"><b>Roles</b></label>
		`;
		this.roles.forEach(function(role) {
			roles += `<span class="badge badge-primary" style="margin-right:10px">${role}</span>`;
		});

		roles += '</div></div></div>';

		return roles;
	}

	/**
	 * Muestra un listado de permisos de acceso para el usuario
	 * @return {string} Listado de permisos de acceso
	 */
	showPermissions() {
		let permissions = `
			<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label class="col-12"><b>Permisos</b></label>
		`;
		this.permissions.forEach(function(perm) {
			permissions += `<span class="badge badge-primary" style="margin-right:10px">${perm}</span>`;
		});

		permissions += '</div></div></div>';

		return permissions;
	}

	/**
	 * Muestra información detallada del usuario
	 * @return {string} Información sobre los detalles de un usuario
	 */
	showInfo() {
		return `
			<h6 class="text-center">${this.name}</h6>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="col-12"><b>Usuario</b></label>
						<label class="col-12">${this.username}</label>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="col-12"><b>Correo</b></label>
						<label class="col-12">${this.email}</label>
					</div>
				</div>
			</div>
			${this.showRoles()}
			${this.showPermissions()}
		`;
	}
}

/**
 * @class AppInfo
 * @brief Información de la aplicación
 *
 * Gestiona y muestra datos sobre la aplicación
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AppInfo {

	/**
	 * Método constructor de la clase
	 * @param  {array} members Arreglo con información de las personas involucradas en el proyecto
	 */
	constructor(members) {
		this.members = members || [];
	}

	/**
	 * Muestra datos sobre la aplicación
	 * @return {string} Datos de la aplicación
	 */
	showAbout() {

		let credits = `
			<h6 class="card-title">Créditos</h6>
			<ul>
		`;
		let group = '';
		this.members.forEach(function(member) {
			if (group !== member.group) {
				credits += `<li class="special-title mt-4">${member.group}</li>`;
				group = member.group;
			}
			credits += `<li>${member.name} (${member.email})</li>`;
		});
		credits += '</ul>';

		return `
			<h6>SISTEMA DE GESTION ADMINISTRATIVA | KAVAC</h6>
			<p class="text-justify">
				KAVAC es un sistema de planificación y gestión organizacional, que automatiza los procesos
                administrativos asociados al manejo de recursos financieros, económicos, bienes, equipos,
                insumos e incorpora elementos de seguridad electrónica, garantizando la autenticidad e integridad de
                cada documento y archivo generado por el sistema.
			</p>
			${credits}
			<h6 class="card-title">Repositorio</h6>
			<ul>
				<li class="no-list-symbol">
					<a href="https://gestion.cenditel.gob.ve/trac/browser/kavac" target="_blank" data-toggle="tooltip"
                       title="Enlace al repositorio del proyecto">
						https://gestion.cenditel.gob.ve/trac/browser/kavac
					</a>
				</li>
			</ul>
			<h6 class="card-title">Documentación</h6>
			<ul>
				<li class="no-list-symbol">
					<a href="${window.app_url}/system-doc" target="_blank" data-toggle="tooltip"
                       title="Documentación técnica para desarrolladores">
                        Manual Técnico / Desarrolladores
                    </a>
				</li>
				<li class="no-list-symbol">
					<a href="${window.app_url}/user-doc" target="_blank" data-toggle="tooltip"
                       title="Documentación de usuario">
                        Manual de Usuarios
                    </a>
				</li>
			</ul>
		`;
	}

	/**
	 * Muestra la licencia bajo la cual se distribuye la aplicación
	 * @return {string} Datos de la licencia de la aplicación
	 */
	showLicense() {
		let now = new Date().getFullYear();
        let year = (now > 2018)?(' - ' + now):'';

        let members = '';
        let countMembers = this.members.length - 1;

        this.members.forEach(function(member, index) {
        	var sep = '.';
        	if (index < countMembers) {
        		sep = ', ';
        	}
        	members += `${member.name}${sep}`;
        });
        members.substr(0, members.length - 2);

		return `
			<h6 class="text-center">LICENCIA RESUMIDA</h6>
			<ul>
				<li><b>Nombre del Software:</b> KAVAC</li>
				<li>
					<b>Descripción:</b>
					Control y seguimiento de todas las etapas en la gestión administrativa de entes públicos
				</li>
				<li><b>Nombre del licenciante:</b> Fundación CENDITEL (2018${year})</li>
				<b>Autores:</b> ${members}</li>
			</ul>
			<p class="text-justify">
				La Fundación Centro Nacional de Desarrollo e Investigación en Tecnologías Libres (CENDITEL),
				ente adscrito al Ministerio del Poder Popular para la Ciencia y Tecnología (MPPECT),
				concede permiso para usar, copiar, modificar y distribuir libremente y sin fines comerciales
				el SOFTWARE KAVAC, sin garantía alguna, preservando el reconocimiento moral de los autores y
				manteniendo los mismos principios para las obras derivadas, de conformidad con los términos y
				condiciones de la licencia de software de la Fundación CENDITEL.
			</p>
			<p class="text-justify">
				El software es una creación intelectual necesaria para el desarrollo económico y social de la
				nación, por tanto, esta licencia tiene la pretensión de preservar la libertad de este conocimiento
				para que contribuya a la consolidación de la soberanía nacional.
			</p>
			<p class="text-justify">
				Cada vez que copie y distribuya el SOFTWARE KAVAC debe acompañarlo de una copia de la licencia.
				Para más información sobre los términos y condiciones de la licencia visite la siguiente dirección
				electrónica:
			</p>
			<p class="text-right">
				<a href="http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3" target="_blank"
				   title="Terminos y condiciones acerca de la Licencia de Software bajo la cual se distribuye esta aplicación"
                   data-toggle="tooltip">
					<img src="/images/license-icon.png" class="img-fluid" style="max-width:100px;">
				</a>
			</p>
		`;
	}
}

/**
 * @class  HandleJSError
 * @brief Gestión de errores del frontend
 *
 * Gestiona y registra los errores generados en la interfaz de usuario
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 *
 * Ejemplo: throw new HandleJSError('app', {
 * 		log_url: configuración de la url que genera los logs de la interfaz del sistema,
 * 		debug: Determina si la aplicación se encuentra o no en modo debug
 * 		message: Mensaje de error generado
  });
 */
class HandleJSError extends Error {

	/**
	 * Método constructor de la clase
	 * @param {string} view Nombre de la vista que genera el error
	 * @param {object} params Objeto con los parámetros a registrar
	 */
	constructor(view = '', params = {}) {
		// Pass remaining arguments (including vendor specific ones) to parent constructor
		super(params);

		// Maintains proper stack trace for where our error was thrown (only available on V8)
		if (Error.captureStackTrace) {
			Error.captureStackTrace(this, HandleJSError);
		}

		//console.log(params)
		this.log_url = window.log_url || this.params.log_url || false;
		this.debug = window.debug || this.params.debug || false;
		this.view = view || '';
		this.message = params.message;
		this.date = new Date();
		this.dataLog = {
			view: this.view,
			line: this.getLineNumber() || '',
			message: this.message,
			stacktrace: this.stack.split("\n"),
			date: this.date
		};
	}

	/**
	 * Registra el evento del error generado
	 */
	register() {
		if (this.log_url) {
			axios.post(this.log_url, this.dataLog).catch(error => {
				if (this.debug) {
					console.log(error);
				}
				else {
					console.info("Error inesperado del sistema, contacte al administrador.");
				}
	        });
		}
		else if (this.debug) {
			console.log(
				`Se generó un evento de error que no pudo ser registrado con el siguiente detalle:
				${this.stack}`
			);
		}
	}

	/**
	 * Muestra un mensaje en la consola del navegador según el tipo indicado
	 *
	 * @param  {string} type Define el tipo de error a mostrar
	 */
	error_type(type = '') {
		let err = this.message + "\n" + this.stack;
		if (type === "log") {
			console.log(err);
		}
		else if (type === "info") {
			console.info(err);
		}
		else if (type === "warning") {
			console.warn(err);
		}
		else if (type === "error") {
			console.error(err);
		}
	}
}
