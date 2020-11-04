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
 * Componentes para gestionar los ingresos de productos al almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-warehouse-reception-create', () => import(
    /* webpackChunkName: "sale-warehouse-reception-create" */
    './components/receptions/SaleWarehouseReceptionCreateComponent.vue')
);

/**
 * Componente para mostrar un listado de los ingresos de productos al almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-warehouse-reception-list', () => import(
    /* webpackChunkName: "sale-warehouse-reception-list" */
    './components/receptions/SaleWarehouseReceptionListComponent.vue')
);

/**
 * Componente para mostrar un listado de los ingresos de productos al almacén pendientes por ejecutar
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-warehouse-reception-pending-list', () => import(
    /* webpackChunkName: "sale-warehouse-reception-pending-list" */
    './components/receptions/SaleWarehouseReceptionPendingListComponent.vue')
);

/**
 * Componente para mostrar la información de los ingresos de almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-warehouse-reception-info', () => import(
    /* webpackChunkName: "sale-warehouse-reception-info" */
    './components/receptions/SaleWarehouseReceptionInfoComponent.vue')
);

/*
 * Componente para listar, crear, actualizar y borrar cotizaciones
 *
 * @author Jose Puentes <jpuentes@cenditel.gob.ve>
 */
Vue.component('sale-quote', () => import(
    './components/settings/SaleQuoteComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de las formas de pago
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-setting-deposit', () => import(
    /* webpackChunkName: "sale-setting-deposit" */
    './components/settings/SaleSettingDepositComponent.vue')
);

/**
 * Componente para listar, crear, actualizar y borrar datos de Gestión de Pedidos
 *
 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
 */
Vue.component('sale-order-management-method', () => import(
    /* webpackChunkName: "sale-ordermanagement-method" */
    './components/settings/SaleOrderManagementMethodComponent.vue')
);

/**
 * Componente para gestionar la creación de los reportes de almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 */
Vue.component('sale-report-products', () => import(
    /* webpackChunkName: "sale-report-products" */
    './components/reports/SaleReportProductsComponent.vue')
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
		
		/**
		 * Obtiene los datos de las formas de pago
		 *
		 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
		 */
		getSaleSettingDeposit() {
			const vm = this;
			vm.sale_setting_deposit = [];
			axios.get('/sale/get-setting-deposit').then(response => {
				vm.sale_setting_deposit = response.data;
			});
		},

		/**
		 * Obtiene los datos de Gestión de Pedidos de comercialización
		 *
		 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
		 */
		getSaleOrderManagementMethod() {
			const vm = this;
			vm.sale_warehouse_method = [];
			axios.get('/sale/get-saleordermanagementmethod').then(response => {
				vm.sale_order_management_method = response.data;
			});
		},
	},
});