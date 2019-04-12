/**
 * Componente para Listar cuentas patrimoniales
 *
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
Vue.component('accounting-accounts-list', require('./components/accounts/AccountingAccountsListComponent.vue'));

/**
 * Componente para la creación y edición de cuentas patrimoniales
 *
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
Vue.component('accounting-create-edit-form', require('./components/accounts/AccountingCreateEditFormComponent.vue'));


/**
 * Componente para la consulta de los registros del convertidor de cuentas
 *
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
Vue.component('accounting-check-records', require('./components/account_converter/AccountingCheckRecordsComponent.vue'));

/**
 * Componente para la creación de conversión de cuentas
 *
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
Vue.component('accounting-create-convertions', require('./components/account_converter/AccountingCreateConvertionsComponent.vue'));

/**
 * Componente para la edición de una conversión de cuentas
 *
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
Vue.component('accounting-edit-convertion', require('./components/account_converter/AccountingEditConvertionComponent.vue'));

/**
 * Componente para la consulta de asientos contable
 *
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
Vue.component('accounting-seat', require('./components/seating/AccountingSeatComponent.vue'));

/**
 * Componente para la creación de asientos contable
 *
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
Vue.component('accounting-seat-create', require('./components/seating/AccountingSeatEditCreateComponent.vue'));




