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
Vue.component('asset-clasifications-list', require('./components/AssetClasificationListComponent.vue'));

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