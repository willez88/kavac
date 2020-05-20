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
Vue.component('technicalsupport-request-list', () => import(
    /* webpackChunkName: "technicalsupport-request-list" */
    './components/requests/TechnicalSupportRequestListComponent.vue')
);

/**
 * Componente para mostrar la información de una solicitud de reparación registrada
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-request-info', () => import(
    /* webpackChunkName: "technicalsupport-request-info" */
    './components/requests/TechnicalSupportRequestInfoComponent.vue')
);

/**
 * Componente para gestionar la asignación de responsable a una reparación de averías de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-assign-repair-manager', () => import(
    /* webpackChunkName: "technicalsupport-assign-repair-manager" */
    './components/requests/TechnicalSupportAssignRepairManagerComponent.vue')
);

/**
 * Componente para la gestión de las reparación asignadas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-repair-list', () => import(
    /* webpackChunkName: "technicalsupport-repair-list" */
    './components/repairs/TechnicalSupportRepairListComponent.vue')
);

/**
 * Componente para mostrar la información de una reparación asignada
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-repair-info', () => import(
    /* webpackChunkName: "technicalsupport-repair-info" */
    './components/repairs/TechnicalSupportRepairInfoComponent.vue')
);

/**
 * Componente para
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-diagnostic', () => import(
    /* webpackChunkName: "technicalsupport-diagnostic" */
    './components/repairs/TechnicalSupportDiagnosticComponent.vue')
);

/**
 * Componente para gestionar la entrega de los equipos en reparación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-deliver-equipment', () => import(
    /* webpackChunkName: "technicalsupport-deliver-equipment" */
    './components/repairs/TechnicalSupportDeliverEquipmentComponent.vue')
);

/**
 * Componente para gestionar el diagnóstico de los equipos en reparación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-diagnostic-create', () => import(
    /* webpackChunkName: "technicalsupport-diagnostic-create" */
    './components/diagnostics/TechnicalSupportDiagnosticCreateComponent.vue')
);

/**
 * Componente para gestionar el diagnóstico de los equipos en reparación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('technicalsupport-diagnostic-asset', () => import(
    /* webpackChunkName: "technicalsupport-diagnostic-asset" */
    './components/diagnostics/TechnicalSupportDiagnosticAssetComponent.vue')
);

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
