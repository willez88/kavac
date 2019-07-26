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
						<button class="btn btn-sm btn-primary btn-custom" style="margin-right: 1rem; margin-top: -0.rem;" 
								title="Importar cuentas patrimoniales desde hoja de cálculo"
								data-toggle="tooltip"
								@click="OpenImportForm(true)"
								v-if="!formImport">
								Importar Hoja de Cálculo <i class="fa fa-file-excel-o"></i>
						</button>
						<button class="btn btn-sm btn-primary btn-custom" style="margin-right: 1rem; margin-top: -0.rem;" 
								title="formulario de creación manual"
								data-toggle="tooltip"
								@click="OpenImportForm(false)"
								v-if="formImport">
								Creación Estandar
						</button>

						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="fa fa-list inline-block"></i> 
							CUENTAS PATRIMONIALES
						</h6>
					</div>
					<!-- Fromulario -->
	                <div class="modal-body card-body" v-if="formImport">
	                	<accounting-import-excel-form />
	                </div>
					<div class="modal-body" v-else-if="!formImport && records.length > 0">
						<accounting-create-edit-form :records="records" />
	                </div>

					<!-- Tabla de cuentas patrimoniales -->

	                <div class="modal-body modal-table" v-if="!formImport && records.length > 0">
	                	<hr>
						<accounting-accounts-list :accountslist="records" />
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" class="btn btn-sm btn-primary btn-modal-close"
								title="Guardar registros importados desde la hoja de cálculo"
								v-if="formImport"
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
			formImport:false,
		}
	},
	methods:{
		/**
		 * Método que borra todos los datos del formulario
		 * 
		 * @author  Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
		 */
		reset() {
			// 
		},
		OpenImportForm:function(val) {
			this.formImport = val;
		}
	},
};
</script>