<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Desincorporación de Bienes Institucionales</h6>
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
				<ul>
					<li v-for="error in errors">{{ error }}</li>
				</ul>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group is-required">
    					<label>Fecha de la Desincorporación</label>
    					<div class="input-group input-sm">
                        	<span class="input-group-addon">
                            	<i class="now-ui-icons ui-1_calendar-60"></i>
                        	</span>
                        	<input type="date" class="form-control input-sm" data-toogle="tolltip" 
                        			title="Fecha de la desincorporación" v-model="record.date">
                    	</div>
				    </div>
				</div>
				<div class="col-md-6">
					<div class="form-group is-required">
						
						<label>Motivo de la Desincorporación</label>
						<select2 :options="asset_disincorporation_motives" data-toggle="tooltip"
								 title="Indique el motivo de la desincorporación del bien"
								 v-model="record.asset_disincorporation_motive_id"></select2>
						<input type="hidden" v-model="record.id">
					</div>
				</div>
			    <div class="col-md-6">
			        <div class="form-group is-required">
			            <label>Observaciones generales</label>
			            <textarea  data-toggle="tooltip" 
								   title="Indique alguna observación referente a la desincorporación" 
								   class="form-control" v-model="record.observation">
					   </textarea>
			        </div>
			    </div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<b>Información de los Bienes a ser Desincorporados</b>
				</div>
			</div>
			<div class="row"style="margin: 10px 0">
				<div class="col-md-12">
					<b>Filtros</b>
				</div>
			</div>
				
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<label>Tipo de Bien</label>
						<select2 :options="asset_types" @input="getAssetCategories()"
								 data-toggle="tooltip"
								 title="Indique el tipo del bien"
								 v-model="record.asset_type_id"></select2>
					</div>
				</div>
									
				<div class="col-md-3">
					<div class="form-group">
						<label>Categoria General</label>
						<select2 :options="asset_categories" @input="getAssetSubcategories()" 
								 data-toggle="tooltip"
								 title="Indique la categoria general del bien"
								 v-model="record.asset_category_id"></select2>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label>Subcategoria</label>
						<select2 :options="asset_subcategories" @input="getAssetSpecificCategories()" 
								 data-toggle="tooltip"
								 title="Indique la subcategoria del bien"
								 v-model="record.asset_subcategory_id"></select2>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<label>Categoria Específica</label>
						<select2 :options="asset_specific_categories"
								 data-toggle="tooltip"
								 title="Indique la categoria específica del bien"
								 v-model="record.asset_specific_category_id"></select2>
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
						<input type="checkbox" class="cursor-pointer" :value="props.row.id" :id="'checkbox_'+props.row.id" v-model="selected">
					</label>
				</div>
				<div slot="institution" slot-scope="props" class="text-center">
					<span>{{ (props.row.institution)? props.row.institution.name:((props.row.institution_id)?props.row.institution_id:'N/A') }}</span>
					
				</div>
				<div slot="asset_condition" slot-scope="props" class="text-center">
					<span>{{ (props.row.asset_condition)? props.row.asset_condition.name:props.row.asset_condition_id }}</span>
				</div>
				<div slot="asset_status" slot-scope="props" class="text-center">
					<span>{{ (props.row.asset_status)? props.row.asset_status.name:props.row.asset_status_id }}</span>
				</div>
			</v-client-table>

		</div>

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

        	<button type="button"  @click="createForm('asset/disincorporations')"
        			class="btn btn-success btn-icon btn-round btn-modal-save"
        			title="Guardar registro">
        		<i class="fa fa-save"></i>
            </button>
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
					date: '',
					asset_disincorporation_motive_id: '',
					observation: '',

					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id: '',
					asset_specific_category_id: '',
				},

				records: [],
				columns: ['check', 'inventory_serial', 'institution', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'],
				errors: [],

				asset_disincorporation_motives: [],

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
						'institution': 'Ubicación',
						'asset_condition': 'Condición Física',
						'asset_status': 'Estatus de Uso',
						'serial': 'Serial',
						'marca': 'Marca',
						'model': 'Modelo',
					},
					sortable: ['inventory_serial', 'institution', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'],
					filterable: ['inventory_serial', 'institution', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'],
					orderBy: { 'column': 'id'}
				}
			}
		},
		created() {
			this.loadAssets();
			this.getAssetTypes();
			this.getAssetDisincorporationMotives();

			if(this.disincorporationid){
				this.loadForm(this.disincorporationid);
			}
		},
		mounted() {
			if ((this.disincorporationid)&&(!this.assetid)){
				this.loadForm(this.disincorporationid);
			}
			else if((!this.disincorporationid)&&(this.assetid))
				this.selected.push(this.assetid);
		},
		props: {
			disincorporationid: Number, 
			assetid: Number, 
		},
		methods: {
			toggleActive({ row }) {
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
			reset() {
				this.record = {
					id: '',
					date: '',
					asset_disincorporation_motive_id: '',
					observation: '',

					asset_type_id: '',
					asset_category_id: '',
					asset_subcategory_id: '',
					asset_specific_category_id: '',
				};
				this.selected = [];
				this.selectAll = false;
				
			},
			select() {
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
			createForm(url) {
				const vm = this
				vm.errors = [];
				if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
				vm.record.assets = vm.selected;
				vm.createRecord(url);
			},
			loadForm(id){
				const vm = this;
	            var fields = {};
	            
	            axios.get('/asset/disincorporations/vue-info/'+id).then(response => {
	                if(typeof(response.data.records != "undefined")){
						vm.record = response.data.records;
	                    fields = response.data.records.asset_disincorporation_assets;
	                    $.each(fields, function(index,campo){
	                        vm.selected.push(campo.asset.id);
	                    });
	                    vm.records = vm.records.filter((asset) => {
	                    	return (asset.asset_status_id == 10 || vm.filterDisincorporation(asset));
	                    });
	                }
	            });
			},
			filterDisincorporation(asset) {
		      const vm = this;
		      var equal = false;
		      var fields = vm.record.asset_disincorporation_assets;

		      $.each(fields, function (index, campo) {
		        if (campo.asset.id == asset.id)
		          equal = true;
		      });
		      return equal;
		    },
			loadAssets(){
				const vm = this;
				axios.get('/asset/registers/vue-list').then(function (response) {
					vm.records = response.data.records.filter(function (asset) {
						return (vm.disincorporationid != null)?true:asset.asset_status_id == 10;
					});
				});
			},
			filterRecords(){
				const vm = this;
				var url =  '/asset/registers/search';

				var filters = {
					case: (vm.record.id == '')?'1':'2',
					asset_type: vm.record.asset_type_id,
					asset_category: vm.record.asset_category_id,
					asset_subcategory: vm.record.asset_subcategory_id,
					asset_specific_category: vm.record.asset_specific_category_id
				};

				axios.post(url, filters).then(response => {
					vm.records = response.data.records;
				});

			},
			/**
			 * Obtiene los datos de los motivos de una desincorporación
			 *
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			getAssetDisincorporationMotives(){
				const vm = this;
				vm.asset_disincorporation_motives = [];
				axios.get('/asset/disincorporations/get-motives').then(response => {
					vm.asset_disincorporation_motives = response.data;
				});

			}
		}
	};
</script>

