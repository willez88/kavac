<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de chequeras" 
		   data-toggle="tooltip" 
		   @click="addRecord('add_check_book', '/finance/check-books', $event)">
			<i class="icofont icofont-card ico-3x"></i>
			<span>Chequeras</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_check_book">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-card inline-block"></i> 
							Chequera
						</h6>
					</div>
					<div class="modal-body">
						<input type="hidden" v-model="record.id">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Banco</label>
									<select2 :options="banks" v-model="record.finance_bank_id" 
											 @input="getBankAccounts"></select2>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Cuenta</label>
									<select2 :options="accounts" v-model="record.finance_bank_account_id"></select2>
								</div>
							</div>
						</div>
						<div class="row">
							
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-round" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, '/finance/check-books')" 
										class="btn btn-danger btn-xs btn-icon btn-round" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
									<i class="fa fa-trash-o"></i>
								</button>
	                		</div>
	                	</v-client-table>
	                </div>
	                <div class="modal-footer">
	                	<button type="button" data-dismiss="modal" 
	                			class="btn btn-default btn-sm btn-round btn-modal-close">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createRecord('finance/check-books')" 
	                			class="btn btn-primary btn-sm btn-round btn-modal-save">
	                		Guardar
		                </button>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					finance_bank_id: '',
					finance_bank_account_id: ''
				},
				banks: [],
				accounts: [],
				errors: [],
				records: [],
				columns: ['name', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					name: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'name': 'Nombre',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
			this.table_options.columnsClasses = {
				'name': 'col-md-10',
				'id': 'col-md-2'
			};
			this.getBanks();
		},
	};
</script>