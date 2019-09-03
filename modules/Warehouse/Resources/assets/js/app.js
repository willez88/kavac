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
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouses', require('./components/WarehousesComponent.vue').default);

/**
 * Componente para la gestión de productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-products', require('./components/WarehouseProductsComponent.vue').default);

/**
 * Componente para la gestión de cierres de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-closes', require('./components/WarehouseClosesComponent.vue').default);

/**
 * Componente para la gestión de las reglas del almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-rules', require('./components/WarehouseProductRulesComponent.vue').default);

/**
 * Componentes para gestionar las solicitudes de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-create', require('./components/requests/WarehouseRequestCreateComponent.vue').default);

/**
 * Componente para mostrar un listado de las solicitudes de almacén registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-list', require('./components/requests/WarehouseRequestListComponent.vue').default);

/**
 * Componentes para gestionar las solicitudes por trabajadores de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-staff-create', require('./components/requests/WarehouseRequestStaffCreateComponent.vue').default);

/**
 * Componente para mostrar un listado de las solicitudes por trabajadores registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-staff-list', require('./components/requests/WarehouseRequestStaffListComponent.vue').default);

/**
 * Componentes para gestionar las solicitudes pendientes de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-pending', require('./components/requests/WarehouseRequestPendingComponent.vue').default);

/**
 * Componente para mostrar un listado de las solicitudes pendientes de almacén registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-pending-list', require('./components/requests/WarehouseRequestPendingListComponent.vue').default);

/**
 * Componente para mostrar la información de las solicitudes de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-info', require('./components/requests/WarehouseRequestInfoComponent.vue').default);

/**
 * Componentes para gestionar los ingresos de productos al almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reception-create', require('./components/receptions/WarehouseReceptionCreateComponent.vue').default);

/**
 * Componente para mostrar un listado de los ingresos de productos al almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reception-list', require('./components/receptions/WarehouseReceptionListComponent.vue').default);

/**
 * Componente para mostrar un listado de los ingresos de productos al almacén pendientes por ejecutar
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reception-pending-list', require('./components/receptions/WarehouseReceptionPendingListComponent.vue').default);

/**
 * Componente para mostrar la información de los ingresos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reception-info', require('./components/receptions/WarehouseReceptionInfoComponent.vue').default);

/**
 * Componentes para gestionar los movimientos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-create', require('./components/movements/WarehouseMovementCreateComponent.vue').default);

/**
 * Componente para mostrar un listado de los movimientos de almacén registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-list', require('./components/movements/WarehouseMovementListComponent.vue').default);

/**
 * Componente para mostrar un listado de los movimientos de almacén pendientes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-pending-list', require('./components/movements/WarehouseMovementPendingListComponent.vue').default);

/**
 * Componente para gestionar la confirmación de los movimientos de productos al almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-confirm-create', require('./components/movements/WarehouseMovementConfirmComponent.vue').default);

/**
 * Componente para mostrar la información de los movimientos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-info', require('./components/movements/WarehouseMovementInfoComponent.vue').default);

/**
 * Componente para gestionar la creación de los reportes de almacén 
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reports', require('./components/reports/WarehouseReportCreateComponent.vue').default);

/**
 * Componentes para mostrar los gráficos del panel de control asociados al módulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-dashboard-graphs', require('./components/dashboard/WarehouseDashboardGraphsComponent.vue').default);

/**
 * Componentes para mostrar los gráficos estadisticos del módulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-graph-charts', require('./components/dashboard/WarehouseGraphChartsComponent.vue').default);

/**
 * Componente para mostrar un listado de los productos inventariados con su nivel de existencia
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-dashboard-product-list', require('./components/dashboard/WarehouseDashboardMinProductListComponent.vue').default);

/**
 * Componentes para mostrar un listado de las operaciones del modulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-operations-history-list', require('./components/dashboard/WarehouseOperationsHistoryListComponent.vue').default);

/**
 * Componente para mostrar la información de las operaciones del modulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-operations-history-info', require('./components/dashboard/WarehouseOperationsHistoryInfoComponent.vue').default);

/**
 * Opciones de configuración global del módulo de bienes
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.mixin({
    methods: {
        /**
         * Método que obtiene los datos de los almacenes registrados
         *
         * @author Henry Paredes <hparedes@cenditel.gob.ve>
         */
        getWarehouses()
        {
            const vm = this;
            var institution_id = (vm.record.institution_id)?vm.record.institution_id:
                ((vm.institution_id)?vm.institution_id:'');

            axios.get('/warehouse/get-warehouses/' + institution_id).then(response => {
                if(typeof(response.data) != "undefined")
                    vm.warehouses = response.data;
            });
        },
    },
});
