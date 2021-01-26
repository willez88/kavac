<template>
	<div class="card">
        <div class="card-header">
            <h6 class="card-title">Datos de la Solicitud de Permisos</h6>
            <div class="card-btns">
                <a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)"
                   title="Ir atrás" data-toggle="tooltip">
                    <i class="fa fa-reply"></i>
                </a>
                <a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" data-toggle="tooltip">
                    <i class="now-ui-icons arrows-1_minimal-up"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <div class="container">
                    <div class="alert-icon">
                        <i class="now-ui-icons objects_support-17"></i>
                    </div>
                    <strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                            @click.prevent="errors = []">
                        <span aria-hidden="true">
                            <i class="now-ui-icons ui-1_simple-remove"></i>
                        </span>
                    </button>
                    <ul>
                        <li v-for="error in errors">{{ error }}</li>
                    </ul>
                </div>
            </div>
            <div class="row">
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="date">Fecha de Solicitud</label>
						<input type="date" readonly data-toggle="tooltip"
							   id="date" class="form-control input-sm"
							   title="Indique la fecha de solicitud" v-model="record.date">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="payrollStaff">Trabajador</label>
						<select2 :options="payroll_staffs"
								  @input="getPayrollStaff()"
								  v-model="record.payroll_staff_id"></select2>
                    </div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="payrollPermissionPolicy">Tipo de Permiso</label>
						<select2 :options="payroll_permission_policies" v-model="record.payroll_permission_policy_id"></select2>
					</div>
				</div>
            </div>
			<label>Periodo del Permiso</label>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Desde:</label>
						<div class="input-group input-sm">
							<span class="input-group-addon">
								<i class="now-ui-icons ui-1_calendar-60"></i>
							</span>
							<input type="date" id="start_date" @input="getcalculate()" data-toggle="tooltip" title="Indique la fecha de inicio del permiso"
								   class="form-control input-sm" v-model="record.start_date">
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>Hasta:</label>
						<div class="input-group input-sm">
							<span class="input-group-addon">
								<i class="now-ui-icons ui-1_calendar-60"></i>
							</span>
							<input type="date" id="end_date" @input="getcalculate()" data-toggle="tooltip" title="Indique la fecha final del permiso"
								   class="form-control input-sm" v-model="record.end_date">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="day_permission">Dias de permiso</label>
    					<input type="text" id="day_permission" class="form-control input-sm" data-toggle="tooltip"
                               title="Días de permiso" v-model="record.day_permission">
				    </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
				    <div class="form-group is-required">
					<label for="motive_permission">Motivo del permiso</label>
    				<input type="text" id="motive_permission" class="form-control input-sm" data-toggle="tooltip"
                        title="Indique el motivo del permiso" v-model="record.motive_permission">
				    </div>
				</div>
			</div>
		</div>

		<div class="card-footer text-right">
        	<button type="button" @click="reset()" class="btn btn-default btn-icon btn-round"
                    title ="Borrar datos del formulario">
					<i class="fa fa-eraser"></i>
			</button>
        	<button type="button" @click="redirect_back(route_list)"
                        class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                        title="Cancelar y regresar">
                    <i class="fa fa-ban"></i>
            </button>
			<button type="button"  @click="createRecord('payroll/permission-requests')" title="Guardar registro"
                    class="btn btn-success btn-icon btn-round btn-modal-save">
        			<i class="fa fa-save"></i>
            </button>
        </div>
   	</div>
</template>

<script>
	//import moment from 'moment';
	export default {
		data() {
			return {
				record: {
					id: '',
					date: '',
					payroll_staff_id: '',
					payroll_permission_policy_id: '',
					start_date: '',
					end_date: '',
					day_permission: '',
					motive_permission: '',
				},
				errors: [],
				records: [],
				payroll_staffs: [],
				payroll_permission_policies: []
			}
		},
		methods: {
			loadForm(id){
				const vm = this;

	            axios.get('/payroll/permission-requests/vue-info/'+id).then(response => {
	                if(typeof(response.data.record != "undefined")){
						vm.record = response.data.record;

	                }
	            });
				console.log(id);
			},
			/**
			 * Método que borra todos los datos del formulario
			 *
			 *
			 */
			reset() {
				this.record = {
					id: '',
					date: '',
					payroll_staff_id: '',
					payroll_permission_policy_id: '',
					start_date: '',
					end_date: '',
					day_permission: '',
					motive_permission: '',
				};
				this.payrollPermissionPolicy = '';
			},
			getPayrollPermissionPolicy() {
                const vm = this;
                $.each(vm.payroll_permission_policies, function(index, field) {
                    if (field['id'] == '') {
                        vm.payrollPermissionPolicy = '';
                    } else if (field['id'] == vm.record.payroll_permission_policy_id) {
                        vm.payrollPermissionPolicy = field['text'];
                    }
                });
            },

			getPayrollStaff() {
                const vm = this;
                $.each(vm.payroll_staffs, function(index, field) {
                    if (field['id'] == '') {
                        vm.payrollStaff = '';
                    } else if (field['id'] == vm.record.payroll_staff_id) {
                        vm.payrollStaff = field['text'];
                    }
                });
            },

			getcalculate(){
				const vm = this;
		    	// Creo una fecha
		    	let start_date = new Date(document.getElementById('start_date').value.replaceAll('-', '/'));
		    	let end_date   = new Date(document.getElementById('end_date').value.replaceAll('-', '/'));

		    	let diff = end_date.getTime() - start_date.getTime()
		    	let dias = diff/(1000*60*60*24) + 1
		    	let cont = 0;
		    	// (1000*60*60*24) --> milisegundos -> segundos -> minutos -> horas -> días
		    	// Nuestro método para restar Sábados y Domingos

		    	const sumarLaborables = (f, n) => {
		      		for(var i=0; i<n; i++) {
		        		f.setTime( f.getTime() + (1000*60*60*24) );
		        		if( (f.getDay()==6) || (f.getDay()==0) )  // sábado o domingo
		        		dias--;                                   // hacemos el bucle una unidad mas larga.
		      		}
		    	}

		    	sumarLaborables(start_date, dias);
		    	vm.record.day_permission = dias;
				console.log(dias);
			},
		},

		mounted() {
			const vm = this;
			if(this.requestid){
				this.loadForm(this.requestid);
			}
			else {
	            vm.record.date = moment(String(new Date())).format('YYYY-MM-DD');
	        }

		},
		props: {
			requestid: {
                type: Number
            },
		},
		created() {
			const vm = this;
			vm.getPayrollStaffs();
			vm.getPayrollPermissionPolicies();
		},
	};
</script>
