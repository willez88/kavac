<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de entidades bancarias" 
		   data-toggle="tooltip" @click="addRecord('add_bank', '/finance/banks', $event)">
			<i class="icofont icofont-bank-alt ico-3x"></i>
			<span>Bancos</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_bank">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-bank-alt inline-block"></i> 
							Bancos
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
									<label>Código</label>
									<input type="text" placeholder="0000" maxlength="4" data-toggle="tooltip" 
										   title="Indique el código de la entidad bancaria (requerido)" 
										   class="form-control input-sm" v-model="record.code" autofocus>
									<input type="hidden" v-model="record.id">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group is-required">
									<label>Nonmbre Abreviado</label>
									<input type="text" placeholder="Nombre corto" data-toggle="tooltip" 
										   title="Indique el nombre abreviado de la entidad bancaria (requerido)" 
										   class="form-control input-sm" v-model="record.short_name">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group is-required">
									<label>Nombre:</label>
									<input type="text" placeholder="Nombre del Banco" data-toggle="tooltip" 
										   title="Indique el nombre del banco (requerido)" 
										   class="form-control input-sm" v-model="record.name">
			                    </div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Sitio Web:</label>
									<input type="url" placeholder="Sitio Web" data-toggle="tooltip" 
										   title="Indique el sitio web de la entidad bancaria" 
										   class="form-control input-sm" v-model="record.website">
			                    </div>
							</div>
						</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<hr>
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<a slot="website" slot-scope="props" target="_blank" :href="'http://'+props.row.website" 
	                		   v-if="props.row.website">
	                			{{ props.row.website }}
	                		</a>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)" 
		                				class="btn btn-warning btn-xs btn-icon btn-round" 
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, 'finance/banks')" 
										class="btn btn-danger btn-xs btn-icon btn-round" 
										title="Eliminar registro" data-toggle="tooltip" 
										type="button">
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
	                	<button type="button" @click="createRecord('finance/banks')" 
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
					code: '',
					name: '',
					short_name: '',
					website: ''
				},
				errors: [],
				records: [],
				columns: ['code', 'short_name', 'name', 'website', 'id'],
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'short_name': 'Nombre',
				'name': 'Descripción',
				'website': 'Sitio Web',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'short_name', 'name'];
			this.table_options.filterable = ['code', 'short_name', 'name'];

		},
	};
</script>