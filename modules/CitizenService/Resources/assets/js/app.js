/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts del Modulo de Nomina a compilar por la aplicación
*/

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de solicitudes
 *
 * @author 
 */
Vue.component('citizenservice-request-types', require('./components/settings/CitizenServiceRequestTypesComponent.vue').default);

Vue.component('citizenservice-request-create', require('./components/requests/CitizenServiceRequestCreateComponent.vue').default);

Vue.component('citizenservice-request-list', require('./components/requests/CitizenServiceRequestListComponent.vue').default);

Vue.component('citizenservice-request-info', require('./components/requests/CitizenServiceRequestInfoComponent.vue').default);

Vue.component('citizenservice-request-list-pending', require('./components/requests/CitizenServiceRequestListPendingComponent.vue').default);

Vue.component('citizenservice-request-list-closing', require('./components/requests/CitizenServiceRequestListClosingComponent.vue').default);

Vue.component('citizenservice-request-close', require('./components/requests/CitizenServiceRequestCloseComponent.vue').default);

Vue.component('citizenservice-report-create', require('./components/reports/CitizenServiceReportCreateComponent.vue').default);

/**
 * Opciones de configuración global del módulo de Atención al Ciudadano
 *
 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
 */
Vue.mixin({
	methods: {
	
		getCitizenServiceRequestTypes() {
			this.citizen_service_request_types = [];
			axios.get('/citizenservice/get-request-types').then(response => {
				this.citizen_service_request_types = response.data;
			});
		},
	},
});


//import uploader from 'vue-simple-uploader'


//Vue.use(uploader)

