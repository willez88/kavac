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
Vue.component('technicalsupport-request-list', require('./components/requests/TechnicalSupportRequestListComponent.vue').default);

/**
 * Componente para mostrar la información de una solicitud de reparación registrada
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-request-info', require('./components/requests/TechnicalSupportRequestInfoComponent.vue').default);

/**
 * Componente para gestionar la asignación de responsable a una reparación de averías de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-assign-repair-manager', require('./components/requests/TechnicalSupportAssignRepairManagerComponent.vue').default);

/**
 * Componente para la gestión de las reparación asignadas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-repair-list', require('./components/repairs/TechnicalSupportRepairListComponent.vue').default);

/**
 * Componente para mostrar la información de una reparación asignada
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-repair-info', require('./components/repairs/TechnicalSupportRepairInfoComponent.vue').default);

/**
 * Componente para
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-diagnostic', require('./components/repairs/TechnicalSupportDiagnosticComponent.vue').default);

/**
 * Componente para gestionar la entrega de los equipos en reparación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-deliver-equipment', require('./components/repairs/TechnicalSupportDeliverEquipmentComponent.vue').default);

/**
 * Componente para gestionar el diagnóstico de los equipos en reparación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-diagnostic-create', require('./components/diagnostics/TechnicalSupportDiagnosticCreateComponent.vue').default);

/**
 * Componente para gestionar el diagnóstico de los equipos en reparación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-diagnostic-asset', require('./components/diagnostics/TechnicalSupportDiagnosticAssetComponent.vue').default);

/**
 * Opciones de configuración global del módulo de soporte técnico
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.mixin({
    methods: {
        getTechnicalSupportStaffs() {
            const vm = this;
            axios.get('/technicalsupport/get-technicalsupport-staff').then(response => {
                vm.technicalSupportStaffs = response.data;
            });
        },
    },
});
