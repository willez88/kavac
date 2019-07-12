<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
			<button @click="show_info(props.row.id)" v-if="route_show"
    				class="btn btn-info btn-xs btn-icon btn-action btn-tooltip"
    				title="Ver registro" data-toggle="tooltip" data-placement="bottom" type="button">
    			<i class="fa fa-eye"></i>
    		</button>
            <div class="modal fade" tabindex="-1" role="dialog" id="show_employment_information">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
        						<span aria-hidden="true">×</span>
        					</button>
        					<h6>
        						<i class="icofont icofont-read-book ico-2x"></i>
        						Información Detallada de Datos Laborales
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
				columns: ['payroll_staff.first_name', 'institution_email', 'active', 'id'],
			}
		},

        created() {
			this.table_options.headings = {
                'payroll_staff.first_name': 'Trabajador',
				'institution_email': 'Correo Electrónico Institucional',
				'active': '¿?Está Activo',
				'id': 'Acción'
			};
            this.table_options.sortable = ['payroll_staff.first_name', 'institution_email'];
			this.table_options.filterable = ['payroll_staff.first_name', 'institution_email'];
		},

		mounted() {
			this.initRecords(this.route_list, '');
		},

        methods: {
            reset() {

            },

            show_info(id) {
                axios.get('/payroll/employment-informations/' + id).then(response => {
					var record = response.data.record;
                    $('#payroll_staff').val(record.payroll_staff);
				});
                $('#show_employment_information').modal('show');
            }
        }
    };
</script>
