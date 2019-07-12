/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts del Modulo de Nomina a compilar por la aplicación
*/

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de inactividad
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-inactivity-types', require('./components/PayrollInactivityTypesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de contrato
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-contract-types', require('./components/PayrollContractTypesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de sector
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-sector-types', require('./components/PayrollSectorTypesComponent.vue').default);

/**
 * Componente para mostrar listado de información personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staffs-list', require('./components/PayrollStaffListComponent.vue').default);

/**
 * Componente para registrar o actualizar información personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staff', require('./components/PayrollStaffComponent.vue').default);

/**
 * Componente para mostrar listado de información socioeconómica
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-socioeconomic-informations-list', require('./components/PayrollSocioeconomicInformationListComponent.vue').default);

/**
 * Componente para registrar o actualizar información socioeconómica
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-socioeconomic-information', require('./components/PayrollSocioeconomicInformationComponent.vue').default);

/**
 * Componente para mostrar listado de información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-professional-informations-list', require('./components/PayrollProfessionalInformationListComponent.vue').default);

/**
 * Componente para registrar o actualizar información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-professional-information', require('./components/PayrollProfessionalInformationComponent.vue').default);

/**
 * Componente para mostrar listado de información laboral
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-employment-informations-list', require('./components/PayrollEmploymentInformationListComponent.vue').default);

/**
 * Componente para registrar o actualizar información laboral
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-employment-information', require('./components/PayrollEmploymentInformationComponent.vue').default);

/**
 * Componente para la gestión de tabuladores de nómina
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('payroll-salary-tabulator', require('./components/PayrollSalaryTabulatorComponent.vue').default);

/**
 * Componente para la gestión de asignaciones de nómina
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('payroll-salary-assignment-type', require('./components/PayrollSalaryAssignmentTypeComponent.vue').default);
Vue.component('payroll-salary-assignment', require('./components/PayrollSalaryAssignmentComponent.vue').default);

/**
 * Componente para la gestión de calculos de salario
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
//Vue.component('payroll-salary-simulator', require('./components/PayrollSalarySimulatorComponent.vue').default);

/**
 * Opciones de configuración global del módulo de Nómina
 */
Vue.mixin({
	methods: {

		/**
		 * Obtiene los datos de los tipos de asignaciones salariales registradas
		 *
		 * @author Henry Paredes (henryp2804@gmail.com)
		 */
		getPayrollSalaryAssignmentTypes() {
			const vm = this;
			vm.payroll_salary_assignment_types = [];
			axios.get('/payroll/get-salary-assignment-types').then(response => {
				vm.payroll_salary_assignment_types = response.data;
			});
		},

		/**
		 * Obtiene los datos de las nacionalidades registradas
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollNationalities() {
			this.payroll_nationalities = [];
			axios.get('/payroll/get-nationalities').then(response => {
				this.payroll_nationalities = response.data;
			});
		},

		/**
		 * Obtiene los datos de los géneros registradas
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollGenders() {
			this.payroll_genders = [];
			axios.get('/payroll/get-genders').then(response => {
				this.payroll_genders = response.data;
			});
		},

		/**
		 * Obtiene los datos de los tipos de cargo registrados en la institucion
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollPositionTypes() {
			const vm = this;
			vm.payroll_position_types = [];
			axios.get('/payroll/get-position-types').then(response => {
				vm.payroll_position_types = response.data;
			});
		},

		/**
		 * Obtiene los datos de los cargos registrados en la institucion
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollPositions() {
			const vm = this;
			vm.payroll_positions = [];
			axios.get('/payroll/get-positions').then(response => {
				vm.payroll_positions = response.data;
			});
		},

		/**
		 * Obtiene los datos de los trabajadores registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollStaffs() {
			this.payroll_staffs = [];
			axios.get('/payroll/get-staffs').then(response => {
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
			axios.get('/payroll/get-study-types').then(response => {
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
			axios.get('/payroll/get-languages').then(response => {
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
			axios.get('/payroll/get-language-levels').then(response => {
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
			axios.get('/payroll/get-instruction-degrees').then(response => {
				this.payroll_instruction_degrees = response.data;
			});
		},
	},
});
