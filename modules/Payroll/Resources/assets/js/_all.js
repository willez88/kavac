/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts del Modulo de Nomina a compilar por la aplicación
*/

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staff-types', require('./components/settings/PayrollStaffTypesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de cargo
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-position-types', require('./components/settings/PayrollPositionTypesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de cargos
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-positions', require('./components/settings/PayrollPositionsComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de la clasificación del personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staff-classifications', require('./components/settings/PayrollStaffClassificationsComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos del grado de instrucción
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-instruction-degrees', require('./components/settings/PayrollInstructionDegreesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos del tipo de estudio
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-study-types', require('./components/settings/PayrollStudyTypesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de nacionalidades
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-nationalities', require('./components/settings/PayrollNationalitiesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de los idiomas
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-languages', require('./components/settings/PayrollLanguagesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de los niveles de idioma
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-language-levels', require('./components/settings/PayrollLanguageLevelsComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de los géneros
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-genders', require('./components/settings/PayrollGendersComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de inactividad
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-inactivity-types', require('./components/settings/PayrollInactivityTypesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de contrato
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-contract-types', require('./components/settings/PayrollContractTypesComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de sector
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-sector-types', require('./components/settings/PayrollSectorTypesComponent.vue').default);

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
			this.payroll_instruction_degree = [];
			axios.get('/payroll/get-instruction-degrees').then(response => {
				this.payroll_instruction_degrees = response.data;
			});
		},

		/**
		 * Obtiene los datos de tipos de inactividad registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollInactivityTypes() {
			this.payroll_inactivity_types = [];
			axios.get('/payroll/get-inactivity-types').then(response => {
				this.payroll_inactivity_types = response.data;
			});
		},

		/**
		 * Obtiene los datos de tipos de personal registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollStaffTypes() {
			this.payroll_staff_types = [];
			axios.get('/payroll/get-staff-types').then(response => {
				this.payroll_staff_types = response.data;
			});
		},

		/**
		 * Obtiene los datos de tipos de contrato registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollContractTypes() {
			this.payroll_contract_types = [];
			axios.get('/payroll/get-contract-types').then(response => {
				this.payroll_contract_types = response.data;
			});
		},
	},
});
