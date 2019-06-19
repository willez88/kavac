<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
			<button @click="show_info(props.row.id)" v-if="route_show"
    				class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
    				title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
    			<i class="fa fa-eye"></i>
    		</button>
            <div class="modal fade" tabindex="-1" role="dialog" id="show_socioeconomic_information">
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
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_staff">
        							</div>
        						</div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Estado Civil</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_marital_status">
        				            </div>
        				        </div>
                            </div>
                            <div class="row">
        						<div class="col-md-4">
        							<div class="form-group">
        								<label>Nombres y Apellidos de la Pareja del Trabajador</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="full_name_twosome">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Cédula de Identidad de la Pareja del Trabajador</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="id_number_twosome">
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Fecha de Nacimiento de la Pareja del Trabajador</label>
        				        		<input type="text" data-toggle="tooltip" class="form-control"
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
</template>
<script>
    export default {
        data() {
			return {
				records: [],
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
                axios.get('/payroll/socioeconomic-informations/info/' + id).then(response => {
					var record = response.data.record;
                    $('#payroll_staff').val(record.payroll_staff);
                    $('#payroll_marital_status').val(record.payroll_marital_status);
                    $('#full_name_twosome').val(record.full_name_twosome);
                    $('#id_number_twosome').val(record.id_number_twosome);
                    $('#birthdate_twosome').val(record.birthdate_twosome);
				});
                $('#show_socioeconomic_information').modal('show');
            }
        }
    };
</script>
