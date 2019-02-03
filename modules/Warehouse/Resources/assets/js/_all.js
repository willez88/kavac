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

Vue.component('warehouse', require('./components/WarehouseComponent.vue'));

/**
 * Componente para la gestión de productos almacenables
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-product', require('./components/WarehouseProductComponent.vue'));

/**
 * Componente para la gestión de unidades métricas de productos
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-unit', require('./components/WarehouseProductUnitComponent.vue'));

/**
 * Componente para la gestión de cierres de almacén
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */

Vue.component('warehouse-close', require('./components/WarehouseCloseComponent.vue'));