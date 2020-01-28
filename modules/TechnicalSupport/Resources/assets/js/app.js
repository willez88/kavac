/**
*--------------------------------------------------------------------------
* App Scripts
*--------------------------------------------------------------------------
*
* Scripts del Módulo de Soporte Técnico a compilar por la aplicación
*/

/**
 * Componente para la gestión de solicitudes de reparación de averías de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-request-repair-list', require('./components/repairs/TechnicalSupportRequestRepairListComponent.vue').default);

/**
 * Componente para gestionar la asignación de responsable a una reparación de averías de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-assign-repair-manager', require('./components/repairs/TechnicalSupportAssignRepairManagerComponent.vue').default);

/**
 * Opciones de configuración global del módulo de soporte técnico
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.mixin({
    methods: {
    },
});
