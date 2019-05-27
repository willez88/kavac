/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts del Modulo de Almacenes a compilar por la aplicación
*/

/**
 * Componente para la gestión de almacenes
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse', require('./components/WarehouseComponent.vue').default);

/**
 * Componente para la gestión de productos almacenables
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-product', require('./components/WarehouseProductComponent.vue').default);
//Vue.component('warehouse-attribute', require('./components/WarehouseProductAttributeComponent.vue').default);

/**
 * Componente para la gestión de unidades métricas de productos
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-unit', require('./components/WarehouseProductUnitComponent.vue').default);

/**
 * Componente para la gestión de cierres de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-close', require('./components/WarehouseCloseComponent.vue').default);

/**
 * Componente para la gestión de las reglas del almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-rule', require('./components/WarehouseProductRuleComponent.vue').default);

/**
 * Componente para crear y editar solicitudes de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-request', require('./components/WarehouseRequestCreateComponent.vue').default);
Vue.component('warehouse-request-pending', require('./components/WarehouseRequestPendingComponent.vue').default);
/**
 * Componente para crear y editar las recepciones de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-reception', require('./components/WarehouseReceptionCreateComponent.vue').default);

/**
 * Componente para crear y editar los movimientos de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-movement', require('./components/WarehouseMovementCreateComponent.vue').default);
Vue.component('warehouse-movement-pending', require('./components/WarehouseMovementPendingComponent.vue').default);

/**
 * Componente para visualizar la información de las recepciones de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-reception-info', require('./components/WarehouseReceptionInfoComponent.vue').default);

/**
 * Componente para visualizar la información de las recepciones de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-movement-info', require('./components/WarehouseMovementInfoComponent.vue').default);
/**
 * Componente para visualizar la información de las solicitudes de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-request-info', require('./components/WarehouseRequestInfoComponent.vue').default);

/**
 * Componente para crear reportes de almacén 
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-reports', require('./components/WarehouseReportCreateComponent.vue').default);