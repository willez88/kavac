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
						<select2 :options="motives" title="Indique el motivo de la desincorporación del bien"
								 v-model="record.motive_id"></select2>
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
				<div class="col-md-4">
					<div class="form-group">
						<label>Tipo de Bien</label>
						<select2 :options="types" @input="getCategories()" 
								 v-model="record.type_id"></select2>
					</div>
				</div>
									
				<div class="col-md-4">
					<div class="form-group">
						<label>Categoria General</label>
						<select2 :options="categories" @input="getSubcategories()" 
								 v-model="record.category_id"
								 title="Indique la categoria general del bien"></select2>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Subcategoria</label>
						<select2 :options="subcategories" @input="getSpecificCategories()" 
								 v-model="record.subcategory_id"
								 title="Indique la subcategoria del bien"></select2>
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Categoria Específica</label>
						<select2 :options="specific_categories" 
								 v-model="record.specific_category_id"
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
						<input type="checkbox" class="cursor-pointer" :value="props.row.id" :id="'checkbox_'+props.row.id" v-model="selected">
					</label>
				</div>
				<div slot="institution" slot-scope="props" class="text-center">
					<span>{{ (props.row.institution)? props.row.institution.name:((props.row.institution_id)?props.row.institution_id:'N/A') }}</span>
					
				</div>
				<div slot="condition" slot-scope="props" class="text-center">
					<span>{{ (props.row.condition)? props.row.condition.name:props.row.condition_id }}</span>
				</div>
				<div slot="status" slot-scope="props" class="text-center">
					<span>{{ (props.row.status)? props.row.status.name:props.row.status_id }}</span>
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

        	<button type="button"  @click="createRecord('asset/disincorporations')"
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
					motive_id: '',
					observation: '',

					type_id: '',
					category_id: '',
					subcategory_id: '',
					specific_category_id: '',
				},

				records: [],
				columns: ['check', 'serial_inventario', 'institution', 'condition', 'status', 'serial', 'marca', 'model'],
				errors: [],

				motives: [],

				types: [],
				categories: [],
				subcategories: [],
				specific_categories: [],

				selected: [],
				selectAll: false,

				table_options: {
					rowClassCallback(row) {
						var checkbox = document.getElementById('checkbox_' + row.id);
						return ((checkbox)&&(checkbox.checked))? 'selected-row cursor-pointer' : 'cursor-pointer';
					},
					headings: {
						'serial_inventario': 'Código',
						'institution': 'Ubicación',
						'condition': 'Condición Física',
						'status': 'Estatus de Uso',
						'serial': 'Serial',
						'marca': 'Marca',
						'model': 'Modelo',
					},
					sortable: ['serial_inventario', 'institution', 'condition', 'status', 'serial', 'marca', 'model'],
					filterable: ['serial_inventario', 'institution', 'condition', 'status', 'serial', 'marca', 'model'],
					orderBy: { 'column': 'id'}
				}
			}
		},
		created() {
			this.loadAssets();
			this.getTypes();
			this.getMotives();

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
					motive_id: '',
					observation: '',

					type_id: '',
					category_id: '',
					subcategory_id: '',
					specific_category_id: '',
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
			createRecord(url){
				const vm = this
				vm.errors = [];
				if(!vm.selected.length > 0){
                	bootbox.alert("Debe agregar almenos un elemento a la solicitud");
					return false;
				};
				
				if (vm.record.id) {
					vm.updateRecord(url);
				}
				else{
					var fields = {
						id: vm.record.id,
						date: vm.record.date,
						motive_id: vm.record.motive_id,
						observation: vm.record.observation,
						assets: vm.selected,
					};

					axios.post('/' + url, fields).then(response => {
						if (response.data.result) {
	                        vm.showMessage('store');
	                        setTimeout(function() {
	                            window.location.href = '/asset/disincorporations';
	                        }, 2000);
	                    }
					}).catch(error => {
						this.errors = [];

						if (typeof(error.response) !="undefined") {
							for (var index in error.response.data.errors) {
								if (error.response.data.errors[index]) {
									this.errors.push(error.response.data.errors[index][0]);
								}
							}
						}
					});
				}
			},
			updateRecord(url) {
				const vm = this;
				
				var fields = {
						id: vm.record.id,
						date: vm.record.date,
						motive_id: vm.record.motive_id,
						observation: vm.record.observation,
						assets: vm.selected,
					};

				axios.patch('/' + url + '/' + vm.record.id, fields).then(response => {
					if (response.data.result) {
                        vm.showMessage('update');
                        setTimeout(function() {
                            window.location.href = '/asset/disincorporations';
                        }, 2000);
                    }
				}).catch(error => {
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});
		    },
			loadForm(id){
				const vm = this;
	            var fields = {};
	            
	            axios.get('/asset/disincorporations/vue-info/'+id).then(response => {
	                if(typeof(response.data.records != "undefined")){

						vm.record = response.data.records;
	                    fields = response.data.records.assets_disincorporation;
	                    $.each(fields, function(index,campo){
	                        vm.selected.push(campo.asset.id);
	                    });
	                }
	            });
			},
			loadAssets(){
				const vm = this;
				axios.get('/asset/registers/vue-list').then(response => {
					vm.records = response.data.records;
				});
			},
			filterRecords(){
				const vm = this;
				var url =  '/asset/registers/search';

				var filters = {
					case: (vm.record.id == '')?'1':'2',
					type: vm.record.type_id,
					category: vm.record.category_id,
					subcategory: vm.record.subcategory_id,
					specific_category: vm.record.specific_category_id
				};

				axios.post(url, filters).then(response => {
					vm.records = response.data.records;
				});

			},
			/**
			 * Obtiene los datos de los motivos de una desincorporación
			 *
			 * @author Henry Paredes (henryp2804@gmail.com)
			 */
			getMotives(){
				const vm = this;
				vm.motives = [];
				axios.get('/asset/disincorporations/get-motives').then(response => {
					vm.motives = response.data;
				});

			}
		}
	};
</script>

