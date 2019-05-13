
/**
 * Componente para mostrar listado del clasificador de cuentas presupuestarias
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-accounts-list', require('./components/BudgetAccountsListComponent.vue'));

/**
 * Componente para mostrar listado de proyectos
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-projects-list', require('./components/BudgetProjectsListComponent.vue'));

/**
 * Componente para mostrar listado de acciones centralizadas
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-centralized-actions-list', require('./components/BudgetCentralizedActionsListComponent.vue'));

/**
 * Componente para mostrar listado de acciones centralizadas
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-specific-actions-list', require('./components/BudgetSpecificActionsListComponent.vue'));

/**
 * Componente para mostrar listado de formulaciones de presupuesto
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-formulation-list', require('./components/BudgetSubSpecificFormulationListComponent.vue'));

/**
 * Componente para mostrar formulario de formulación de presupuesto por sub específica
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-sub-specific-formulation', require('./components/BudgetSubSpecificFormulationComponent.vue'));

/**
 * Componente para getionar las modificaciones presupuestarias
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-modification', require('./components/BudgetModificationComponent.vue'));

/**
 * Componente para mostrar listado de créditos adicionales
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-modification-list', require('./components/BudgetModificationListComponent.vue'));

/**
 * Componente para agregar cuentas al registro o actualización de créditos adicionales
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('budget-aditional-credit-add', require('./components/BudgetAditionalCreditAddComponent.vue'));

/**
 * Opciones de configuración global del módulo de presupuesto
 * 
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.mixin({
	data() {
		return {
			execution_year: ''
		}
	},
	mounted() {
		// Agregar instrucciones para determinar el año de ejecución
	}
});