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

Vue.component('citizenservice-request-pending', () => import(
    /* webpackChunkName: "citizenservice-request-pending" */
    './components/requests/CitizenServiceRequestPendingComponent.vue')
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


        /**
         * Obtiene los Estados del Pais seleccionado
         *
         * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         */
        async getEstates() {
            const vm = this;
            vm.estates = [];
            if (vm.record.country_id) {
                await axios.get(`/get-estates/${vm.record.country_id}`).then(response => {
                    vm.estates = response.data;
                });
                if (vm.record.id) {
                    vm.record.estate_id = vm.record.parish.municipality.estate_id;
                }
            }
        },
         /**
         * Obtiene las ciudades del Estado seleccionado
         *
         * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         * @author Ing. Yennifer RRamirez <yramirez@cenditel.gob.ve> 
         */
        async getCities() {
            const vm = this;
            vm.cities = [];
            if (vm.record.estate_id) {
                await axios.get(`/get-cities/${vm.record.estate_id}`).then(response => {
                    vm.cities = response.data;
                });
                if (vm.record.id) {
                    vm.record.city_id = vm.record.city.id;
                }
            }
        },
        /**
         * Obtiene los Municipios del Estado seleccionado
         *
         * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         *
         * 
         */
        async getMunicipalities() {
            const vm = this;
            vm.municipalities = [];
            if (vm.record.estate_id) {
                await axios.get(`/get-municipalities/${vm.record.estate_id}`).then(response => {
                    vm.municipalities = response.data;
                });
                if (vm.record.id) {
                    vm.record.municipality_id = vm.record.parish.municipality_id;
                }
            }
        },
        /**
         * Obtiene las parroquias del municipio seleccionado
         *
         * @author William Páez <wpaez@cenditel.gob.ve>
         */
        async getParishes() {
            const vm = this;
            vm.parishes = [];
            if (vm.record.municipality_id) {
                await axios.get(`/get-parishes/${vm.record.municipality_id}`).then(response => {
                    vm.parishes = response.data;
                });
                if (vm.record.id) {
                    vm.record.parish_id = vm.record.parish.id;
                }
            }
        },
        /**
         * Método que establece los datos del registro seleccionado para el cual se desea mostrar detalles
         *
         * @method    setDetails
         *
         * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve>
         *
         * @param     string   ref       Identificador del componente
         * @param     integer  id        Identificador del registro seleccionado
         */
        setDetails(ref, id) {
            const vm = this;
            vm.$refs[ref].record = vm.$refs.tableResults.data.filter(r => {
                return r.id === id;
            })[0];
        },

	},
});


//import uploader from 'vue-simple-uploader'


//Vue.use(uploader)

