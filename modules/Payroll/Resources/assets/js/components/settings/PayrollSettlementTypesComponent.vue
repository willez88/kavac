<template>
	<section class="text-center" id="payroll_settlement_type">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" href=""
		   title="Registros de tipos de liquidación" data-toggle="tooltip"
		   @click="addRecord('add_payroll_settlement_type', 'payroll/settlement-types', $event)">
           <i class="icofont icofont-eye ico-3x"></i>
		   <span>Tipos de<br>Liquidación</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_payroll_settlement_type">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-eye ico-3x"></i>
							Tipo de Liquidación
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
        							<label for="name">Nombre:</label>
        							<input type="text" id="name" placeholder="Nombre"
        								   class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
        								   title="Indique el nombre del tipo de liquidación (requerido)">
        							<input type="hidden" name="id" id="id" v-model="record.id">
        	                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label>Concepto:</label>
    								<select2 :options="payroll_concepts"
    									v-model="record.payroll_concept_id">
    								</select2>
        	                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group is-required">
                                    <label for="motive">Motivo:</label>
                                    <ckeditor :editor="ckeditor.editor" id="motive"
                                              data-toggle="tooltip"
                                              title="Indique el motivo del tipo de liquidación (requerido)"
                                              :config="ckeditor.editorConfig" class="form-control"
                                              name="motive"
                                              v-model="record.motive"></ckeditor>
        	                    </div>
                            </div>
                        </div>
	                </div>
					<div class="modal-footer">
	                	<div class="form-group">
	                		<modal-form-buttons :saveRoute="'payroll/settlement-types'"></modal-form-buttons>
	                	</div>
	                </div>
	                <div class="modal-body modal-table">
	                	<v-client-table :columns="columns" :data="records" :options="table_options">
	                		<div slot="id" slot-scope="props" class="text-center">
	                			<button @click="initUpdate(props.row.id, $event)"
		                				class="btn btn-warning btn-xs btn-icon btn-action"
		                				title="Modificar registro" data-toggle="tooltip" type="button">
		                			<i class="fa fa-edit"></i>
		                		</button>
		                		<button @click="deleteRecord(props.row.id, 'payroll/settlement-types')"
										class="btn btn-danger btn-xs btn-icon btn-action"
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
	</section>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					name: '',
                    motive: '',
                    payroll_concept_id: '',
				},
				errors: [],
				records: [],
                payroll_concepts: [],
				columns: ['name', 'motive', 'id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 *
			 * @author  William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					name: '',
                    motive: '',
                    payroll_concept_id: '',
				};
			},
		},
		created() {
			this.table_options.headings = {
				name: 'Nombre',
                motive: 'Motivo',
				id: 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
			this.table_options.columnsClasses = {
				name: 'col-md-5',
                motive: 'col-md-5',
				id: 'col-md-2'
			};
            this.getPayrollConcepts();
		},
	};
</script>
