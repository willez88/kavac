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
Vue.component('payroll-socioeconomic-informations-list', require('./components/PayrollSocioeconomicInformationListComponent.vue').default);

/**
 * Componente para mostrar listado de información socioeconómica
 *
 * @author William Páez (wpaez@cenditel.gob.ve)
 */
Vue.component('payroll-socioeconomic-information', require('./components/PayrollSocioeconomicInformationComponent.vue').default);

/**
 * Componente para mostrar listado de información profesional
 *
 * @author William Páez (wpaez@cenditel.gob.ve)
 */
Vue.component('payroll-professional-informations-list', require('./components/PayrollProfessionalInformationListComponent.vue').default);

/**
 * Componente para mostrar listado de información profesional
 *
 * @author William Páez (wpaez@cenditel.gob.ve)
 */
Vue.component('payroll-professional-information', require('./components/PayrollProfessionalInformationComponent.vue').default);

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

		/**
		 * Obtiene los datos de los trabajadores registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollStaffs() {
			this.payroll_staffs = [];
			//url por confirmar
			axios.get('/payroll/get-staffs/list').then(response => {
				this.payroll_staffs = response.data;
			});
		},

		/**
		 * Obtiene los datos de los tipos de estudio registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollStudyTypes() {
			this.payroll_study_types = [];
			//url por confirmar
			axios.get('/payroll/get-study-types/list').then(response => {
				this.payroll_study_types = response.data;
			});
		},

		/**
		 * Obtiene los datos del idioma que manejan los trabajdores
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollLanguages() {
			this.payroll_languages = [];
			//url por confirmar
			axios.get('/payroll/get-languages/list').then(response => {
				this.payroll_languages = response.data;
			});
		},

		/**
		 * Obtiene los datos del nivel de idioma que tienen los trabajadores
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollLanguageLevels() {
			this.payroll_language_levels = [];
			//url por confirmar
			axios.get('/payroll/get-language-levels/list').then(response => {
				this.payroll_language_levels = response.data;
			});
		},

		/**
		 * Obtiene los datos de los grados de instrucción registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollInstructionDegrees() {
			this.payroll_instruction_degree_id = [];
			//url por confirmar
			axios.get('/payroll/get-instruction-degrees/list').then(response => {
				this.payroll_instruction_degrees = response.data;
			});
		},
	},
});
