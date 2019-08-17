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
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Fecha de ingreso a la administración pública</label>
        								<input type="date" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="start_date_apn">
        							</div>
        						</div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Fecha de ingreso a la institución</label>
        								<input type="date" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="start_date">
        							</div>
        						</div>
                            </div>
                            <div class="row">
        						<div class="col-md-4">
        							<div class="form-group">
        								<label>Fecha de egreso de la institución</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="end_date">
        							</div>
        						</div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>¿Está Activo?</label>
                                        <input id="active" class="form-control bootstrap-switch"
                                            data-on-label="SI" data-off-label="NO" type="checkbox">
        							</div>
        						</div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Tipo de la Inactividad</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_inactivity_type">
        							</div>
        						</div>
                            </div>
                            <div class="row">
        						<div class="col-md-4">
        							<div class="form-group">
        								<label>Correo Institucional</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="institution_email">
        							</div>
        						</div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Descripción de las Funciones</label>
        				        		<textarea class="form-control" disabled="true"
                                            id="function_description">
                                        </textarea>
        				            </div>
        				        </div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Tipo de Cargo</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_position_type">
        							</div>
        						</div>
                            </div>
                            <div class="row">
        						<div class="col-md-4">
        							<div class="form-group">
        								<label>Cargo</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_position">
        							</div>
        						</div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Tipo de Personal</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_staff_type">
        							</div>
        						</div>
                                <div class="col-md-4">
        							<div class="form-group">
        								<label>Departamento</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="department">
        							</div>
        						</div>
                            </div>
                            <div class="row">
        						<div class="col-md-4">
        							<div class="form-group">
        								<label>Tipo de Contrato</label>
        								<input type="text" data-toggle="tooltip" class="form-control"
                                            disabled="true" id="payroll_contract_type">
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
        <div slot="active" slot-scope="props" class="text-center">
            <span v-if="props.row.active">SI</span>
            <span v-else>NO</span>
        </div>
	</v-client-table>
</template>
<script>
    export default {
        data() {
			return {
				records: [],
                record: [],
				columns: ['payrollStaff.first_name', 'institution_email', 'active', 'id'],
			}
		},

        created() {
			this.table_options.headings = {
                'payrollStaff.first_name': 'Trabajador',
				'institution_email': 'Correo Electrónico Institucional',
				'active': '¿Está Activo?',
				'id': 'Acción'
			};
            this.table_options.sortable = ['payrollStaff.first_name', 'institution_email'];
			this.table_options.filterable = ['payrollStaff.first_name', 'institution_email'];
		},

		mounted() {
			this.initRecords(this.route_list, '');
		},

        methods: {
            reset() {

            },

            show_info(id) {
                axios.get('/payroll/employment-informations/' + id).then(response => {
					this.record = response.data.record;
                    $('#payroll_staff').val(this.record.payroll_staff.first_name + ' ' + this.record.payroll_staff.last_name);
                    $('#start_date_apn').val(this.record.start_date_apn);
                    $('#start_date').val(this.record.start_date);
                    $('#start_end').val(this.record.start_end);
                    (this.record.active) ? $('#active').bootstrapSwitch('state', true) : $('#active').bootstrapSwitch('state', false);
                    $('#payroll_inactivity_type').val( (this.record.payroll_inactivity_type) ? this.record.payroll_inactivity_type.name : ' ' );
                    $('#institution_email').val(this.record.institution_email);
                    $('#function_description').val(this.record.function_description);
                    $('#payroll_position_type').val(this.record.payroll_position_type.name);
                    $('#payroll_position').val(this.record.payroll_position.name);
                    $('#payroll_staff_type').val(this.record.payroll_staff_type.name);
                    $('#department').val(this.record.department.name);
                    $('#payroll_contract_type').val(this.record.payroll_contract_type.name);
				});
                $('#show_employment_information').modal('show');
            }
        }
    };
</script>
