
/**
 * Componente para la gestión de las ramas de proveedores
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-branches', require('./components/PurchaseSupplierBranchComponent.vue').default);

/**
 * Componente para la gestión de los objetos de proveedores
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-objects', require('./components/PurchaseSupplierObjectComponent.vue').default);

/**
 * Componente para la gestión de las especialidades de proveedores
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-specialties', require('./components/PurchaseSupplierSpecialtyComponent.vue').default);

/**
 * Componente para la gestión de los tipos de proveedores
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-types', require('./components/PurchaseSupplierTypeComponent.vue').default);

/**
 * Componente para la gestión de proveedores
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-suppliers-list', require('./components/PurchaseSupplierListComponent.vue').default);

/**
 * Componente para la gestión de procesos de compras
 */
Vue.component('purchase-processes', require('./components/PurchaseProcessComponent.vue').default);

/**
 * Componente para la gestión de creacion y actualización de requerimientos 
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
 */
Vue.component('purchase-requirements', require('./components/requirements/PurchaseIndexComponent.vue').default);

/**
 * Componente para la gestión de creacion y actualización de requerimientos 
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
 */
Vue.component('purchase-requirements-form', require('./components/requirements/PurchaseFormComponent.vue').default);
Vue.component('purchase-requirements-form-show', require('./components/requirements/PurchaseFormShowComponent.vue').default);

/**
 * Componente para listar los presupuesto base 
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
 */
Vue.component('purchase-base-budget', require('./components/requirements/PurchaseBaseBudgetComponent.vue').default);

/**
 * Componente para la gestión de creacion y actualización de requerimientos 
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
 */
Vue.component('purchase-base-budget-form', require('./components/requirements/PurchaseBaseBudgetFormComponent.vue').default);


/**
 *  Componente generico del modulo de contabilidad para mostrar errores
 * 
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('purchase-show-errors', require('./components/PurchaseShowErrorsComponent.vue').default);

/**
 * Opciones de configuración global del módulo de compras
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.mixin(
    {
        data() {
            return {}
        },
        mounted() {

        }
    }
);
