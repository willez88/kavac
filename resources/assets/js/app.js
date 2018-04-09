
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/** Componente genérico para el uso de listas desplegables con select2 */
Vue.component('select2', require('./components/SelectsComponent.vue'));

/** Componente para la gestión de estados civiles */
Vue.component('marital-status', require('./components/MaritalStatusComponent.vue'));

/** Componente para la gestión de profesiones */
Vue.component('professions', require('./components/ProfessionsComponent.vue'));

/** Componente para la gestión de tipos de instituciones */
Vue.component('institution-types', require('./components/InstitutionTypesComponent.vue'));

/** Componente para la configuración y gestión de sectores de instituciones */
Vue.component('institution-sectors', require('./components/InstitutionSectorsComponent.vue'));

/** Componente para la gestión de Países */
Vue.component('countries', require('./components/CountriesComponent.vue'));

/** Componente para la gestión de Estados */
Vue.component('estates', require('./components/EstatesComponent.vue'));

/** Componente para la gestión de Municipio */
Vue.component('municipalities', require('./components/MunicipalitiesComponent.vue'));

/** Componente para la gestión de Ciudades */
Vue.component('cities', require('./components/CitiesComponent.vue'));

/** Componente para la gestión de Parroquias */
Vue.component('parishes', require('./components/ParishesComponent.vue'));

/** Componente para la gestión de estatus de documentos */
Vue.component('document-status', require('./components/DocumentStatusComponent.vue'));

/** Opciones de configuración global para utilizar en todos los componentes vuejs de la aplicación */
Vue.mixin({
	methods: {
		addRecord(modal_id) {
			event.preventDefault();
			this.errors = [];
			this.reset();
			$("#" + modal_id).modal('show');
		},
		/**
		 * Método para la eliminación de registros
		 * @param  {integer} index Elemento seleccionado para su eliminación
		 * @param  {string}  url   Ruta que ejecuta la acción para eliminar un registro
		 */
    	deleteRecord(index, url) {
			let conf = confirm("Esta seguro de eliminar este registro?");
			
			if (conf === true) {
				axios.delete('/' + url + '/' + this.records[index].id).then(
					response => {
						this.records.splice(index, 1);
					 	gritter_messages(type='destroy');
					}
				)
				.catch(error => {});
			}
		}
    }
});

const app = new Vue({
    el: '#app',
});
