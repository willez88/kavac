/**
 * Componente para mostrar listado del clasificador de cuentas presupuestarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-accounts-list', () => import(
    /* webpackChunkName: "budget-accounts-list" */
    './components/BudgetAccountsListComponent.vue')
);

/**
 * Componente para mostrar listado de proyectos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-projects-list', () => import(
    /* webpackChunkName: "budget-projects-list" */
    './components/BudgetProjectsListComponent.vue')
);

/**
 * Componente para mostrar listado de acciones centralizadas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-centralized-actions-list', () => import(
    /* webpackChunkName: "budget-centralized-actions-list" */
    './components/BudgetCentralizedActionsListComponent.vue')
);

/**
 * Componente para mostrar listado de acciones centralizadas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-specific-actions-list', () => import(
    /* webpackChunkName: "budget-specific-actions-list" */
    './components/BudgetSpecificActionsListComponent.vue')
);

/**
 * Componente para mostrar listado de formulaciones de presupuesto
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-formulation-list', () => import(
    /* webpackChunkName: "budget-subspecific-formulation-list" */
    './components/BudgetSubSpecificFormulationListComponent.vue')
);

/**
 * Componente para mostrar formulario de formulación de presupuesto por sub específica
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-sub-specific-formulation', () => import(
    /* webpackChunkName: "budget-subspecific-formulation" */
    './components/BudgetSubSpecificFormulationComponent.vue')
);

/**
 * Componente para getionar las modificaciones presupuestarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @todo Problema al cargar con lazy load
 */
Vue.component('budget-mod', () => import(
    /* webpackChunkName: "budget-modification" */
    './components/BudgetModificationComponent.vue')
);

/**
 * Componente para mostrar listado de créditos adicionales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @todo Problema al cargar con lazy load
 */
Vue.component('budget-mod-list', () => import(
    /* webpackChunkName: "budget-modification-list" */
    './components/BudgetModificationListComponent.vue')
);

/**
 * Componente para agregar cuentas al registro o actualización de créditos adicionales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
//Vue.component('budget-aditional-credit-add', require('./components/BudgetAditionalCreditAddComponent.vue').default);

/**
 * Componente para mostrar listado de compromisos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-compromise-list', () => import(
    /* webpackChunkName: "budget-compromises-list" */
    './components/BudgetCompromisesListComponent.vue')
);

/**
 * Componente para getionar los compromisos presupuestarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('budget-compromise', () => import(
    /* webpackChunkName: "budget-compromise" */
    './components/BudgetCompromiseComponent.vue')
);

/**
 * Componente para mostrar el formulario de disponibilidad presupuestaria
 *
 * @author Jonathan Alvarado <wizardx1407@gmail.com> | <jonathanalvarado1407@gmail.com>
 */
Vue.component('budget-availability', () => import(
    /* webpackChunkName: "budget-availability" */
    './components/BudgetAvailabilityComponent.vue')
);

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
