<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de cuentas bancarias" 
		   data-toggle="tooltip" @click="addRecord('add_bank_account', '/finance/bank-accounts', $event)">
			<i class="icofont icofont-law-document ico-3x"></i>
			<span>Cuentas<br>Bancarias</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_bank_account">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-law-document inline-block"></i> 
							Cuenta Bancaria
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Banco:</label>
									<select2 :options="banks" @input="getAgencies" 
											 v-model="record.finance_bank_id"></select2>
									<input type="hidden" v-model="record.id">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Agencia:</label>
									<select2 :options="agencies" 
											 v-model="record.finance_banking_agency_id"></select2>
			                    </div>
							</div>
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
		                		<button @click="deleteRecord(props.index, '/finance/account-types')" 
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
	                	<button type="button" @click="createRecord('finance/account-types')" 
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
					finance_banking_agency_id: ''
				},
				errors: [],
				records: [],
				banks: [],
				agencies: ['0'],
				columns: ['finance_bank_id', 'ccc_number', 'opened_at', 'id'],
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
					finance_bank_id: '',
					finance_banking_agency_id: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'finance_bank_id': 'Banco',
				'ccc_number': 'Código Cuenta Cliente',
				'id': 'Acción'
			};
			this.table_options.sortable = ['finance_bank_id', 'ccc_number'];
			this.table_options.filterable = ['finance_bank_id', 'cc_number'];
			this.table_options.columnsClasses = {
				'finance_bank_id': 'col-md-4',
				'ccc_number': 'col-md-4',
				'opened_at': 'col-md-2',
				'id': 'col-md-2'
			};
			this.getBanks();
		},
	};
</script>