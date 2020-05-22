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
Vue.component('payroll-staff-types', () => import(
    /* webpackChunkName: "payroll-staff-types" */
    './components/settings/PayrollStaffTypesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de cargo
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-position-types', () => import(
    /* webpackChunkName: "payroll-position-types" */
    './components/settings/PayrollPositionTypesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de cargos
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-positions', () => import(
    /* webpackChunkName: "payroll-positions" */
    './components/settings/PayrollPositionsComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de la clasificación del personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staff-classifications', () => import(
    /* webpackChunkName: "payroll-staff-classifications" */
    './components/settings/PayrollStaffClassificationsComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos del grado de instrucción
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-instruction-degrees', () => import(
    /* webpackChunkName: "payroll-instruction-degrees" */
    './components/settings/PayrollInstructionDegreesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos del tipo de estudio
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-study-types', () => import(
    /* webpackChunkName: "payroll-study-types" */
    './components/settings/PayrollStudyTypesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de nacionalidades
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-nationalities', () => import(
    /* webpackChunkName: "payroll-nationalities" */
    './components/settings/PayrollNationalitiesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de los idiomas
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-languages', () => import(
    /* webpackChunkName: "payroll-languages" */
    './components/settings/PayrollLanguagesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de los niveles de idioma
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-language-levels', () => import(
    /* webpackChunkName: "payroll-language-levels" */
    './components/settings/PayrollLanguageLevelsComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de los géneros
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-genders', () => import(
    /* webpackChunkName: "payroll-genders" */
    './components/settings/PayrollGendersComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de inactividad
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-inactivity-types', () => import(
    /* webpackChunkName: "payroll-inactivity-types" */
    './components/settings/PayrollInactivityTypesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de contrato
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-contract-types', () => import(
    /* webpackChunkName: "payroll-contract-types" */
    './components/settings/PayrollContractTypesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de sector
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-sector-types', () => import(
    /* webpackChunkName: "payroll-sector-types" */
    './components/settings/PayrollSectorTypesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de grados de licencia de conducir
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-license-degrees', () => import(
    /* webpackChunkName: "payroll-license-degrees" */
    './components/settings/PayrollLicenseDegreesComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de sangre
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-blood-types', () => import(
    /* webpackChunkName: "payroll-blood-types" */
    './components/settings/PayrollBloodTypesComponent.vue')
);

/**
 * Componente para mostrar listado de información personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staffs-list', () => import(
    /* webpackChunkName: "payroll-staffs-list" */
    './components/PayrollStaffListComponent.vue')
);

/**
 * Componente para registrar o actualizar información personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staff', () => import(
    /* webpackChunkName: "payroll-staff" */
    './components/PayrollStaffComponent.vue')
);

/**
 * Componente para mostrar listado de información socioeconómica
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-socioeconomic-list', () => import(
    /* webpackChunkName: "payroll-socioeconomic-list" */
    './components/PayrollSocioeconomicListComponent.vue')
);

/**
 * Componente para registrar o actualizar información socioeconómica
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-socioeconomic', () => import(
    /* webpackChunkName: "payroll-socioeconomic" */
    './components/PayrollSocioeconomicComponent.vue')
);

/**
 * Componente para mostrar listado de información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-professional-informations-list', () => import(
    /* webpackChunkName: "payroll-professional-informations-list" */
    './components/PayrollProfessionalInformationListComponent.vue')
);

/**
 * Componente para registrar o actualizar información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-professional-information', () => import(
    /* webpackChunkName: "payroll-professional-information" */
    './components/PayrollProfessionalInformationComponent.vue')
);

/**
 * Componente para mostrar listado de información laboral
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-employment-informations-list', () => import(
    /* webpackChunkName: "payroll-employment-informations-list" */
    './components/PayrollEmploymentInformationListComponent.vue')
);

/**
 * Componente para registrar o actualizar información laboral
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-employment-information', () => import(
    /* webpackChunkName: "payroll-employment-information" */
    './components/PayrollEmploymentInformationComponent.vue')
);

/**
 * Componente para la gestión de los escalafones de nomina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-salary-scale', () => import(
    /* webpackChunkName: "payroll-salary-scale" */
    './components/PayrollSalaryScaleComponent.vue')
);

/**
 * Componente para la gestión de tabuladores de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-salary-tabulator', () => import(
    /* webpackChunkName: "payroll-salary-tabulator" */
    './components/PayrollSalaryTabulatorComponent.vue')
);

/**
 * Componente para la gestión de tipos de asignaciones de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-salary-assignment-type', () => import(
    /* webpackChunkName: "payroll-salary-assignment-type" */
    './components/PayrollSalaryAssignmentTypeComponent.vue')
);

/**
 * Componente para la gestión de asignaciones de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-salary-assignment', () => import(
    /* webpackChunkName: "payroll-salary-assignment" */
    './components/PayrollSalaryAssignmentComponent.vue')
);

/**
 * Componente para la gestión de conceptos de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-concepts', () => import(
    /* webpackChunkName: "payroll-concepts" */
    './components/settings/PayrollConceptsComponent.vue')
);

Vue.component('payroll-concept-types', () => import(
    /* webpackChunkName: "payroll-concept-types" */
    './components/settings/PayrollConceptTypesComponent.vue')
);

/**
 * Componente para la gestión de tipos de pago
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-payment-types', () => import(
    /* webpackChunkName: "payroll-payment-types" */
    './components/settings/PayrollPaymentTypesComponent.vue')
);

/**
 * Componente para la gestión de calculos de salario
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
//Vue.component('payroll-salary-simulator', () => import('./components/PayrollSalarySimulatorComponent.vue'));

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
		 * Obtiene los datos de las profesiones (pruebas)
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getJsonProfessions() {
			this.json_professions = [];
			axios.get('/payroll/get-json-professions').then(response => {
				this.json_professions = response.data.jsonProfessions;
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

		/**
		 * Obtiene los datos de tipos de contrato registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		 getPayrollSectorTypes() {
			this.payroll_sector_types = [];
			axios.get('/payroll/get-sector-types').then(response => {
				this.payroll_sector_types = response.data;
			});
		},

		/**
		 * Obtiene los datos de grados de licencia de conducir registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		 getPayrollLicenseDegrees() {
			this.payroll_license_degrees = [];
			axios.get('/payroll/get-license-degrees').then(response => {
				this.payroll_license_degrees = response.data;
			});
		},

		/**
		 * Obtiene los datos de tipos de sangre registrados
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		 getPayrollBloodTypes() {
			this.payroll_blood_types = [];
			axios.get('/payroll/get-blood-types').then(response => {
				this.payroll_blood_types = response.data;
			});
		},
	},
});
