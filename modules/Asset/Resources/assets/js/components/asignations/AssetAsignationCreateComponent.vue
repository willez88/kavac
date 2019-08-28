<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Asignación de Bienes Institucionales</h6>
			<div class="card-btns">
				<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)" 
				   title="Ir atrás" data-toggle="tooltip">
					<i class="fa fa-reply"></i>
				</a>
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
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
				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Institución:</label>
						<select2 :options="institutions" @input="getDepartments()" 
								 v-model="record.institution_id"></select2>
                    </div>

				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label>Departamento:</label>
						<select2 :options="departments" @input="" 
								 v-model="record.department_id"></select2>
                    </div>

				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Puesto de Trabajo:</label>
						<select2 :options="payroll_position_types" @input="" 
								 v-model="record.payroll_position_type_id"></select2>
						<input type="hidden" v-model="record.id">
                    </div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Cargo:</label>
						<select2 :options="payroll_positions" @input="" 
								 v-model="record.payroll_position_id"></select2>
                    </div>
				</div>
				<div class="col-md-4">
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
				<div class="col-md-3">
					<div class="form-group">
						<label>Tipo de Bien</label>
						<select2 :options="asset_types" @input="getAssetCategories()" 
								 v-model="record.asset_type_id"></select2>
					</div>
				</div>
									
				<div class="col-md-3">
					<div class="form-group">
						<label>Categoria General</label>
						<select2 :options="asset_categories" @input="getAssetSubcategories()" 
								 v-model="record.asset_category_id"
								 title="Indique la categoria general del bien"></select2>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Subcategoria</label>
						<select2 :options="asset_subcategories" 
								 @input="getAssetSpecificCategories()" 
								 v-model="record.asset_subcategory_id"
								 title="Indique la subcategoria del bien"></select2>
					</div>
				</div>

				<div class="col-md-3">
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
					<button type="button" @click="filterRecords()"class="btn btn-sm btn-primary btn-info float-right" 
							title="Buscar registros"
							data-toggle="tooltip">
						<i class="fa fa-search"></i>
						Buscar
					</button>
				</div>
			</div>

			<hr>
			<v-client-table @row-click="toggleActive" :columns="columns" :data="records" :options="table_options">
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

	        <div class="card-footer text-right">
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
</template>

<style>

	.selected-row {
		background-color: #d1d1d1 !important;
	}
	
</style>

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
				columns: ['check', 'inventory_serial', 'institution', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'],

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
					filterable: ['inventory_serial', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'],
					orderBy: { 'column': 'id'}
				}
			}
		},
		created() {
			this.getPayrollStaffs();
			this.getPayrollPositionTypes();
			this.getPayrollPositions();
			this.getAssetTypes();
			this.getInstitutions();
		},
		mounted() {
			this.loadAssets();
			if((this.asignationid)&&(!this.assetid))
				this.loadForm(this.asignationid);
			else if((!this.asignationid)&&(this.assetid))
				this.selected.push(this.assetid);
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
					else
						checkbox.click();
				}
				else if ((checkbox)&&(checkbox.checked == true)) {
					var index = vm.selected.indexOf(row.id);
					if (index >= 0)
						checkbox.click();
					else
						vm.selected.push(row.id);
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
					
					if(!vm.selectAll)
						vm.selected.push(campo.id);
					else if(checkbox && checkbox.checked){
						checkbox.click();
					}
				});
			},
			createForm(url)
			{
				const vm = this
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
	                    vm.records = vm.records.filter((asset) => {
	                    	return (asset.asset_status_id == 10 || vm.filterAsignation(asset));
	                    });
	                }
	            });
			},
			filterAsignation(asset)
			{
		      const vm = this;
		      var equal = false;
		      var fields = vm.record.asset_asignation_assets;

		      $.each(fields, function (index, campo) {
		        if (campo.asset.id == asset.id)
		          equal = true;
		      });
		      return equal;
		    },
			loadAssets(status = null)
			{
				const vm = this;
				axios.get('/asset/registers/vue-list').then(response => {
					vm.records = response.data.records.filter((asset) => {
					 	return (vm.asignationid != null)?
					 	(asset.asset_condition_id == 1):
					 	((asset.asset_condition_id == 1)&&(asset.asset_status_id == 10));
					 });
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
