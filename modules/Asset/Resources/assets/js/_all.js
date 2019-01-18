/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts del Modulo de Bienes a compilar por la aplicación
*/


/**
 * Componente para mostrar listado del clasificador de Bienes
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('asset-clasification', require('./components/AssetClasificationComponent.vue'));

/**
 * Componente para la gestión de Tipos de Bienes
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('asset-types', require('./components/AssetTypesComponent.vue'));

/**
 * Componente para la gestión de las Categorías de Bienes
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('asset-categories', require('./components/AssetCategoriesComponent.vue'));

/**
 * Componente para la gestión de las Subcategorías de Bienes
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('asset-subcategories', require('./components/AssetSubcategoriesComponent.vue'));

/**
 * Componente para la gestión de las Categorías Específicas de Bienes
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('asset-specific-categories', require('./components/AssetSpecificCategoriesComponent.vue'));

/**
 * Componente para mostrar la información de una solicitud registrada
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('request-info', require('./components/AssetRequestInfoComponent.vue'));
Vue.component('asset-info', require('./components/AssetInfoComponent.vue'));

/**
 * Componente para solicitar prorroga en la entrega de solicitudes registradas
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('request-prorroga', require('./components/AssetRequestProrrogaComponent.vue'));

/**
 * Componente para la gestion de eventos ocurridos en equipos solicitados
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('request-event', require('./components/AssetRequestEventComponent.vue'));

/**
 * Componente para mostrar un listado de solicitudes registradas
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('request-list', require('./components/AssetRequestListComponent.vue'));

/**
 * Componente para mostrar un listado de solicitudes pendientes registradas
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 */
Vue.component('request-list-pending', require('./components/AssetRequestListPendingComponent.vue'));
