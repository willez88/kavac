/**
 * Componente para la gestión de las ramas de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-branch', require('./components/PurchaseSupplierBranchComponent.vue').default);

/**
 * Componente para la gestión de los objetos de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-object', require('./components/PurchaseSupplierObjectComponent.vue').default);

/**
 * Componente para la gestión de las especialidades de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-specialty', require('./components/PurchaseSupplierSpecialtyComponent.vue').default);

/**
 * Componente para la gestión de los tipos de proveedores
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
Vue.component('purchase-supplier-type', require('./components/PurchaseSupplierTypeComponent.vue').default);

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