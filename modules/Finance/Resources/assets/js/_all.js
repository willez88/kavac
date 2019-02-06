/**
 * Componente para la gestión de bancos
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('finance-banks', require('./components/FinanceBankComponent.vue'));

/**
 * Componente para la gestión de agencias bancarias
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('finance-banking-agencies', require('./components/FinanceBankingAgencyComponent.vue'));

/**
 * Componente para la gestión de tipos de cuenta bancaria
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('finance-account-types', require('./components/FinanceAccountTypeComponent.vue'));

/**
 * Componente para la gestión de cuentas bancarias
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('finance-bank-accounts', require('./components/FinanceBankAccountComponent.vue'));

/**
 * Componente para la gestión de chequeras
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('finance-checkbooks', require('./components/FinanceCheckbookComponent.vue'));

/**
 * Opciones de configuración global del módulo de presupuesto
 * 
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.mixin({
	data() {
		return {
			execution_year: ''
		}
	},
	methods: {
		getBanks: function() {
			axios.get('/finance/get-banks').then(response => {
				this.banks = response.data;
			});
		},
		getAgencies() {
			const vm = this;
			bank_id = this.record.finance_bank_id;
			if (bank_id) {
				axios.get('/finance/get-agencies/' + bank_id).then(response => {
					vm.agencies = response.data;
				}).catch(error => {
					console.log(error);
				});

				if ($("#bank_code").length) {
					axios.get('/finance/get-bank-info/' + bank_id).then(response => {
						if (response.data.result) {
							$("#bank_code").val(response.data.bank.code);
						}
					}).catch(error => {
						console.log(error);
					});
				}
			}
		},
		getAccountTypes: function() {
			axios.get('/finance/get-account-types').then(response => {
				this.account_types = response.data;
			});
		},
	},
	mounted() {
		// Agregar instrucciones para determinar el año de ejecución
	}
});