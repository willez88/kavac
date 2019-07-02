<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de entidades bancarias" 
		   data-toggle="tooltip" @click="addRecord('add_categories', '/accounting/settings/categories', $event)">
			<i class="fa fa-tags ico-3x"></i>
			<span>Categorias de origen</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_categories">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-bank-alt inline-block"></i> 
							Categorias
						</h6>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="card-body">
								<div class="row">
									<div class="col-1"></div>
									<div class="form-group col-5 is-required">
										<label class="control-label">Nombre</label>
										<input type="text"
												class="form-control"
												title="Ingrese el nombre de la categoria"
												data-toggle="tooltip"
												v-model="record.name">
									</div>
									<div class="form-group col-5 is-required">
										<label class="control-label">Acrónimo</label>
										<input type="text"
												class="form-control"
												title="Ingrese el acrónimo"
												data-toggle="tooltip"
												v-model="record.acronym">
									</div>
								</div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="name" slot-scope="props">
	                			{{ props.row.name }}
	                		</div>
	                		<div slot="acronym" slot-scope="props">
	                			{{ props.row.acronym }}
	                		</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="loadCategory(props.row)" 
		                				class="btn btn-warning btn-xs btn-icon" 
		                				title="Modificar registro" data-toggle="tooltip">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, '/accounting/settings/categories')" 
										class="btn btn-danger btn-xs btn-icon" 
										title="Eliminar registro" data-toggle="tooltip" >
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button class="btn btn-primary btn-sm btn-round btn-modal-save" 
								title="Guardar registro"
								data-toggle="tooltip"
								:disabled="record.name=='' || record.acronym==''"
								@click="storeOrUpdate()">Guardar
						</button>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</template>

<script>
export default{
	data(){
		return{
			errors:[],
			columns:['name','acronym','id'],
			records:[],
			record:{
				name:'',
				acronym:'',
			},
			state:'store'
		}
	},
	created(){
		this.table_options.headings = {
			'name': 'NOMBRE',
			'acronym': 'ACRÓNIMO',
			'id':'ACCIÓN'
		};
	},
	methods:{
		/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					name: '',
					acronym: '',
				};
			},
		/**
		* Valida información del formulario de categoria
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		* @param  {boolean} name bandera que establece si hay que validar el nombre de la categoria
		* @param  {boolean} acronym bandera que establece si hay que validar el acronimo de la categoria
		* @return {boolean} Devuelve falso si la información no es única
		*/
		validInformation(name=true , acronym=true){
			var jumpOne = (this.state == 'update') ? true : false;

			// verifica que no este repetida la información
			// en caso de estar actualizando se lo salta
			for (var i = 0; i < this.records.length; i++) {
				if (acronym && this.record.acronym == this.records[i].acronym) {
					if (jumpOne) {
						jumpOne = false;
						continue;
					}
					this.warnings = [];
					this.warnings.push('El acrónimo debe ser único.');
					return false;
				}
				if (name && this.record.name == this.records[i].name) {
					if (jumpOne) {
						jumpOne = false;
						continue;
					}
					this.warnings = [];
					this.warnings.push('El nombre debe ser único.');
					return false;
				}
			}
			return true;
		},
		// /**
		// * Guarda o Actualiza la información de la nueva categoria
		// *
		// * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		// */
		storeOrUpdate(){
			const vm = this;
			this.record.acronym = this.record.acronym.toUpperCase();

			if (this.state == 'store') {
				if (!this.validInformation()) return;

				axios.post('/accounting/settings/categories',this.record).then(response=>{
					this.records = response.data.records;
					this.record = {
						name:'',
						acronym:''
					};
					vm.showMessage('store');
				});

			}else{
				if (!this.validInformation(false)) return;

				axios.put('/accounting/settings/categories/'+this.record.id,this.record).then(response=>{
					this.records = response.data.records;
					this.record = {
						name:'',
						acronym:''
					};
					vm.state = 'store'; // se cambia el estado para mostrar el boton guardar
					vm.showMessage('update');
				});
			}

		},

		/**
		* Carga la información de la categoria en el formulario y cambia el estado de acción a realizar
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		*/
		loadCategory(record){
			this.record.id = record.id;
			this.record.name = record.name;
			this.record.acronym = record.acronym;
			this.state = 'update'; // se cambia el estado para mostrar el boton actualizar
		},
	}
};
</script>