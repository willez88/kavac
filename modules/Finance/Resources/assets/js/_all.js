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
Vue.component('finance-checkbooks', require('./components/FinanceCheckBookComponent.vue'));

/**
 * Componente para gestionar y configurar el diseño del voucher para la impresión de cheques
 *
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.component('finance-voucher-design', require('./components/FinanceVoucherDesignComponent.vue'));

/**
 * Opciones de configuración global del módulo de presupuesto
 * 
 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 */
Vue.mixin({
	methods: {
		/**
		 * Permite formatear la cadena de la cuenta bancaria
		 *
		 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
		 * @param  {string}  account  Número de cuenta bancaria
		 * @param  {boolean} formated Indica si se desa obtener o no el número de cuenta bancaria formateada
		 * @return {string}           Número de cuenta formateado
		 */
		format_bank_account(account, formated) {
			var formated = (typeof(formated) !== "undefined") ? formated : true;

			var account_formated = '';
            for (var i = 0; i < account.length; i++) {
                if (formated && [4, 8, 10].includes(i) && account.charAt(i) !== "-") {
                	account_formated += '-';
                }
            	account_formated += account.charAt(i);
            }

            return account_formated;
		},
		/**
		 * Obtiene los datos de las entidades bancarias registradas
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
		 */
		getBanks: function() {
			axios.get('/finance/get-banks').then(response => {
				this.banks = response.data;
			});
		},
		/**
		 * Obtiene los datos de las cuentas bancarias
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
		 */
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
							vm.record.bank_code = response.data.bank.code;
						}
					}).catch(error => {
						console.log(error);
					});
				}
			}
		},
		/**
		 * Obtiene los datos de los tipos de cuenta bancaria
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
		 */
		getAccountTypes: function() {
			axios.get('/finance/get-account-types').then(response => {
				this.account_types = response.data;
			});
		},
		/**
		 * Obtiene los datos de las cuentas asociadas a una entidad bancaria
		 *
		 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
		 */
		getBankAccounts() {
			const vm = this;
			bank_id = this.record.finance_bank_id;

			if (bank_id) {
				axios.get('/finance/get-accounts/' + bank_id).then(response => {
					if (response.data.result) {
						vm.accounts = response.data.accounts;
					}
				}).catch(error => {
					console.log(error);
				});
			}
		}
	},
	mounted() {
		// Agregar instrucciones para determinar el año de ejecución
	}
});