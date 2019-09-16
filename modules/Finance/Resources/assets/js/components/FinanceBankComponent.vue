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
								<div class="form-group">
									<label>Logo</label>
									<image-management ref="banklogo" v-on:changeImage="setRecordImage($event)"
													  :img-width="'96px'" :img-height="'96px'"
													  :img-id="(record.logo_id)?record.logo_id:0"
													  :img-default="(typeof(record.logo)!=='undefined' && record.logo!==null)
													  ?'/'+record.logo.url:'/images/no-image2.png'"></image-management>
								</div>
							</div>
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
	                <div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'finance/banks'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<a slot="website" slot-scope="props" target="_blank" :href="'http://'+props.row.website"
	                		   v-if="props.row.website">
	                			{{ props.row.website }}
	                		</a>
	                		<div slot="logo" slot-scope="props" class="text-center">
	                			<img :src="'/'+props.row.logo.url" alt="Logo del banco" class="img-fluid bank-logo"
	                				 v-if="props.row.logo">
	                		</div>
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.index, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-round"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.index, '/finance/banks')"
										class="btn btn-danger btn-xs btn-icon btn-round"
										title="Eliminar registro" data-toggle="tooltip"
										type="button">
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

<style>
	.bank-logo {
		width: 48px;
		height: 48px;
	}
</style>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					logo_id: '',
					code: '',
					name: '',
					short_name: '',
					website: ''
				},
				errors: [],
				records: [],
				columns: ['logo', 'code', 'short_name', 'name', 'website', 'id'],
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
					code: '',
					name: '',
					short_name: '',
					website: '',
					logo_id: ''
				};
				this.$refs.banklogo.id = '';
				this.$refs.banklogo.url = `${window.app_url}/images/no-image2.png`;
			},
			setRecordImage(imageId) {
				console.log(imageId)
				this.record.logo_id = imageId;
			}
		},
		created() {
			this.table_options.headings = {
				'logo': 'Logo',
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
