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
Vue.component('warehouses', () => import(
    /* webpackChunkName: "warehouses" */
    './components/settings/WarehousesComponent.vue')
);

/**
 * Componente para la gestión de productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-products', () => import(
    /* webpackChunkName: "warehouse-products" */
    './components/settings/WarehouseProductsComponent.vue')
);

/**
 * Componente para la gestión de cierres de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-closes', () => import(
    /* webpackChunkName: "warehouse-closes" */
    './components/settings/WarehouseClosesComponent.vue')
);

/**
 * Componente para la gestión de las reglas del almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-rules', () => import(
    /* webpackChunkName: "warehouse-rules" */
    './components/settings/WarehouseProductRulesComponent.vue')
);

/**
 * Componentes para gestionar las solicitudes de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-create', () => import(
    /* webpackChunkName: "warehouse-request-create" */
    './components/requests/WarehouseRequestCreateComponent.vue')
);

/**
 * Componente para mostrar un listado de las solicitudes de almacén registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-list', () => import(
    /* webpackChunkName: "warehouse-request-list" */
    './components/requests/WarehouseRequestListComponent.vue')
);

/**
 * Componentes para gestionar las solicitudes por trabajadores de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-staff-create', () => import(
    /* webpackChunkName: "warehouse-request-staff-create" */
    './components/requests/WarehouseRequestStaffCreateComponent.vue')
);

/**
 * Componente para mostrar un listado de las solicitudes por trabajadores registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-staff-list', () => import(
    /* webpackChunkName: "warehouse-request-staff-list" */
    './components/requests/WarehouseRequestStaffListComponent.vue')
);

/**
 * Componentes para gestionar las solicitudes pendientes de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-pending', () => import(
    /* webpackChunkName: "warehouse-request-pending" */
    './components/requests/WarehouseRequestPendingComponent.vue')
);

/**
 * Componente para mostrar un listado de las solicitudes pendientes de almacén registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-pending-list', () => import(
    /* webpackChunkName: "warehouse-request-pending-list" */
    './components/requests/WarehouseRequestPendingListComponent.vue')
);

/**
 * Componente para mostrar la información de las solicitudes de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-request-info', () => import(
    /* webpackChunkName: "warehouse-request-info" */
    './components/requests/WarehouseRequestInfoComponent.vue')
);

/**
 * Componentes para gestionar los ingresos de productos al almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reception-create', () => import(
    /* webpackChunkName: "warehouse-reception-create" */
    './components/receptions/WarehouseReceptionCreateComponent.vue')
);

/**
 * Componente para mostrar un listado de los ingresos de productos al almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reception-list', () => import(
    /* webpackChunkName: "warehouse-reception-list" */
    './components/receptions/WarehouseReceptionListComponent.vue')
);

/**
 * Componente para mostrar un listado de los ingresos de productos al almacén pendientes por ejecutar
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reception-pending-list', () => import(
    /* webpackChunkName: "warehouse-reception-pending-list" */
    './components/receptions/WarehouseReceptionPendingListComponent.vue')
);

/**
 * Componente para mostrar la información de los ingresos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-reception-info', () => import(
    /* webpackChunkName: "warehouse-reception-info" */
    './components/receptions/WarehouseReceptionInfoComponent.vue')
);

/**
 * Componentes para gestionar los movimientos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-create', () => import(
    /* webpackChunkName: "warehouse-movement-create" */
    './components/movements/WarehouseMovementCreateComponent.vue')
);

/**
 * Componente para mostrar un listado de los movimientos de almacén registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-list', () => import(
    /* webpackChunkName: "warehouse-movement-list" */
    './components/movements/WarehouseMovementListComponent.vue')
);

/**
 * Componente para mostrar un listado de los movimientos de almacén pendientes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-pending-list', () => import(
    /* webpackChunkName: "warehouse-movement-pending-list" */
    './components/movements/WarehouseMovementPendingListComponent.vue')
);

/**
 * Componente para gestionar la confirmación de los movimientos de productos al almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-confirm-create', () => import(
    /* webpackChunkName: "warehouse-movement-confirm-create" */
    './components/movements/WarehouseMovementConfirmComponent.vue')
);

/**
 * Componente para mostrar la información de los movimientos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-movement-info', () => import(
    /* webpackChunkName: "warehouse-movement-info" */
    './components/movements/WarehouseMovementInfoComponent.vue')
);

/**
 * Componente para gestionar la creación de los reportes de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-report-products', () => import(
    /* webpackChunkName: "warehouse-report-products" */
    './components/reports/WarehouseReportProductsComponent.vue')
);
Vue.component('warehouse-report-stocks', () => import(
    /* webpackChunkName: "warehouse-report-stocks" */
    './components/reports/WarehouseReportStocksComponent.vue')
);
Vue.component('warehouse-report-request-products', () => import(
    /* webpackChunkName: "warehouse-report-request-products" */
    './components/reports/WarehouseReportRequestProductsComponent.vue')
);

/**
 * Componentes para mostrar los gráficos del panel de control asociados al módulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-dashboard-graphs', () => import(
    /* webpackChunkName: "warehouse-dashboard-graphs" */
    './components/dashboard/WarehouseDashboardGraphsComponent.vue')
);

/**
 * Componentes para mostrar los gráficos estadisticos del módulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-graph-charts', () => import(
    /* webpackChunkName: "warehouse-graph-charts" */
    './components/dashboard/WarehouseGraphChartsComponent.vue')
);

/**
 * Componente para mostrar un listado de los productos inventariados con su nivel de existencia
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-dashboard-product-list', () => import(
    /* webpackChunkName: "warehouse-dashboard-product-list" */
    './components/dashboard/WarehouseDashboardMinProductListComponent.vue')
);

/**
 * Componentes para mostrar un listado de las operaciones del modulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-operations-history-list', () => import(
    /* webpackChunkName: "warehouse-operations-history-list" */
    './components/dashboard/WarehouseOperationsHistoryListComponent.vue')
);

/**
 * Componente para mostrar la información de las operaciones del modulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('warehouse-operations-history-info', () => import(
    /* webpackChunkName: "warehouse-operations-history-info" */
    './components/dashboard/WarehouseOperationsHistoryInfoComponent.vue')
);

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

        /**
         *--------------------------------------------------------------------------
         * Módulo Payroll
         *--------------------------------------------------------------------------
         *
         * Operaciones del modulo de talento humano requeridas por el módulo de almacén
         */

        getPayrollPositions() {
            const vm = this;
            vm.payroll_positions = [];
            axios.get('/warehouse/get-payroll-positions').then(response => {
                vm.payroll_positions = response.data;
            });
        },

        getPayrollStaffs() {
            this.payroll_staffs = [];
            axios.get('/warehouse/get-payroll-staffs').then(response => {
                this.payroll_staffs = response.data;
            });
        },
        /**
         *--------------------------------------------------------------------------
         * Módulo Budget
         *--------------------------------------------------------------------------
         *
         * Operaciones del modulo de presupuesto requeridas por el módulo de almacén
         */

        /**
         * Obtiene un arreglo con los proyectos
         *
         * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         * @param  {integer} id Identificador del proyecto a buscar, este parámetro es opcional
         */
        getBudgetProjects(id) {
            const vm = this;

            var budget_project_id = typeof id !== "undefined" ? '/' + id : '';
            axios.get('/warehouse/get-budget-projects' + budget_project_id).then(function (response) {
                vm.budget_projects = response.data;
            });
        },

        /**
         * Obtiene un arreglo con las acciones centralizadas
         *
         * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         * @param  {integer} id Identificador de la acción centralizada a buscar, este parámetro es opcional
         */
        getBudgetCentralizedActions(id) {
            const vm = this;

            var budget_centralized_action_id = typeof id !== "undefined" ? '/' + id : '';
            axios.get('/warehouse/get-budget-centralized-actions' + budget_centralized_action_id).then(function (response) {
                vm.budget_centralized_actions = response.data;
            });
        },

        /**
         * Obtiene las Acciones Específicas
         *
         * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
         * @param {string} type Tipo de registro
         */
        getBudgetSpecificActions(type) {
            const vm = this;

            var id = type === 'Project' ? this.record.budget_project_id : this.record.budget_centralized_action_id;

            vm.budget_specific_actions = [];

            if (id) {
                axios.get('/warehouse/get-budget-specific-actions/' + type + "/" + id + "/formulation").then(function (response) {
                    vm.budget_specific_actions = response.data;
                });
            }
        },
    },
});
