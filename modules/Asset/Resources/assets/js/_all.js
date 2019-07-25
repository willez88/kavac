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
Vue.component('asset-clasification', require('./components/AssetClasificationComponent.vue').default);

/**
 * Componente para la gestión de Tipos de Bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-types', require('./components/AssetTypesComponent.vue').default);

/**
 * Componente para la gestión de las Categorías de Bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-categories', require('./components/AssetCategoriesComponent.vue').default);

/**
 * Componente para la gestión de las Subcategorías de Bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-subcategories', require('./components/AssetSubcategoriesComponent.vue').default);

/**
 * Componente para la gestión de las Categorías Específicas de Bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-specific-categories', require('./components/AssetSpecificCategoriesComponent.vue').default);

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
 * Componente para mostrar un listado de solicitudes registradas
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
 * Componente para la gestion de reportes de inventario
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 */
Vue.component('asset-report-create', require('./components/reports/AssetReportCreateComponent.vue').default);
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
		 * Obtiene los datos de los puestos de trabajo registrados en la institucion
		 *
		 * @author Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getStaffs() {
			const vm = this;
			vm.staffs = [];
			axios.get('/asset/get-staffs').then(response => {
				vm.staffs = response.data;
			});
		},

		/**
		 * Obtiene los datos de los tipos de cargo registrados en la institucion
		 *
		 * @author Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getTypePositions() {
			const vm = this;
			vm.type_positions = [];
			axios.get('/asset/get-type-positions').then(response => {
				vm.type_positions = response.data;
			});
		},

		/**
		 * Obtiene los datos de los cargos registrados en la institucion
		 *
		 * @author Henry Paredes <hparedes@cenditel.gob.ve>
		 */
		getPositions() {
			const vm = this;
			vm.positions = [];
			axios.get('/asset/get-positions').then(response => {
				vm.positions = response.data;
			});
		},
		
	},
});