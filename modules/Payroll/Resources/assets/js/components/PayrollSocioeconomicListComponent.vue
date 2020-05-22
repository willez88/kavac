<template>
    <div>
        <v-client-table :columns="columns" :data="records" :options="table_options">
    		<div slot="id" slot-scope="props" class="text-center">
    			<button @click="show_info(props.row.id)" v-if="route_show"
        				class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
        				title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
        			<i class="fa fa-eye"></i>
        		</button>
                <button @click="editForm(props.row.id)" v-if="!props.row.assigned"
        				class="btn btn-warning btn-xs btn-icon btn-action btn-tooltip"
        				title="Modificar registro" data-toggle="tooltip" data-placement="bottom" type="button">
        			<i class="fa fa-edit"></i>
        		</button>
        		<button @click="deleteRecord(props.index, '')"
    					class="btn btn-danger btn-xs btn-icon btn-action btn-tooltip"
    					title="Eliminar registro" data-toggle="tooltip" data-placement="bottom"
    					type="button">
    				<i class="fa fa-trash-o"></i>
    			</button>
    		</div>
    	</v-client-table>
        <div class="modal fade" tabindex="-1" role="dialog" id="show_socioeconomic">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        <h6>
                            <i class="icofont icofont-read-book ico-2x"></i>
                            Información Detallada de Datos Socioeconómicos
                        </h6>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Trabajador</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="payroll_staff">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado Civil</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="marital_status">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Nombres y Apellidos de la Pareja del Trabajador</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="full_name_twosome">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cédula de Identidad de la Pareja del Trabajador</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="id_number_twosome">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha de Nacimiento de la Pareja del Trabajador</label>
                                    <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                        disabled="true" id="birthdate_twosome">
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col-md-3">
                                <h6 class="card-title">
                                    Hijos del Trabajador
                                </h6>
                            </div>
                            <div class="row" v-for="payroll_children in record.payroll_childrens">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nombres</label>
                                        <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                            disabled="true" :value="payroll_children.first_name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Apellidos</label>
                                        <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                            disabled="true" :value="payroll_children.last_name">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Cédula de Identidad</label>
                                        <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                            disabled="true" :value="payroll_children.id_number">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha de Nacimiento</label>
                                        <input type="text" data-toggle="tooltip" class="form-control input-sm"
                                            disabled="true" :value="payroll_children.birthdate">
                                    </div>
                                </div>
                            </div>
                        </div>
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
				records: [],
                record: [],
				columns: ['payroll_staff.first_name', 'marital_status.name', 'id'],
			}
		},

        created() {
			this.table_options.headings = {
                'payroll_staff.first_name': 'Trabajador',
				'marital_status.name': 'Estado Civil',
				'id': 'Acción'
			};
            this.table_options.sortable = ['payroll_staff.first_name', 'marital_status.name'];
			this.table_options.filterable = ['payroll_staff.first_name', 'marital_status.name'];
		},

		mounted() {
			this.initRecords(this.route_list, '');
		},

        methods: {
            reset() {

            },

            show_info(id) {
                axios.get('/payroll/socioeconomics/' + id).then(response => {
					this.record = response.data.record;
                    $('#payroll_staff').val(this.record.payroll_staff.first_name + ' ' + this.record.payroll_staff.last_name);
                    $('#marital_status').val(this.record.marital_status.name);
                    $('#full_name_twosome').val(this.record.full_name_twosome);
                    $('#id_number_twosome').val(this.record.id_number_twosome);
                    $('#birthdate_twosome').val(this.record.birthdate_twosome);
				});
                $('#show_socioeconomic').modal('show');
            }
        }
    };
</script>
