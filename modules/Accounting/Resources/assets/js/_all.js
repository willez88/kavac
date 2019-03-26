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
 * Componente para la creacion de registros del convertidor de cuentas
 *
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
Vue.component('accounting-create-convertion', require('./components/account_converter/AccountingCreateConvertionComponent.vue'));



// *
//  * Componente para la consulta de los registros del convertidro de cuentas
//  *
//  * @author  Juan Rosas <JuanFBass17@gmail.com>
 
// Vue.component('accounting-check-records', require('./components/account_converter/AccountingCheckRecordsComponent.vue'));

