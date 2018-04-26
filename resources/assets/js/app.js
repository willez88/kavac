/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts a compilar por la aplicación
*/

require('./bootstrap');

window.Vue = require('vue');

/**
 * Componente genérico para el uso de listas desplegables con select2 y selects dependientes
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('select2', require('./components/SelectsComponent.vue'));

/**
 * Componente para la gestión de estados civiles
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('marital-status', require('./components/MaritalStatusComponent.vue'));

/**
 * Componente para la gestión de profesiones
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('professions', require('./components/ProfessionsComponent.vue'));

/**
 * Componente para la gestión de tipos de instituciones
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('institution-types', require('./components/InstitutionTypesComponent.vue'));

/**
 * Componente para la configuración y gestión de sectores de instituciones
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('institution-sectors', require('./components/InstitutionSectorsComponent.vue'));

/**
 * Componente para la gestión de Países
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('countries', require('./components/CountriesComponent.vue'));

/**
 * Componente para la gestión de Estados
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('estates', require('./components/EstatesComponent.vue'));

/**
 * Componente para la gestión de Municipio
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('municipalities', require('./components/MunicipalitiesComponent.vue'));

/**
 * Componente para la gestión de Ciudades
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('cities', require('./components/CitiesComponent.vue'));

/**
 * Componente para la gestión de Parroquias
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('parishes', require('./components/ParishesComponent.vue'));

/**
 * Componente para la gestión de estatus de documentos
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('document-status', require('./components/DocumentStatusComponent.vue'));

/**
 * Componente para la gestión de impuestos
 *
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 */
Vue.component('taxes', require('./components/TaxesComponent.vue'));

/**
 * Opciones de configuración global para utilizar en todos los componentes vuejs de la aplicación
 * 
 * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
 * @param  {object} methods Métodos generales a implementar en CRUDS
 */
Vue.mixin({
	methods: {
		/**
		 * Método que borra todos los datos del formulario
		 * 
		 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 */
		reset() {
			this.record = [];
		},
		/**
		 * Mérodo que obtiene los registros a mostrar
		 * 
		 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 * @param  {string} url Ruta que obtiene todos los registros solicitados
		 */
		readRecords(url) {
			axios.get('/' + url).then(response => {
				this.records = response.data.records;
			});
		},
		/**
		 * Método que permite mostrar una ventana emergente con la información registrada 
		 * y la nueva a registrar
		 * 
		 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 * @param {string} modal_id Identificador de la ventana modal
		 */
		addRecord(modal_id, url, event) {
			event.preventDefault();
			this.errors = [];
			this.reset();
			$("#" + modal_id).modal('show');
			this.initRecords();
			this.readRecords(url);
		},
		/**
		 * Método que permite crear o actualizar un registro
		 * 
		 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 * @param  {string} url Ruta de la acción a ejecutar para la creación o actualización de datos
		 */
		createRecord(url) {
			if (this.record.id) {
				this.updateRecord(url);
			}
			else {
				var fields = {};
				for (var index in this.record) {
					fields[index] = this.record[index];
				}
				axios.post('/' + url, fields).then(response => {
					this.reset();
					this.readRecords(url);
					this.showMessage('store');
				}).catch(error => {
					this.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								this.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});
			}
			
		},
		/**
		 * Método que carga el formulario con los datos a modificar
		 * 
		 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 * @param  {integer} index Identificador del registro a ser modificado
		 */
		initUpdate(index, event) {
			this.errors = [];
			this.record = this.records[index];
			event.preventDefault();
		},
		/**
		 * Método que permite actualizar información
		 * 
		 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 * @param  {string} url Ruta de la acci´on que modificará los datos
		 */
		updateRecord(url) {
			var fields = {};
			for (var index in this.record) {
				fields[index] = this.record[index];
			}
			axios.patch('/' + url + '/' + this.record.id, fields).then(response => {
				this.readRecords(url);
				this.reset();
				this.showMessage('update');
			}).catch(error => {
				this.errors = [];

				if (typeof(error.response) !="undefined") {
					for (var index in error.response.data.errors) {
						if (error.response.data.errors[index]) {
							this.errors.push(error.response.data.errors[index][0]);
						}
					}
				}
			});
	    },
		/**
		 * Método para la eliminación de registros
		 * 
		 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 * @param  {integer} index Elemento seleccionado para su eliminación
		 * @param  {string}  url   Ruta que ejecuta la acción para eliminar un registro
		 */
    	deleteRecord(index, url) {
			let conf = confirm("Esta seguro de eliminar este registro?");
			
			if (conf === true) {
				axios.delete('/' + url + '/' + this.records[index].id).then(response => {
					this.records.splice(index, 1);
					this.showMessage('destroy');
				}).catch(error => {});
			}
		},
		/**
		 * Método que muestra un mensaje al usuario sobre el resultado de una acción
		 * 
		 * @author  Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 * @param  {string} type      Tipo de mensaje a mostrar
		 * @param  {string} msg_title Título del mensaje (opcional)
		 * @param  {string} msg_class Clase CSS a utilizar en el mensaje (opcional)
		 * @param  {string} msg_icon  Ícono a mostrar en el mensaje (opcional)
		 */
		showMessage(type, msg_title, msg_class, msg_icon, custom_text) {
			msg_title = (!msg_title)?'Éxito':msg_title;
		    msg_class = (!msg_class)?'growl-success':'glowl-'+msg_class;
		    msg_icon = (!msg_icon)?'screen-ok':msg_icon;
		    custom_text = (typeof(custom_text)!=="undefined")?custom_text:'';

		    var msg_text;
		    if (type=='store') {
		    	msg_text = 'Registro almacenado con éxito';
		    }
		    else if (type=='update') {
		    	msg_text = 'Registro actualizado con éxito';
		    }
		    else if (type=='destroy') {
		    	msg_text = 'Registro eliminado con éxito';
		    }
		    else if (type=='custom') {
		    	msg_text = custom_text;
		    }

		    /** @type {object} Muestra el correspondiente mensaje al usuario */
		    $.gritter.add({
		        title: msg_title,
		        text: msg_text,
		        class_name: msg_class,
		        image: "/images/" + msg_icon + ".png",
		        sticky: false,
		        time: ''
		    });
		}
    }
});

/** @type {object} Constante que crea el elemento Vue */
const app = new Vue({
    el: '#app',
});
