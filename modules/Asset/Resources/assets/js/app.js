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
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-clasifications', require('./components/settings/AssetClasificationComponent.vue').default);

/**
 * Componente para la gestión de Tipos de Bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-types', require('./components/settings/AssetTypesComponent.vue').default);

/**
 * Componente para la gestión de las Categorías de Bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-categories', require('./components/settings/AssetCategoriesComponent.vue').default);

/**
 * Componente para la gestión de las Subcategorías de Bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-subcategories', require('./components/settings/AssetSubcategoriesComponent.vue').default);

/**
 * Componente para la gestión de las Categorías Específicas de Bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-specific-categories', require('./components/settings/AssetSpecificCategoriesComponent.vue').default);

/**
 * Componente para la gestión de las Condiciones Físicas de un Bien
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-conditions', require('./components/settings/AssetConditionsComponent.vue').default);

/**
 * Componente para la gestión de los Status de Uso de un Bien
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-status', require('./components/settings/AssetStatusComponent.vue').default);

/**
 * Componente para la gestión de la Función de Uso de un Bien
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-use-functions', require('./components/settings/AssetUseFunctionsComponent.vue').default);

/**
 * Componente para la gestión del Tipo de Adquisición de un Bien
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-acquisition-types', require('./components/settings/AssetAcquisitionTypesComponent.vue').default);

/**
 * Componente para gestionar las solicitudes de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-request-create', require('./components/requests/AssetRequestCreateComponent.vue').default);
/**
 * Componente para mostrar la información de una solicitud registrada
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-request-info', require('./components/requests/AssetRequestInfoComponent.vue').default);

/**
 * Componente para gestionar las asignaciones de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-asignation-create', require('./components/asignations/AssetAsignationCreateComponent.vue').default);

/**
 * Componente para mostrar un listado de las asignaciones registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-asignation-list', require('./components/asignations/AssetAsignationListComponent.vue').default);

/**
 * Componente para mostrar la información de una asignacion registrada
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-asignation-info', require('./components/asignations/AssetAsignationInfoComponent.vue').default);

/**
 * Componente para gestionar las desincorporaciones de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-disincorporation-create', require('./components/disincorporations/AssetDisincorporationCreateComponent.vue').default);

/**
 * Componente para mostrar un listado de las desincorporaciones registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-disincorporation-list', require('./components/disincorporations/AssetDisincorporationListComponent.vue').default);

/**
 * Componente para mostrar la información de una desincorporación registrada
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-disincorporation-info', require('./components/disincorporations/AssetDisincorporationInfoComponent.vue').default);

/**
 * Componente para gestionar el ingreso manual de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-create', require('./components/registers/AssetCreateComponent.vue').default);

/**
 * Componente para mostrar un listado de bienes institucionales registrados
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-list', require('./components/registers/AssetListComponent.vue').default);

/**
 * Componente para mostrar la información de un bien registrado
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-info', require('./components/registers/AssetInfoComponent.vue').default);

/**
 * Componente para solicitar prorroga en la entrega de solicitudes registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-request-extension', require('./components/requests/AssetRequestExtensionComponent.vue').default);

/**
 * Componente para la gestion de eventos ocurridos en equipos solicitados
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-request-event', require('./components/requests/AssetRequestEventComponent.vue').default);

/**
 * Componente para mostrar un listado de las solicitudes registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-request-list', require('./components/requests/AssetRequestListComponent.vue').default);

/**
 * Componente para mostrar un listado de solicitudes pendientes registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-request-list-pending', require('./components/requests/AssetRequestListPendingComponent.vue').default);

/**
 * Componente para mostrar un listado de solicitudes de entregas registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-request-delivery-list', require('./components/requests/AssetRequestDeliveryListComponent.vue').default);

/**
 * Componente para gestionar la creación de reportes de inventario
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-report-create', require('./components/reports/AssetReportCreateComponent.vue').default);

/**
 * Componente para mostrar un listado del historico del inventario
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-inventory-history-list', require('./components/inventories/AssetInventoryHistoryListComponent.vue').default);

/**
 * Componente para mostrar los gráficos del panel de control asociados al módulo de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-dashboard-graphs', require('./components/dashboard/AssetDashboardGraphsComponent.vue').default);

/**
 * Componente para la gestión de gráficos estadísticos del módulo de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-graph-charts', require('./components/dashboard/AssetGraphChartsComponent.vue').default);

/**
 * Componente para mostrar la información de una operación asociada al módulo de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-operations-history-info', require('./components/dashboard/AssetOperationsHistoryInfoComponent.vue').default);

/**
 * Componente para mostrar un listado de las operaciones registradas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-operations-history-list', require('./components/dashboard/AssetOperationsHistoryListComponent.vue').default);

/**
 * Opciones de configuración global del módulo de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.mixin({
	methods: {
		/**
		 * Obtiene los datos de los tipos de bienes institucionales registrados
		 *
		 * @author Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getAssetTypes() {
			const vm = this;
			axios.get('/asset/get-types').then(response => {
				vm.asset_types = response.data;
			});
		},
		/**
		 * Obtiene los datos de las categorias generales de los bienes institucionales registrados
		 *
		 * @author Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getAssetCategories() {
			var vm = this;
			vm.asset_categories = [];

			if (vm.record.asset_type_id) {
				axios.get('/asset/get-categories' + '/' + vm.record.asset_type_id).then(function (response) {
					vm.asset_categories = response.data;
				});
			}
			else if ((vm.assetid)&&(vm.record.asset_type_id == '')) {
				axios.get('/asset/get-categories').then(function (response) {
					vm.asset_categories = response.data;
				});
			}
		},
		/**
		 * Obtiene los datos de las subcategorias de los bienes institucionales registrados
		 *
		 * @author Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getAssetSubcategories() {
			var vm = this;
			vm.asset_subcategories = [];

			if (vm.record.asset_category_id) {
				axios.get('/asset/get-subcategories' + '/' + vm.record.asset_category_id).then(function (response) {
					vm.asset_subcategories = response.data;
				});
			}
			else if ((vm.assetid)&&(vm.record.asset_type_id == '')) {
				axios.get('/asset/get-subcategories').then(function (response) {
					vm.asset_subcategories = response.data;
				});
			}
		},
		/**
		 * Obtiene los datos de las categorias específicas de los bienes institucionales registrados
		 *
		 * @author Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getAssetSpecificCategories() {
			var vm = this;
			vm.asset_specific_categories = [];

			if ((vm.record.asset_subcategory_id)&&(vm.record.asset_subcategory_id != '')) {
				axios.get('/asset/get-specific-categories' + '/' + vm.record.asset_subcategory_id).then(function (response) {
					vm.asset_specific_categories = response.data;
				});
			}
			else if ((vm.assetid)&&(vm.record.asset_type_id == '')) {
				axios.get('/asset/get-specific-categories').then(function (response) {
					vm.asset_specific_categories = response.data;
				});
			}
		},
		/**
		 *--------------------------------------------------------------------------
		 * Módulo Payroll
		 *--------------------------------------------------------------------------
		 *
		 * Operaciones del modulo de talento humano requeridas por el módulo de bienes
		 */

		getPayrollPositionTypes() {
			const vm = this;
			vm.payroll_position_types = [];
			axios.get('/asset/get-payroll-position-types').then(response => {
				vm.payroll_position_types = response.data;
			});
		},

		getPayrollPositions() {
			const vm = this;
			vm.payroll_positions = [];
			axios.get('/asset/get-payroll-positions').then(response => {
				vm.payroll_positions = response.data;
			});
		},

		getPayrollStaffs() {
			this.payroll_staffs = [];
			axios.get('/asset/get-payroll-staffs').then(response => {
				this.payroll_staffs = response.data;
			});
		},
	},
});
