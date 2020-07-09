<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros de categorias de origen de asientos contables"
		   data-toggle="tooltip" @click="addRecord('CRUD_categories', '/accounting/settings/categories', $event)">
			<i class="fa fa-tags ico-3x"></i>
			<span>Categorias de origen</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="CRUD_categories">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="fa fa-tags inline-block"></i>
							Categorias de origen
						</h6>
					</div>
					<div class="modal-body">

						<accounting-show-errors ref="originCategories" />

						<div class="row">
							<div class="card-body">
								<div class="row">
                                    <div class="col-6">
                                        <div class="form-group is-required">
                                            <label class="control-label">Nombre</label>
                                            <input type="text" class="form-control input-sm" v-model="record.name"
                                                   title="Ingrese el nombre de la categoria" data-toggle="tooltip">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group is-required">
                                            <label class="control-label">Acrónimo</label>
                                            <input type="text" :onkeyup="record.acronym=onlyNumbers(record.acronym,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')"
                                                   class="form-control input-sm" maxlength="4"
                                                   title="Ingrese el acrónimo" data-toggle="tooltip"
                                                   v-model="record.acronym">
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
	                </div>
	                <div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'/accounting/settings/categories/'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
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
		        </div>
		    </div>
		</div>
	</div>
</template>

<script>
export default{
	data(){
		return{
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
		this.table_options.sortable = ['name','acronym'];
		this.table_options.columnsClasses = {
            'name': 'col-xs-8',
            'acronym': 'col-xs-2',
            'id': 'col-xs-2'
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
			var errors = [];
			// verifica que no este repetida la información
			// en caso de estar actualizando se lo salta
			for (var i = 0; i < this.records.length; i++) {
				if (!this.record.name) {
					errors.push('El campo del nombre es obligatorio.');
					break;
				}
				else if (this.record.name == this.records[i].name) {
					if (jumpOne) {
						jumpOne = false;
						continue;
					}
					errors.push('El nombre debe ser único.');
				}
				if (!this.record.acronym) {
					errors.push('El campo del acrónimo es obligatorio.');
					break;
				}
				else if (this.record.acronym == this.records[i].acronym) {
					if (jumpOne) {
						jumpOne = false;
						continue;
					}
					errors.push('El acrónimo debe ser único.');
				}
			}
			if (errors.length > 0) {
				this.$refs.originCategories.showAlertMessages(errors);
				return false;
			}
			return true;
		},

		// /**
		// * Guarda o Actualiza la información de la nueva categoria
		// *
		// * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		// */
		createRecord(url){
			const vm = this;
			this.record.acronym = this.record.acronym.toUpperCase();

			if (this.state == 'store') {
				if (!this.validInformation()) return;

				axios.post(url,this.record).then(response=>{
					this.records = response.data.records;
					this.record = {
						name:'',
						acronym:''
					};
					vm.showMessage('store');
					this.$refs.originCategories.reset();
				});

			}else{
				if (!this.validInformation(false)) return;

				axios.put(url+this.record.id,this.record).then(response=>{
					this.records = response.data.records;
					this.record = {
						name:'',
						acronym:''
					};
					vm.state = 'store'; // se cambia el estado para mostrar el boton guardar
					vm.showMessage('update');
					this.$refs.originCategories.reset();
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
