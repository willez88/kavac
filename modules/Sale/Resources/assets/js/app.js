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
	},
});
