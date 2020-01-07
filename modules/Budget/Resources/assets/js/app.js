/**
 * Componente para mostrar listado del clasificador de cuentas presupuestarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-accounts-list', require('./components/BudgetAccountsListComponent.vue').default);

/**
 * Componente para mostrar listado de proyectos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-projects-list', require('./components/BudgetProjectsListComponent.vue').default);

/**
 * Componente para mostrar listado de acciones centralizadas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-centralized-actions-list', require('./components/BudgetCentralizedActionsListComponent.vue').default);

/**
 * Componente para mostrar listado de acciones centralizadas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-specific-actions-list', require('./components/BudgetSpecificActionsListComponent.vue').default);

/**
 * Componente para mostrar listado de formulaciones de presupuesto
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-formulation-list', require('./components/BudgetSubSpecificFormulationListComponent.vue').default);

/**
 * Componente para mostrar formulario de formulación de presupuesto por sub específica
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-sub-specific-formulation', require('./components/BudgetSubSpecificFormulationComponent.vue').default);

/**
 * Componente para getionar las modificaciones presupuestarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-mod', require('./components/BudgetModificationComponent.vue').default);

/**
 * Componente para mostrar listado de créditos adicionales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-mod-list', require('./components/BudgetModificationListComponent.vue').default);

/**
 * Componente para agregar cuentas al registro o actualización de créditos adicionales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-aditional-credit-add', require('./components/BudgetAditionalCreditAddComponent.vue').default);

/**
 * Componente para mostrar listado de compromisos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-compromise-list', require('./components/BudgetCompromisesListComponent.vue').default);

/**
 * Componente para getionar los compromisos presupuestarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-compromise', require('./components/BudgetCompromiseComponent.vue').default);

/**
 * Opciones de configuración global del módulo de presupuesto
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.mixin(
    {
        data() {
            return {
                /** @type {String} Especifica el año de ejercicio presupuestario en curso */
                execution_year: ''
            }
        },
        mounted() {
            // Agregar instrucciones para determinar el año de ejecución
        }
    }
);
