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
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="fa fa-list inline-block"></i> 
							CUENTAS PATRIMONIALES
						</h6>
					</div>
					<div class="modal-body" v-if="records.length > 0">
						<accounting-create-edit-form :records="records" />
	                </div>
	                <div class="modal-body modal-table" v-if="records.length > 0">
	                	<hr>
						<accounting-accounts-list :accountslist="records" />
	                </div>
	                <div class="modal-footer">
	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
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
		}
	},
	created(){
		
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
	},
};
</script>