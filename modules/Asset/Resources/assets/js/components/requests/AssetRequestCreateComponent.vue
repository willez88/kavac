<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Solicitud de Bienes Institucionales</h6>
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
				<div class="col-md-6" v-if="this.record.id">
				    <div class="form-group">
				        <label>Fecha de Solicitud</label>
				        <div class="input-group input-sm">
                        	<span class="input-group-addon">
                            	<i class="now-ui-icons ui-1_calendar-60"></i>
                        	</span>
                        	<input type="date" class="form-control input-sm" data-toogle="tolltip" 
                        			title="Fecha de la solicitud" v-model="record.created_at" disabled:true>
                    	</div>
				    </div>
				</div>
			
				<div class="col-md-6">
				    <div class="form-group is-required">
				        <label>Motivo de la solicitud</label>
				        <textarea  data-toggle="tooltip" 
								   title="Indique el motivo de la solicitud" 
								   class="form-control input-sm" v-model="record.motive">
					   </textarea>
				    </div>
				</div>

				<div class="col-md-6">
					<div class="form-group is-required">
						<label>Tipo de Solicitud</label>
						<select2 :options="types" 
								 v-model="record.type_id"></select2>
					</div>
				</div>
			</div>
			<div class="row" v-show="record.type_id > 1">
				<div class="col-md-6">
			        <div class="form-group is-required">
			            <label>Fecha de Entrega</label>
			            <div class="input-group input-sm">
			                <span class="input-group-addon">
								<i class="now-ui-icons ui-1_calendar-60"></i>
			                </span>
			                <input type="date" class="form-control input-sm" data-toogle="tolltip" 
                        			title="Indique la fecha de entrega" v-model="record.delivery_date">
			            </div>
			            
			        </div>
			    </div>

			    <div class="col-md-6">
			        <div class="form-group is-required">
			            <label>Ubicación</label>
			            <input type="text" class="form-control input-sm" data-toogle="tolltip" 
                        			title="Indique una descripción de la ubicación del bien" v-model="record.ubication">
			        </div>
			    </div>
			</div>
			<div class="row" v-show="record.type_id == 3">
				<div class="col-md-12">
				    <b>Información de Contacto</b>    
				</div>
				    
				<div class="col-md-4">
					<div class="form-group is-required">
				        <label>Nombre del Agente Externo</label>
				        <input type="text" class="form-control input-sm" data-toogle="tolltip" 
                        			title="Indique el nombre del agente externo responsable del bien" v-model="record.agent_name">
				    </div>
				</div>
				
				<div class="col-md-4">
				    <div class="form-group is-required">
				    	<label>Teléfono del Agente Externo</label>
				    	<input type="text" class="form-control input-sm" data-toogle="tolltip" 
                        			title="Indique el teléfono del agente externo responsable del bien" v-model="record.agent_telf">
				    </div>
				</div>
				
				<div class="col-md-4">
					<div class="form-group is-required">
				    	<label>Correo del Agente Externo</label>
				    	<input type="text" class="form-control input-sm" data-toogle="tolltip" 
                        			title="Indique el correo eléctronico del agente externo responsable del bien" v-model="record.agent_email">
				    </div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<b>Seleccione los Bienes a ingresar en la solicitud</b>
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

        	<button type="button"  @click="createRecord('asset/requests')"
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
					motive:'',
					type_id: '',
					delivery_date: '',
					ubication: '',
					agent_name: '',
					agent_telf: '',
					agent_email: '',

				},
				records: [],
				columns: ['check', 'serial_inventario', 'institution', 'condition', 'status', 'serial', 'marca', 'model'],
				errors: [],

				types: [{"id":"","text":"Seleccione..."},
						{"id":1,"text":"Prestamo de Equipos (Uso Interno)"},
						{"id":2,"text":"Prestamo de Equipos (Uso Externo)"},
						{"id":3,"text":"Prestamo de Equipos para Agentes Externos"}],
				
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
		},
		mounted() {
			if(this.requestid){
				this.loadForm(this.requestid);
			}
		},
		props: {
			requestid: Number, 
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
					created_at: '',
					motive:'',
					type_id: '',
					delivery_date: '',
					ubication: '',
					agent_name: '',
					agent_telf: '',
					agent_email: '',
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
						created_at: vm.record.created_at,
						motive: vm.record.motive,
						type_id: vm.record.type_id,
						delivery_date: vm.record.delivery_date,
						ubication: vm.record.ubication,
						agent_name: vm.record.agent_name,
						agent_telf: vm.record.agent_telf,
						agent_email: vm.record.agent_email,
						assets: vm.selected,
					};

					axios.post('/' + url, fields).then(response => {
						if (response.data.result) {
	                        vm.showMessage('store');
	                        setTimeout(function() {
	                            window.location.href = '/asset/requests';
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
					created_at: vm.record.created_at,
					motive: vm.record.motive,
					type_id: vm.record.type_id,
					delivery_date: vm.record.delivery_date,
					ubication: vm.record.ubication,
					agent_name: vm.record.agent_name,
					agent_telf: vm.record.agent_telf,
					agent_email: vm.record.agent_email,
					assets: vm.selected,
				};

				axios.patch('/' + url + '/' + vm.record.id, fields).then(response => {
					if (response.data.result) {
                        vm.showMessage('update');
                        setTimeout(function() {
                            window.location.href = '/asset/requests';
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
	            
	            axios.get('/asset/requests/vue-info/'+id).then(response => {
	                if(typeof(response.data.records != "undefined")){

						vm.record = response.data.records;
	                    fields = response.data.records.assets;
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
		}
	};
</script>