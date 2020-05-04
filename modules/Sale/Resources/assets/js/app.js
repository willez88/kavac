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
 * Componente para gestionar el formato de codigo
 *
 * @author José Puentes <jpuentes@cenditel.gob.ve>
 */
Vue.component('register-formatcode', require('./components/settings/SaleCodeFormatComponent.vue').default);

/**
 * Componente para gestionar los clientes
 *
 * @author José Puentes <jpuentes@cenditel.gob.ve>
 */
Vue.component('register-clients', require('./components/settings/SaleClientsComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de los productos
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-setting-product', require('./components/settings/SaleSettingProductComponent.vue').default);

/**
 * Componente para listar, crear, actualizar y borrar datos de los productos
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-setting-product-type', require('./components/settings/SaleSettingProductTypeComponent.vue').default);

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
		 * Obtiene los datos de los productos
		 *
		 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
		 */
		getSaleSettingProduct() {
			const vm = this;
			vm.sale_setting_product = [];
			axios.get('/sale/get-settingproduct').then(response => {
				vm.sale_setting_product = response.data;
			});
		},
		/**
		 * Obtiene los datos de los tipos de productos
		 *
		 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
		 */
		getSaleSettingProductType() {
			const vm = this;
			vm.sale_setting_product_type = [];
			axios.get('/sale/get-settingproducttype').then(response => {
				vm.sale_setting_product_type = response.data;
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
