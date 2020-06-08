<template>
	<section id="AssetAsignationForm">
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<div class="container">
					<div class="alert-icon">
						<i class="now-ui-icons objects_support-17"></i>
					</div>
					<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"
							@click.prevent="errors = []">
						<span aria-hidden="true">
							<i class="now-ui-icons ui-1_simple-remove"></i>
						</span>
					</button>
					<ul>
						<li v-for="error in errors">{{ error }}</li>
					</ul>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<b>Información del Trabajador Responsable del bien</b>
				</div>
				<div class="col-md-4" id="helpInstitution">
					<div class="form-group is-required">
						<label>Institución:</label>
						<select2 :options="institutions" @input="getDepartments()"
								 v-model="record.institution_id"></select2>
                    </div>

				</div>
				<div class="col-md-4" id="helpDepartment">
					<div class="form-group is-required">
						<label>Departamento:</label>
						<select2 :options="departments" @input=""
								 v-model="record.department_id"></select2>
                    </div>

				</div>
				<div class="col-md-4" id="helpPositionType">
					<div class="form-group">
						<label>Puesto de Trabajo:</label>
						<select2 :options="payroll_position_types" @input=""
								 v-model="record.payroll_position_type_id"></select2>
						<input type="hidden" v-model="record.id">
                    </div>
				</div>
				<div class="col-md-4" id="helpPosition">
					<div class="form-group">
						<label>Cargo:</label>
						<select2 :options="payroll_positions" @input=""
								 v-model="record.payroll_position_id"></select2>
                    </div>
				</div>
				<div class="col-md-4" id="helpStaff">
					<div class="form-group is-required">
						<label>Trabajador:</label>
						<select2 :options="payroll_staffs" @input=""
								 v-model="record.payroll_staff_id"></select2>
                    </div>
				</div>

			</div>
			<div class="row">
				<div class="col-md-12">
					<b>Información de los Bienes a ser Asignados</b>
				</div>
			</div>
			<div class="row" style="margin: 10px 0">
				<div class="col-md-12">
					<b>Filtros</b>
				</div>
			</div>

			<div class="row">
				<div class="col-md-3" id="helpSearchAssetType">
					<div class="form-group">
						<label>Tipo de Bien</label>
						<select2 :options="asset_types" @input="getAssetCategories()"
								 v-model="record.asset_type_id"></select2>
					</div>
				</div>

				<div class="col-md-3" id="helpSearchAssetCategory">
					<div class="form-group">
						<label>Categoria General</label>
						<select2 :options="asset_categories" @input="getAssetSubcategories()"
								 v-model="record.asset_category_id"
								 title="Indique la categoria general del bien"></select2>
					</div>
				</div>
				<div class="col-md-3" id="helpSearchAssetSubCategory">
					<div class="form-group">
						<label>Subcategoria</label>
						<select2 :options="asset_subcategories"
								 @input="getAssetSpecificCategories()"
								 v-model="record.asset_subcategory_id"
								 title="Indique la subcategoria del bien"></select2>
					</div>
				</div>

				<div class="col-md-3" id="helpSearchAssetSpecificCategory">
					<div class="form-group">
						<label>Categoria Específica</label>
						<select2 :options="asset_specific_categories"
								 v-model="record.asset_specific_category_id"
								 title="Indique la categoria específica del bien"></select2>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<button type="button" id="helpSearchButton" @click="filterRecords()"
                            class="btn btn-sm btn-primary btn-info float-right" title="Buscar registros"
                            data-toggle="tooltip">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>

			<hr>
			<div class="form-group form-inline pull-right VueTables__limit-2">
				<div class="VueTables__limit-field">
					<label class="">Registros</label>
					<select2 :options="perPageValues"
						v-model="perPage">
					</select2>
				</div>
			</div>
			<v-client-table id="helpTable"
				@row-click="toggleActive" :columns="columns" :data="records" :options="table_options" ref="tableMax">
				<div slot="h__check" class="text-center">
					<label class="form-checkbox">
						<input type="checkbox" v-model="selectAll" @click="select()" class="cursor-pointer">
					</label>
				</div>

				<div slot="check" slot-scope="props" class="text-center">
					<label class="form-checkbox">
						<input type="checkbox" class="cursor-pointer" :value="props.row.id"
							:id="'checkbox_'+props.row.id" v-model="selected">
					</label>
				</div>
				<div slot="institution" slot-scope="props" class="text-center">
					<span>
						{{ (props.row.institution)?
							props.row.institution.name:((props.row.institution_id)?props.row.institution_id:'N/A') }}
					</span>

				</div>
				<div slot="asset_condition" slot-scope="props" class="text-center">
					<span>
						{{ (props.row.asset_condition)?
							props.row.asset_condition.name:props.row.asset_condition_id }}
					</span>
				</div>
				<div slot="asset_status" slot-scope="props" class="text-center">
					<span>{{ (props.row.asset_status)? props.row.asset_status.name:props.row.asset_status_id }}</span>
				</div>
			</v-client-table>
			<div class="VuePagination-2 row col-md-12 ">
				<nav class="text-center">
					<ul class="pagination VuePagination__pagination" style="">
						<li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk" v-if="page != 1">
	                        <a class="page-link" @click="changePage(1)">PRIMERO</a>
	                    </li>
						<li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk disabled">
	                        <a class="page-link">&lt;&lt;</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-page" v-if="page > 1">
	                        <a class="page-link" @click="changePage(page - 1)">&lt;</a>
	                    </li>
	                    <li :class="(page == number)?'VuePagination__pagination-item page-item active':'VuePagination__pagination-item page-item'" v-for="number in pageValues" v-if="number <= lastPage">
	                        <a class="page-link active" role="button" @click="changePage(number)">{{number}}</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-next-page" v-if="page < lastPage">
	                        <a class="page-link" @click="changePage(page + 1)">&gt;</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-next-chunk disabled">
	                        <a class="page-link">&gt;&gt;</a>
	                    </li>
	                    <li class="VuePagination__pagination-item page-item  VuePagination__pagination-item-prev-chunk" v-if="lastPage != page">
	                        <a class="page-link" @click="changePage(lastPage)">ÚLTIMO</a>
	                    </li>
					</ul>
					<p class="VuePagination__count text-center col-md-12" style=""> </p>
				</nav>
			</div>
		</div>
        <div class="card-footer text-right">
			<div class="row">
				<div class="col-md-3 offset-md-9" id="helpParamButtons">
		        	<button type="button" @click="reset()"
							class="btn btn-default btn-icon btn-round"
							title ="Borrar datos del formulario">
							<i class="fa fa-eraser"></i>
					</button>

		        	<button type="button"
		        			class="btn btn-warning btn-icon btn-round btn-modal-close"
		        			data-dismiss="modal"
		        			title="Cancelar y regresar">
		        			<i class="fa fa-ban"></i>
		        	</button>

		        	<button type="button"  @click="createForm('asset/asignations')"
		        			class="btn btn-success btn-icon btn-round btn-modal-save"
		        			title="Guardar registro">
		        		<i class="fa fa-save"></i>
		            </button>
		        </div>
		    </div>
        </div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					payroll_position_type_id: '',
					payroll_position_id: '',
					payroll_staff_id: '',

					institution_id: '',
					department_id: '',

					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id: '',
					asset_specific_category_id: '',
				},
				errors: [],
				records: [],
				page: 1,
				total: '',
				perPage: 10,
				lastPage: '',
				pageValues: [1,2,3,4,5,6,7,8,9,10],
				perPageValues: [
					{
						'id': 10,
						'text': '10'
					},
					{
						'id': 25,
						'text': '25'
					},
					{
						'id': 50,
						'text': '50'
					}
				],
				columns: [
                    'check', 'inventory_serial', 'institution', 'asset_condition', 'asset_status', 'serial',
                    'marca', 'model'
                ],

				payroll_position_types:[],
				payroll_positions:[],
				payroll_staffs:[],
				institutions: [],
				departments:[],

				asset_types: [],
				asset_categories: [],
				asset_subcategories: [],
				asset_specific_categories: [],

				selected: [],
				selectAll: false,

				table_options: {
					rowClassCallback(row) {
						var checkbox = document.getElementById('checkbox_' + row.id);
						return ((checkbox)&&(checkbox.checked))? 'selected-row cursor-pointer' : 'cursor-pointer';
					},
					headings: {
						'inventory_serial': 'Código',
						'asset_condition': 'Condición Física',
						'asset_status': 'Estatus de Uso',
						'serial': 'Serial',
						'marca': 'Marca',
						'model': 'Modelo',
					},
					sortable: ['inventory_serial', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'],
					filterable: ['inventory_serial', 'asset_condition', 'asset_status', 'serial', 'marca', 'model']
				}
			}
		},
		watch: {
            perPage(res) {
            	if (this.page == 1){
            		this.loadAssets('/asset/registers/vue-list/' + res + '/' + this.page);
            	} else {
            		this.changePage(1);
            	}
            },
            page(res) {
                this.loadAssets('/asset/registers/vue-list/' + this.perPage + '/' + res);
            },
        },
		created() {
			this.getPayrollStaffs();
			this.getPayrollPositionTypes();
			this.getPayrollPositions();
			this.getAssetTypes();
			this.getInstitutions();
		},
		mounted() {
			this.loadAssets('/asset/registers/vue-list/' + this.perPage + '/' + this.page);
			if((this.asignationid)&&(!this.assetid)) {
				this.loadForm(this.asignationid);
            }
			else if((!this.asignationid)&&(this.assetid)) {
				this.selected.push(this.assetid);
            }
		},
		props: {
			asignationid: Number,
			assetid: Number,
		},
		methods: {
			toggleActive({ row })
			{
				const vm = this;
				var checkbox = document.getElementById('checkbox_' + row.id);

				if((checkbox)&&(checkbox.checked == false)){
					var index = vm.selected.indexOf(row.id);
					if (index >= 0){
						vm.selected.splice(index,1);
					}
					else {
						checkbox.click();
                    }
				}
				else if ((checkbox)&&(checkbox.checked == true)) {
					var index = vm.selected.indexOf(row.id);
					if (index >= 0) {
						checkbox.click();
                    }
					else {
						vm.selected.push(row.id);
                    }
				}
		    },

			reset()
			{
				this.record = {
					id: '',
					payroll_position_type_id: '',
					payroll_position_id: '',
					payroll_staff_id: '',

					institution_id: '',

					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id: '',
					asset_specific_category_id: '',
				};
				this.selected = [];
				this.selectAll = false;

			},
			select()
			{
				const vm = this;
				vm.selected = [];
				$.each(vm.records, function(index,campo){
					var checkbox = document.getElementById('checkbox_' + campo.id);

					if(!vm.selectAll) {
						vm.selected.push(campo.id);
                    }
					else if(checkbox && checkbox.checked) {
						checkbox.click();
					}
				});
			},
			/**
			 * Cambia la pagina actual de la tabla
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 *
			 * @param [Integer] $page Número de pagina actual
			 */
			changePage(page) {
                const vm = this;
                vm.page = page;
                var pag = 0;
                while(1) {
                    if (pag + 10 >= vm.page) {
                        pag += 1;
                        break;
                    } else {
                        pag += 10;
                    }
                }
                vm.pageValues = [];
                for (var i = 0; i < 10; i++) {
                    vm.pageValues.push(pag + i);
                }
            },
			createForm(url)
			{
				const vm = this;
				vm.errors = [];
				if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
				vm.record.assets = vm.selected;
				vm.createRecord(url);
			},
			loadForm(id)
			{
				const vm = this;
	            var fields = {};

	            axios.get('/asset/asignations/vue-info/'+id).then(response => {
	                if(typeof(response.data.records != "undefined")){

						vm.record = response.data.records;
	                    fields = response.data.records.asset_asignation_assets;
	                    $.each(fields, function(index,campo){
	                        vm.selected.push(campo.asset.id);
	                    });
	                }
	            });
			},
			loadAssets(url)
			{
				const vm = this;
				url += (vm.asignationid != null)?'/asignations/' + vm.asignationid:'/asignations';
				axios.get(url).then(response => {
					if (typeof(response.data.records) !== "undefined") {
	                    vm.records  = response.data.records;
						vm.total    = response.data.total;
						vm.lastPage = response.data.lastPage;
						vm.$refs.tableMax.setLimit(vm.perPage);
	                }
				});
			},
			filterRecords()
			{
				const vm = this;
				var url =  '/asset/registers/search/clasification';

				var filters = {
					asset_type: vm.record.asset_type_id,
					asset_category: vm.record.asset_category_id,
					asset_subcategory: vm.record.asset_subcategory_id,
					asset_specific_category: vm.record.asset_specific_category_id
				};

				axios.post(url, filters).then(response => {
					vm.records = response.data.records;
				});

			},
		}
	};
</script>
