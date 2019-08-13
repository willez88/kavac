<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Catálogo de Cuentas patrimoniales" 
		   data-toggle="tooltip" @click="addRecord('CRUD_accounts', '/accounting/accounts', $event)">
			<i class="fa fa-list ico-3x"></i>
			<span>Catálogo de cuentas</span>
		</a>

		<div class="modal fade text-left" tabindex="-1" role="dialog" id="CRUD_accounts">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button class="btn btn-sm btn-primary btn-custom" style="margin-right: 1.8rem; margin-top: -.1rem;"
								title="Importar cuentas patrimoniales desde hoja de cálculo"
								data-toggle="tooltip"
								@click="OpenImportForm(true)"
								v-show="!formImport">
								Importar Hoja de Cálculo <i class="fa fa-file-excel-o"></i>
						</button>
						<button class="btn btn-sm btn-primary btn-custom" style="margin-right: 1.8rem; margin-top: -.1rem;" 
								title="formulario de creación manual"
								data-toggle="tooltip"
								@click="OpenImportForm(false)"
								v-show="formImport">
								Creación Estandar
						</button>

						<button type="reset" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="fa fa-list inline-block"></i> 
							CUENTAS PATRIMONIALES
						</h6>
					</div>
					<!-- Fromulario -->
					<div class="modal-body">

						<accounting-show-errors :errors="errors" />

					</div>
	                <div class="modal-body card-body" v-show="formImport">
	                	<accounting-import-form />
	                </div>
					<div class="modal-body" v-show="!formImport && records_select.length > 0">
						<accounting-create-edit-form :records="records_select" />
	                </div>

					<!-- Tabla de cuentas patrimoniales -->

	                <div class="modal-body modal-table" v-show="!formImport && records_list.length > 0">
	                	<hr>
						<accounting-accounts-list :records="records_list" />
	                </div>
	                <div class="modal-footer">
	                	<button type="reset" class="btn btn-default btn-sm btn-modal-close"
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" class="btn btn-sm btn-primary btn-modal-close"
								title="Guardar registros importados desde la hoja de cálculo"
								v-if="formImport"
								@click="registerImportedAccounts()"
								data-toggle="tooltip">
								Guardar Registros Importados
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
			records:[],
			records_list:[],
			formImport:false,
			accounts:null,
		}
	},
	created(){
		EventBus.$on('register:imported-accounts',(data)=>{
				this.accounts = data;
			});
		EventBus.$on('reload:list-accounts',(data)=>{
				this.reset();
				this.records = data;
			});
		EventBus.$on('show:errors',(data)=>{
				this.errors = [];
				this.errors = data;
			});
	},
	methods:{
		/**
		 * Método que borra todos los datos del formulario
		 * 
		 * @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
		 */
		reset() {
			this.formImport = false;
		},

		/**
		* Función que cambia el valor para cambiar el formulario mostrado
		* @var boolean Usada para cambiar el tipo de formulario que se mostrara
		* @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
		*/
		OpenImportForm:function(val) {
			if (val) {
				EventBus.$emit('reset:import-form');
			}else{
				EventBus.$emit('load:data-account-form', null);
			}
			this.formImport = val;

			this.errors = [];
		},

		/**
		* Guarda los registros cargados desde la hora de cálculo
		* 
		* @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
		*/
		registerImportedAccounts:function() {
			const vm = this;
			if (vm.accounts != null) {
				axios.post('/accounting/importedAccounts', { records: vm.accounts }).then(response=>{
					vm.showMessage(
						'custom', 'Éxito', 'success', 'screen-ok', 
						response.data.message
					);
					vm.reset();
					EventBus.$emit('reload:list-accounts',response.data.records);
				});
			}else{
				this.errors = [];
				this.errors.push('No hay cuentas cargadas.');
			}
		}
	},
	watch:{
		records:function(res, ant) {
			/** listado con las cuentas para la tabla */
			this.records_list = res;
		}
	},
	computed:{
		records_select: function(){
			return [{
					'id':'',
					'text':'Seleccione...'
				}].concat(this.records);
		}
	}
};
</script>