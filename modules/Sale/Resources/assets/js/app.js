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
Vue.component('sale-payment-method', () => import(
    /* webpackChunkName: "sale-payment-method" */
    './components/settings/SalePaymentMethodComponent.vue')
);
/**
 * Componente para listar, crear, actualizar y borrar datos de almacén
 *
 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
 */
Vue.component('sale-warehouse-method', () => import(
    /* webpackChunkName: "sale-warehouse-method" */
    './components/settings/SaleWarehouseMethodComponent.vue')
);

/**
 * Componente para gestionar el formato de codigo
 *
 * @author José Puentes <jpuentes@cenditel.gob.ve>
 */
Vue.component('register-formatcode', () => import(
    /* webpackChunkName: "register-formatcode" */
    './components/settings/SaleCodeFormatComponent.vue')
);

/**
 * Componente para gestionar los clientes
 *
 * @author José Puentes <jpuentes@cenditel.gob.ve>
 */
Vue.component('register-clients', () => import(
    /* webpackChunkName: "register-clients" */
    './components/settings/SaleClientsComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de los productos
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-setting-product', () => import(
    /* webpackChunkName: "sale-setting-product" */
    './components/settings/SaleSettingProductComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de los productos
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-setting-product-type', () => import(
    /* webpackChunkName: "sale-setting-product-type" */
    './components/settings/SaleSettingProductTypeComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de Descuento
 *
 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
 */
Vue.component('sale-discount', () => import(
    /* webpackChunkName: "sale-discount" */
    './components/settings/SaleDiscountComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar cotizaciones
 *
 * @author Jose Puentes <jpuentes@cenditel.gob.ve>
 */
Vue.component('sale-quote', () => import(
    './components/settings/SaleQuoteComponent.vue')
);

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
			axios.get('/sale/get-setting-product').then(response => {
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
			axios.get('/sale/get-setting-product-type').then(response => {
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

		/**
		 * Obtiene los datos de las formas de Descuento
		 *
		 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
		 */
		getSaleDiscount() {
			const vm = this;
			vm.sale_descount_method = [];
			axios.get('/sale/get-saledescount').then(response => {
				vm.sale_descount_method = response.data;
			});
		},
	},
});
