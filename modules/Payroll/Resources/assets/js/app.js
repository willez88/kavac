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
Vue.component('payroll-staff-types', () =>
	import(
		/* webpackChunkName: "payroll-staff-types" */
		'./components/settings/PayrollStaffTypesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de cargo
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-position-types', () =>
	import(
		/* webpackChunkName: "payroll-position-types" */
		'./components/settings/PayrollPositionTypesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de cargos
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-positions', () =>
	import(
		/* webpackChunkName: "payroll-positions" */
		'./components/settings/PayrollPositionsComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de la clasificación del personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staff-classifications', () =>
	import(
		/* webpackChunkName: "payroll-staff-classifications" */
		'./components/settings/PayrollStaffClassificationsComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos del grado de instrucción
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-instruction-degrees', () =>
	import(
		/* webpackChunkName: "payroll-instruction-degrees" */
		'./components/settings/PayrollInstructionDegreesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos del tipo de estudio
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-study-types', () =>
	import(
		/* webpackChunkName: "payroll-study-types" */
		'./components/settings/PayrollStudyTypesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de nacionalidades
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-nationalities', () =>
	import(
		/* webpackChunkName: "payroll-nationalities" */
		'./components/settings/PayrollNationalitiesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de los idiomas
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-languages', () =>
	import(
		/* webpackChunkName: "payroll-languages" */
		'./components/settings/PayrollLanguagesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de los niveles de idioma
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-language-levels', () =>
	import(
		/* webpackChunkName: "payroll-language-levels" */
		'./components/settings/PayrollLanguageLevelsComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de los géneros
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-genders', () =>
	import(
		/* webpackChunkName: "payroll-genders" */
		'./components/settings/PayrollGendersComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de inactividad
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-inactivity-types', () =>
	import(
		/* webpackChunkName: "payroll-inactivity-types" */
		'./components/settings/PayrollInactivityTypesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de contrato
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-contract-types', () =>
	import(
		/* webpackChunkName: "payroll-contract-types" */
		'./components/settings/PayrollContractTypesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de sector
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-sector-types', () =>
	import(
		/* webpackChunkName: "payroll-sector-types" */
		'./components/settings/PayrollSectorTypesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de grados de licencia de conducir
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-license-degrees', () =>
	import(
		/* webpackChunkName: "payroll-license-degrees" */
		'./components/settings/PayrollLicenseDegreesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de sangre
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-blood-types', () =>
	import(
		/* webpackChunkName: "payroll-blood-types" */
		'./components/settings/PayrollBloodTypesComponent.vue'
	)
);

/**
 * Componente para mostrar listado de información personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staffs-list', () =>
	import(
		/* webpackChunkName: "payroll-staffs-list" */
		'./components/PayrollStaffListComponent.vue'
	)
);

/**
 * Componente para registrar o actualizar información personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-staff', () =>
	import(
		/* webpackChunkName: "payroll-staff" */
		'./components/PayrollStaffComponent.vue'
	)
);

/**
 * Componente para mostrar listado de información socioeconómica
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-socioeconomic-list', () =>
	import(
		/* webpackChunkName: "payroll-socioeconomic-list" */
		'./components/PayrollSocioeconomicListComponent.vue'
	)
);

/**
 * Componente para registrar o actualizar información socioeconómica
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-socioeconomic', () =>
	import(
		/* webpackChunkName: "payroll-socioeconomic" */
		'./components/PayrollSocioeconomicComponent.vue'
	)
);

/**
 * Componente para mostrar listado de información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-professional-list', () =>
	import(
		/* webpackChunkName: "payroll-professional-list" */
		'./components/PayrollProfessionalListComponent.vue'
	)
);

/**
 * Componente para registrar o actualizar información profesional
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-professional', () =>
	import(
		/* webpackChunkName: "payroll-professional" */
		'./components/PayrollProfessionalComponent.vue'
	)
);

/**
 * Componente para mostrar listado de datos laborales
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-employment-list', () =>
	import(
		/* webpackChunkName: "payroll-employment-list" */
		'./components/PayrollEmploymentListComponent.vue'
	)
);

/**
 * Componente para registrar o actualizar datos laborales
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 */
Vue.component('payroll-employment', () =>
	import(
		/* webpackChunkName: "payroll-employment" */
		'./components/PayrollEmploymentComponent.vue'
	)
);

/**
 * Componente para la gestión de los parámetros de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-parameters', () =>
	import(
		/* webpackChunkName: "payroll-parameters" */
		'./components/settings/PayrollParametersComponent.vue'
	)
);

/**
 * Componente para la gestión de los escalafones de nomina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-salary-scales', () =>
	import(
		/* webpackChunkName: "payroll-salary-scales" */
		'./components/settings/PayrollSalaryScalesComponent.vue'
	)
);

/**
 * Componente para la gestión de tabuladores de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-salary-tabulators', () =>
	import(
		/* webpackChunkName: "payroll-salary-tabulators" */
		'./components/settings/PayrollSalaryTabulatorsComponent.vue'
	)
);

/**
 * Componente para la gestión de tipos de conceptos de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-concept-types', () =>
	import(
		/* webpackChunkName: "payroll-concept-types" */
		'./components/settings/PayrollConceptTypesComponent.vue'
	)
);

/**
 * Componente para la gestión de conceptos de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-concepts', () =>
	import(
		/* webpackChunkName: "payroll-concepts" */
		'./components/settings/PayrollConceptsComponent.vue'
	)
);

/**
 * Componente para la gestión de tipos de pago
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-payment-types', () =>
	import(
		/* webpackChunkName: "payroll-payment-types" */
		'./components/settings/PayrollPaymentTypesComponent.vue'
	)
);

/**
 * Componente para la gestión de políticas vacacionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-vacation-policies', () =>
	import(
		/* webpackChunkName: "payroll-vacation-policies" */
		'./components/settings/PayrollVacationPoliciesComponent.vue'
	)
);

/**
 * Componente para la gestión de políticas de prestaciones sociales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-benefits-policies', () =>
	import(
		/* webpackChunkName: "payroll-benefits-policies" */
		'./components/settings/PayrollBenefitsPoliciesComponent.vue'
	)
);

/**
 * Componente para registrar o actualizar la nómina de sueldos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-registers-form', () =>
	import(
		/* webpackChunkName: "payroll-registers-form" */
		'./components/registers/PayrollFormComponent.vue'
	)
);

/**
 * Componente para mostrar listado de registros de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-registers-show', () =>
	import(
		/* webpackChunkName: "payroll-registers-show" */
		'./components/registers/PayrollShowComponent.vue'
	)
);

/**
 * Componente para mostrar listado de registros de nómina
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-registers-list', () =>
	import(
		/* webpackChunkName: "payroll-registers-list" */
		'./components/registers/PayrollListComponent.vue'
	)
);

/**
 * Componente para registrar ajustes en tablas salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-salary-adjustments-form', () =>
	import(
		/* webpackChunkName: "payroll-salary-adjustments-form" */
		'./components/salary_adjustments/PayrollSalaryAdjustmentsFormComponent.vue'
	)
);

/**
 * Componente para mostrar el listado de las solicitudes vacacionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-vacation-request-list', () =>
	import(
		/* webpackChunkName: "payroll-vacation-request-list" */
		'./components/requests/vacations/PayrollVacationRequestListComponent.vue'
	)
);

/**
 * Componente para mostrar la información de una solicitud de vacaciones
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-vacation-request-show', () =>
	import(
		/* webpackChunkName: "payroll-vacation-request-show" */
		'./components/requests/vacations/PayrollVacationRequestShowComponent.vue'
	)
);

/**
 * Componente para registrar las solicitudes vacacionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-vacation-request-form', () =>
	import(
		/* webpackChunkName: "payroll-vacation-request-form" */
		'./components/requests/vacations/PayrollVacationRequestFormComponent.vue'
	)
);

/**
 * Componente para mostrar el listado de las solicitudes vacacionales pendientes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-vacation-request-pending-list', () =>
	import(
		/* webpackChunkName: "payroll-vacation-request-pending-list" */
		'./components/requests/vacations/PayrollVacationRequestPendingListComponent.vue'
	)
);

/**
 * Componente para aprobar/rechazar las solicitudes vacacionales pendientes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-review-vacation-request-pending-form', () =>
	import(
		/* webpackChunkName: "payroll-review-vacation-request-pending-form" */
		'./components/requests/vacations/PayrollReviewVacationRequestPendingFormComponent.vue'
	)
);

/**
 * Componente para mostrar el listado de las solicitudes de adelanto de prestaciones
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-benefits-request-list', () =>
	import(
		/* webpackChunkName: "payroll-benefits-request-list" */
		'./components/requests/benefits/PayrollBenefitsRequestListComponent.vue'
	)
);

/**
 * Componente para mostrar la información de una solicitud de adelanto de prestaciones
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-benefits-request-show', () =>
	import(
		/* webpackChunkName: "payroll-benefits-request-show" */
		'./components/requests/benefits/PayrollBenefitsRequestShowComponent.vue'
	)
);

/**
 * Componente para registrar las solicitudes de adelanto de prestaciones
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-benefits-request-form', () =>
	import(
		/* webpackChunkName: "payroll-benefits-request-form" */
		'./components/requests/benefits/PayrollBenefitsRequestFormComponent.vue'
	)
);

/**
 * Componente para mostrar el listado de las solicitudes de adelanto de prestaciones pendientes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-benefits-request-pending-list', () =>
	import(
		/* webpackChunkName: "payroll-benefits-request-pending-list" */
		'./components/requests/benefits/PayrollBenefitsRequestPendingListComponent.vue'
	)
);

/**
 * Componente para aprobar/rechazar las solicitudes de adelanto de prestaciones pendientes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-review-benefits-request-pending-form', () =>
	import(
		/* webpackChunkName: "payroll-review-benefits-request-pending-form" */
		'./components/requests/benefits/PayrollReviewBenefitsRequestPendingFormComponent.vue'
	)
);

/**
 * Componentes para gestionar la creación de los reportes de talento humano para los empleados
 *
 * @author Ezequiel <ebaptistae@cenditel.gob.ve>
 */
Vue.component('payroll-report-employment-status', () =>
	import(
		/* webpackChunkName: "payroll-report-emplyment-status" */
		'./components/reports/PayrollReportEmploymentStatusComponent.vue'
	)
);

/**
 * Componentes para gestionar la creación de los reportes de talento humano
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('payroll-report-vacation-enjoyment-summaries', () =>
	import(
		/* webpackChunkName: "payroll-report-vacation-enjoyment-summaries" */
		'./components/reports/PayrollReportVacationEnjoymentSummariesComponent.vue'
	)
);

Vue.component('payroll-report-vacation-status', () =>
	import(
		/* webpackChunkName: "payroll-report-vacation-status" */
		'./components/reports/PayrollReportVacationStatusComponent.vue'
	)
);

Vue.component('payroll-report-vacation-bonus-calculations', () =>
	import(
		/* webpackChunkName: "payroll-report-vacation-bonus-calculations" */
		'./components/reports/PayrollReportVacationBonusCalculationsComponent.vue'
	)
);

Vue.component('payroll-report-staff-vacation-enjoyment', () =>
	import(
		/* webpackChunkName: "payroll-report-staff-vacation-enjoyment" */
		'./components/reports/PayrollReportStaffVacationEnjoymentComponent.vue'
	)
);

/**
 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
 */
Vue.component('payroll-report-benefit-advances', () =>
	import(
		/* webpackChunkName: "payroll-report-advance-benefits" */
		'./components/reports/benefits/PayrollReportBenefitAdvancesComponent.vue'
	)
);

/**
 * Componente para gestionar políticas de permisos
 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
 */
Vue.component('payroll-permission-policies', () =>
	import(
		/* webpackChunkName: "payroll-permission-policies" */
		'./components/settings/PayrollPermissionPoliciesComponent.vue'
	)
);
/**
 * Componente para gestionar solicitud de permiso
 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
 */
Vue.component('payroll-permission-request-create', () =>
	import(
		/* webpackChunkName: "payroll-permission-policies" */
		'./components/requests/permissions/PayrollPermissionRequestCreateComponent.vue'
	)
);
/**
 * Componente para mostrar el listado de las solicitudes de permisos
 *
 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
 */
Vue.component('payroll-permission-request-list', () =>
	import(
		/* webpackChunkName: "payroll-permission-request-list" */
		'./components/requests/permissions/PayrollPermissionRequestListComponent.vue'
	)
);
/**
 * Componente que muestra información del permiso
 *
 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
 */
Vue.component('payroll-permission-request-info', () =>
	import(
		/* webpackChunkName: "payroll-permission-request-info" */
		'./components/requests/permissions/PayrollPermissionRequestInfoComponent.vue'
	)
);
/**
 * Componente para mostrar el listado de las solicitudes de permisos pendientes
 *
 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
 */
Vue.component('payroll-permission-request-pending-list', () =>
	import(
		/* webpackChunkName: "payroll-permission-request-pending-list" */
		'./components/requests/permissions/PayrollPermissionRequestPendingListComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de tipos de liquidación
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 */
Vue.component('payroll-settlement-types', () =>
	import(
		/* webpackChunkName: "payroll-settlement-types" */
		'./components/settings/PayrollSettlementTypesComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de parentescos
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 */
Vue.component('payroll-relationships', () =>
	import(
		/* webpackChunkName: "payroll-relationships" */
		'./components/settings/PayrollRelationshipsComponent.vue'
	)
);

/**
 * Componente para listar, crear, actualizar y borrar datos de discapacidades
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 */
Vue.component('payroll-disabilities', () =>
	import(
		/* webpackChunkName: "payroll-disabilities" */
		'./components/settings/PayrollDisabilitiesComponent.vue'
	)
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
		 * Método que obtiene un arreglo con los conceptos registrados
		 *
		 * @author    Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getPayrollConcepts() {
			const vm = this;
			vm.payroll_concepts = [];
			axios.get(`${window.app_url}/payroll/get-concepts`).then(response => {
				vm.payroll_concepts = response.data;
			});
		},
		/**
		 * Método que obtiene un arreglo con los tipos de conceptos registrados
		 *
		 * @author    Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getPayrollConceptTypes() {
			const vm = this;
			vm.payroll_concept_types = [];
			axios.get(`${window.app_url}/payroll/get-concept-types`).then(response => {
				vm.payroll_concept_types = response.data;
			});
		},
		/**
		 * Método que obtiene un arreglo con los tipos de pago registrados
		 *
		 * @author    Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getPayrollPaymentTypes() {
			const vm = this;
			vm.payroll_payment_types = [];
			axios.get(`${window.app_url}/payroll/get-payment-types`).then(response => {
				vm.payroll_payment_types = response.data;
			});
		},
		/**
		 * Método que obtiene un arreglo con los tipos de conceptos registrados
		 *
		 * @author    Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getPayrollSalaryTabulators() {
			const vm = this;
			vm.payroll_salary_tabulators = [];
			axios.get(`${window.app_url}/payroll/get-salary-tabulators`).then(response => {
				vm.payroll_salary_tabulators = response.data;
			});
		},

		/**
		 * Obtiene los datos de las nacionalidades registradas
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve>
		 */
		getPayrollNationalities() {
			this.payroll_nationalities = [];
			axios.get(`${window.app_url}/payroll/get-nationalities`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-genders`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-position-types`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-positions`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-staffs`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-study-types`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-languages`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-language-levels`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-instruction-degrees`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-json-professions`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-inactivity-types`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-staff-types`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-contract-types`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-sector-types`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-license-degrees`).then(response => {
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
			axios.get(`${window.app_url}/payroll/get-blood-types`).then(response => {
				this.payroll_blood_types = response.data;
			});
		},

		/**
		 * Obtiene los datos de políticas de permiso
		 *
		 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
		 */
		getPayrollPermissionPolicies() {
			this.payroll_permission_policies = [];
			axios.get(`${window.app_url}/payroll/get-permission-policies`).then(response => {
				this.payroll_permission_policies = response.data;
			});
		},

		/**
		 * Obtiene los datos de discapacidades registradas
		 *
		 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
		 */
		getPayrollDisabilities() {
			this.payroll_disabilities = [];
			axios.get(`${window.app_url}/payroll/get-disabilities`).then(response => {
				this.payroll_disabilities = response.data;
			});
		}
	}
});
