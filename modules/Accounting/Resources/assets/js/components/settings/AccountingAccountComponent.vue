<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Catálogo de Cuentas patrimoniales"
		   data-toggle="tooltip" @click="addRecord('CRUD_accounts', 'accounting/accounts', $event)">
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
								<i class="fa fa-file-excel-o"></i>
						</button>
						<button class="btn btn-sm btn-primary btn-custom" style="margin-right: 1.8rem; margin-top: -.1rem;"
								title="formulario de creación manual"
								data-toggle="tooltip"
								@click="OpenImportForm(false)"
								v-show="formImport">
								<i class="fa fa-reply"></i>
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

						<accounting-show-errors ref="accountingAccountForm" />

					</div>
	                <div class="modal-body card-body" v-show="formImport">
	                	<accounting-import-form />
	                </div>
	                <hr>
					<div class="modal-body" style="margin-top: -5rem;" v-show="!formImport && records_select.length > 0">
						<accounting-form :records="records_select" />
	                </div>

					<div class="modal-footer" v-if="!formImport">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'/accounting/accounts/'"></modal-form-buttons>
	                	</div>
	                </div>

					<!-- Tabla de cuentas patrimoniales -->

	                <div class="modal-body modal-table" v-show="records_list.length > 0">
	                	<hr>
						<accounting-accounts-list :records="records_list" />
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
		EventBus.$on('reload:list-accounts',(data)=>{
			this.reset();
			this.records = data;
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

		createRecord:function(url) {
			if (this.formImport) {
				this.registerImportedAccounts(url);
			}else{
				this.registerAccount(url);
			}
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
		registerImportedAccounts:function(url) {
			const vm = this;
			if (vm.accounts != null) {
				axios.post(url, { records: vm.accounts }).then(response=>{
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
		},

		/**
		 * [registerAccount emite un evento para guardar la cuenta patrimonial]
		 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		 */
		registerAccount(url){
			EventBus.$emit('register:account',url);
		}
	},
	watch:{
		records:function(res, ant) {
			/**
			 * [records_list listado con las cuentas para la tabla]
			 * @type {array}
			 */
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
