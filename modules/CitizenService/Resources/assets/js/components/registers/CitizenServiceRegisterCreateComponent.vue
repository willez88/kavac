<template>
	<div class="card">
			<div class="card-header">
				<h6 class="card-title">Cronograma de actividades</h6>
				<div class="card-btns">
					<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)"
                       title="Ir atrás" data-toggle="tooltip">
                        <i class="fa fa-reply"></i>
                    </a>
					<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar"
						data-toggle="tooltip">
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
							<label for="date_register">Fecha del registro</label>
        					<input type="text" readonly id="date_register" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique la fecha del registro" v-model="record.date_register">
        				</div>
					</div>

                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="first_name">Nombre del director</label>
        					<input type="text" class="form-control input-sm" data-toggle="tooltip"
								   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ0-9\s]*"
                                   title="Indique el nombre del director" v-model="record.first_name">
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="project_name">Nombre del proyecto</label>
        					<input type="text" id="project_name" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique el nombre del proyecto" v-model="record.project_name">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="activities">Actividades</label>
        					<input type="text" id="activities" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique las actividades" v-model="record.activities">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="start_date">Fecha de inicio</label>
        					<input type="date" id="start_date" class="form-control input-sm no-restrict" data-toggle="tooltip"
                                   title="Indique la fecha de inicio" v-model="record.start_date">
        				</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="end_date">Fecha de culminación</label>
        					<input type="date" id="end_date" class="form-control input-sm no-restrict" data-toggle="tooltip"
                                   title="Indique la fecha de culminación" v-model="record.end_date">
        				</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="email">Correo electrónico</label>
        					<input type="email" id="email" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique el correo electrónico del responsable" v-model="record.email">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="percent">Porcentaje de cumplimiento</label>
        					<input type="text" min="1" max="100" id="percent" class="form-control input-sm" data-toggle="tooltip"
								   v-input-mask data-inputmask-regex="[0-9]*"
                                   title="Indique el porcentaje de cumplimiento" v-model="record.percent">
						</div>
					</div>
				</div>

            </div>

		<div class="card-footer text-right">
			<div class="row">
				<div class="col-md-3 offset-md-9" id="helpParamButtons">
					<button type="button" @click="reset()" class="btn btn-default btn-icon btn-round"
							data-toggle="tooltip"
		                    title ="Borrar datos del formulario">
							<i class="fa fa-eraser"></i>
					</button>

		        	<button type="button" @click="redirect_back(route_list)"
                        	class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                        	title="Cancelar y regresar">
                    		<i class="fa fa-ban"></i>
            		</button>

		        	<button type="button"  @click="createRecord('citizenservice/registers')"
		        			class="btn btn-success btn-icon btn-round btn-modal-save"
		        			title="Guardar registro">
		        			<i class="fa fa-save"></i>
		            </button>
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
					date_register: '',
					first_name: '',
					project_name: '',
					activities: '',
					start_date: '',
					end_date: '',
					email: '',
					percent: ''
				},

				errors: [],
				records: [],

			}
		},
		methods: {
			loadForm(id){

				const vm = this;

	            axios.get('/citizenservice/registers/vue-info/'+id).then(response => {
	                if(typeof(response.data.record != "undefined")){
						vm.record = response.data.record;

	                }
	            });
			},
			/**
			 * Método que borra todos los datos del formulario
			 *
			 *
			 */
			reset() {
				this.record = {
					id: '',
					date_register: '',
					first_name: '',
					project_name: '',
					activities: '',
					start_date: '',
					end_date: '',
					email: '',
					percent: ''
				};
			},
		},
		mounted() {
			const vm = this;
			if(this.requestid){
				this.loadForm(this.requestid);
			}
			else {
                vm.record.date_register = moment(String(new Date())).format('YYYY-MM-DD');
            }
		},
		props: {
			requestid: {
                type: Number
            },
		},

		created() {

		},
	};
</script>
