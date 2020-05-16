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
Vue.component('citizenservice-request-types', () => import(
    /* webpackChunkName: "citizenservice-request-types" */
    './components/settings/CitizenServiceRequestTypesComponent.vue')
);

Vue.component('citizenservice-request-create', () => import(
    /* webpackChunkName: "citizenservice-request-create" */
    './components/requests/CitizenServiceRequestCreateComponent.vue')
);

Vue.component('citizenservice-request-list', () => import(
    /* webpackChunkName: "citizenservice-request-list" */
    './components/requests/CitizenServiceRequestListComponent.vue')
);

Vue.component('citizenservice-request-info', () => import(
    /* webpackChunkName: "citizenservice-request-info" */
    './components/requests/CitizenServiceRequestInfoComponent.vue')
);

Vue.component('citizenservice-request-list-pending', () => import(
    /* webpackChunkName: "citizenservice-request-list-pending" */
    './components/requests/CitizenServiceRequestListPendingComponent.vue')
);

Vue.component('citizenservice-request-list-closing', () => import(
    /* webpackChunkName: "citizenservice-request-list-closing" */
    './components/requests/CitizenServiceRequestListClosingComponent.vue')
);

Vue.component('citizenservice-request-close', () => import(
    /* webpackChunkName: "citizenservice-request-close" */
    './components/requests/CitizenServiceRequestCloseComponent.vue')
);

Vue.component('citizenservice-report-create', () => import(
    /* webpackChunkName: "citizenservice-report-create" */
    './components/reports/CitizenServiceReportCreateComponent.vue')
);

Vue.component('citizenservice-register-create', () => import(
    /* webpackChunkName: "citizenservice-register-create" */
    './components/registers/CitizenServiceRegisterCreateComponent.vue')
);

Vue.component('citizenservice-register-list', () => import(
    /* webpackChunkName: "citizenservice-register-list" */
    './components/registers/CitizenServiceRegisterListComponent.vue')
);

Vue.component('citizenservice-register-info', () => import(
    /* webpackChunkName: "citizenservice-register-info" */
    './components/registers/CitizenServiceRegisterInfoComponent.vue')
);

Vue.component('citizenservice-departments', () => import(
    /* webpackChunkName: "citizenservice-departments" */
    './components/settings/CitizenServiceDepartmentsComponent.vue')
);
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
		getCitizenServiceDepartments() {
			this.citizen_service_departments = [];
			axios.get('/citizenservice/get-departments').then(response => {
				this.citizen_service_departments = response.data;
			});
		},

	},
});


//import uploader from 'vue-simple-uploader'


//Vue.use(uploader)

