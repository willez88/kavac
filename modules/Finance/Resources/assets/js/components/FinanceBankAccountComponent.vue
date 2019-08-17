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
							<div class="col-md-2">
								<div class="form-group is-required">
									<label>Fecha de apertura</label>
									<input type="date" v-model="record.opened_at" class="form-control input-sm"
										   data-toggle="tooltip"
										   title="Indique la fecha en la que se aperturó la cuenta">
								</div>
							</div>
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
						<div class="row">
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Tipo de Cuenta:</label>
									<select2 :options="account_types"
											 v-model="record.finance_account_type_id"></select2>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Código Cuenta Cliente</label>
									<div class="row">
										<div class="col-3">
											<input type="text" class="form-control input-sm"
												   id="bank_code" v-model="record.bank_code" readonly>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control input-sm"
												   data-toggle="tooltip" v-model="record.ccc_number"
												   title="Indique el número de cuenta sin guiones o espacios"
												   maxlength="16">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<div class="form-group is-required">
									<label>Descripción</label>
									<textarea class="form-control" rows="3" v-model="record.description"
											  data-toggle="tooltip"
											  title="Indique la descripción u objetivo de la cuenta"></textarea>
								</div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="financeBankingAgency" slot-scope="props">
	                			{{ props.row.financeBankingAgency.finance_bank.short_name }}
	                		</div>
	                		<div slot="ccc_number" slot-scope="props" class="text-center">
	                			{{ format_bank_account(props.row.ccc_number) }}
	                		</div>
	                		<div slot="opened_at" slot-scope="props" class="text-center">
	                			{{ format_date(props.row.opened_at) }}
	                		</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-round"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, '/finance/bank-accounts')"
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
	                	<button type="button" @click="createRecord('finance/bank-accounts')"
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
					finance_banking_agency_id: '',
					finance_account_type_id: '',
					ccc_number: '',
					bank_code: '',
					description: '',
					opened_at: '',
				},
				errors: [],
				records: [],
				banks: [],
				agencies: [],
				account_types: [],
				columns: ['financeBankingAgency', 'ccc_number', 'opened_at', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					finance_bank_id: '',
					finance_banking_agency_id: '',
					finance_account_type_id: '',
					ccc_number: '',
					bank_code: '',
					description: '',
					opened_at: ''
				};
			},
		},
		created() {
			this.table_options.headings = {
				'financeBankingAgency': 'Banco',
				'ccc_number': 'Código Cuenta Cliente',
				'opened_at': 'Fecha de apertura',
				'id': 'Acción'
			};
			this.table_options.sortable = ['financeBankingAgency', 'ccc_number'];
			this.table_options.filterable = ['financeBankingAgency', 'cc_number'];
			this.table_options.columnsClasses = {
				'financeBankingAgency': 'col-md-4',
				'ccc_number': 'col-md-4',
				'opened_at': 'col-md-2',
				'id': 'col-md-2'
			};
			this.getBanks();
			this.getAccountTypes();
		},
	};
</script>
