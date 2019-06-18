/**
 * Componente para la gestión de las ramas de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-branches', require('./components/PurchaseSupplierBranchComponent.vue').default);

/**
 * Componente para la gestión de los objetos de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-objects', require('./components/PurchaseSupplierObjectComponent.vue').default);

/**
 * Componente para la gestión de las especialidades de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-specialties', require('./components/PurchaseSupplierSpecialtyComponent.vue').default);

/**
 * Componente para la gestión de los tipos de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-types', require('./components/PurchaseSupplierTypeComponent.vue').default);

/**
 * Componente para la gestión de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-suppliers-list', require('./components/PurchaseSupplierListComponent.vue').default);

/**
 * Opciones de configuración global del módulo de compras
 * 
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.mixin({
	data() {
		return {}
	},
	mounted() {
		
	}
});