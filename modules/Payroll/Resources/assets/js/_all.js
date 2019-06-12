/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts del Modulo de Nomina a compilar por la aplicación
*/

/**
 * Componente para mostrar listado de información socioeconómica
 *
 * @author William Páez (wpaez@cenditel.gob.ve)
 */
Vue.component('socioeconomic-informations', require('./components/PayrollSocioeconomicInformationComponent.vue').default);

/**
 * Componente para mostrar listado de información profesional
 *
 * @author William Páez (wpaez@cenditel.gob.ve)
 */
Vue.component('professional-informations', require('./components/PayrollProfessionalInformationComponent.vue').default);

/**
 * Componente para la gestión de tabuladores de nómina
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('payroll-tabulator', require('./components/PayrollTabulatorComponent.vue').default);

/**
 * Componente para la gestión de asignaciones de nómina
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('payroll-assignment-type', require('./components/PayrollAssignmentTypeComponent.vue').default);
Vue.component('payroll-assignment', require('./components/PayrollAssignmentComponent.vue').default);

/**
 * Componente para la gestión de calculos de salario
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('payroll-salary-simulator', require('./components/PayrollSalarySimulatorComponent.vue').default);

/**
 * Opciones de configuración global del módulo de Nómina
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.mixin({
	methods: {
		/**
		 * Obtiene los datos de los puestos de trabajo registrados en la institucion
		 *
		 * @author Henry Paredes (henryp2804@gmail.com)
		 */
		getStaffs() {
			const vm = this;
			vm.staffs = [];
			axios.get('/payroll/get-staffs').then(response => {
				vm.staffs = response.data;
			});
		},

		/**
		 * Obtiene los datos de los tipos de cargo registrados en la institucion
		 *
		 * @author Henry Paredes (henryp2804@gmail.com)
		 */
		getPositionTypes() {
			const vm = this;
			vm.position_types = [];
			axios.get('/payroll/get-position-types').then(response => {
				vm.position_types = response.data;
			});
		},

		/**
		 * Obtiene los datos de los tipos de asignaciones de nómina registradas
		 *
		 * @author Henry Paredes (henryp2804@gmail.com)
		 */
		getAssignmentTypes() {
			const vm = this;
			vm.assignment_types = [];
			axios.get('/payroll/get-assignment-types').then(response => {
				vm.assignment_types = response.data;
			});
		},

		/**
		 * Obtiene los datos de los cargos registrados en la institucion
		 *
		 * @author Henry Paredes (henryp2804@gmail.com)
		 */
		getPositions() {
			const vm = this;
			vm.positions = [];
			axios.get('/payroll/get-positions').then(response => {
				vm.positions = response.data;
			});
		},
		
	},
});