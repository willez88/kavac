/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts del Modulo de Commercialización a compilar por la aplicación
*/

/**
 * Componente para listar, crear, actualizar y borrar datos de formas de cobro
 *
 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
 */
Vue.component('sale-payment-method', require('./components/settings/SalePaymentMethodComponent.vue').default);
/**
 * Componente para listar, crear, actualizar y borrar datos de almacén
 *
 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
 */
Vue.component('sale-warehouse-method', require('./components/settings/SaleWarehouseMethodComponent.vue').default);

/**
 * Opciones de configuración global del módulo de Commercialización
 */
Vue.mixin({
	methods: {
		/**
		 * Obtiene los datos de las formas de cobro en la institucion
		 *
		 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
		 */
		getSalePaymentMethod() {
			const vm = this;
			vm.sale_payment_method = [];
			axios.get('/sale/get-paymentmethod').then(response => {
				vm.sale_payment_method = response.data;
			});
		},

		/**
		 * Obtiene los datos de los almacenes de comercialización
		 *
		 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
		 */
		getSaleWarehouseMethod() {
			const vm = this;
			vm.sale_warehouse_method = [];
			axios.get('/sale/get-salewarehousemethod').then(response => {
				vm.sale_warehouse_method = response.data;
			});
		},
	},
});