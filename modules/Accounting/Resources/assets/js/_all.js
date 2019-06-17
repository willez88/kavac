/**
 * Componente para Listar cuentas patrimoniales
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-accounts-list', require('./components/accounts/AccountingAccountsListComponent.vue').default);

/**
 * Componente para la creación y edición de cuentas patrimoniales
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-create-edit-form', require('./components/accounts/AccountingCreateEditFormComponent.vue').default);


/**
 * Componente para la consulta de los registros del convertidor de cuentas
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-index', require('./components/account_converter/AccountingIndexComponent.vue').default);

/**
 * Componente para la creación de conversión de cuentas
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-create-convertions', require('./components/account_converter/AccountingCreateConvertionsComponent.vue').default);

/**
 * Componente para la edición de una conversión de cuentas
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-edit-convertion', require('./components/account_converter/AccountingEditConvertionComponent.vue').default);

/**
 * Componente para la consulta de asientos contable
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-seat', require('./components/seating/AccountingSeatComponent.vue').default);

/**
 * Componente para cargar la tabla de asientos contables
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-seat-listing', require('./components/seating/AccountingSeatListingComponent.vue').default);

/**
 * Componente para la creación de asientos contable
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-seat-create', require('./components/seating/AccountingSeatEditCreateComponent.vue').default);

/**
 * Componente para cargar la tabla de cuentas patrimoniales para el asiento contable
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-seat-create-account', require('./components/seating/AccountingAccountsInSeatingComponent.vue').default);

/**
 * Componente para la configuración de categorias de origen para asientos contables
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-setting-category', require('./components/setting/AccountingSettingCategoryComponent.vue').default);

/**
 * Componente para la configuración de las tasas de cambio de mas monedas
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-setting-currency-exchange-rate', require('./components/setting/AccountingSettingCurrencyExchangeRateComponent.vue').default);


/**
 * Componente index para el reporte de balance de comprobación
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-checkup-balance', require('./components/reports/index-CheckupBalanceComponent.vue').default);

/**
 * Componente index para el reporte del libro diario
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-diary-book', require('./components/reports/index-diaryBookComponent.vue').default);

/**
 * Componente index para el reporte del Mayor Analítico
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-analytical-major', require('./components/reports/index-AnalyticalMajorComponent.vue').default);

/**
 * Componente index para el reporte del Mayor Analítico
 *
 * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.component('accounting-report-auxiliary-book', require('./components/reports/index-AuxiliaryBookComponent.vue').default);


/**
* Evento global Bus del modulo de Contabilidad
*/
window.EventBus = new Vue;

/**
 * Opciones de configuración global del módulo de contabilidad
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 */
Vue.mixin({
	data() {
		return {
			months:[
				{id:1, text:'Enero'},
				{id:2, text:'Febrero'},
				{id:3, text:'Marzo'},
				{id:4, text:'Abril'},
				{id:5, text:'Mayo'},
				{id:6, text:'Junio'},
				{id:7, text:'Julio'},
				{id:8, text:'Agosto'},
				{id:9, text:'Septiembre'},
				{id:10, text:'Octubre'},
				{id:11, text:'Noviembre'},
				{id:12, text:'Diciembre'}
			],
			years:[],
			year_init:new Date().getFullYear(),
			year_end:new Date().getFullYear(),
			month_init:1,
			month_end:12,
		}
	},
	methods:{
		CalculateOptionsYears:function(year_old, optionExtra = false){
			var date = new Date();
			if (optionExtra) {
				this.years.push({
					id:0,
					text:'Todos'
				});
				this.year_init = 0;
			}
			for (var year = date.getFullYear(); year >= year_old; year--) {
				this.years.push({
					id:year,
					text:year
				});
			}
		},
		OpenPdf:function(url, type){
			window.open(url, type);
		}
	}
});