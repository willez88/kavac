<template>
	<div class="card">
        <div class="card-header">
            <h6 class="card-title">Datos de la Persona Solicitante</h6>
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
                        <label for="date">Fecha</label>
                        <input type="text" readonly id="date" class="form-control input-sm" data-toggle="tooltip"
                               title="Indique la fecha de solicitud" v-model="record.date">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group is-required">
                        <label for="first_name">Nombres</label>
                        <input type="text" class="form-control input-sm" data-toggle="tooltip"
							   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ\s]*"
                               title="Indique los nombres del solicitante" v-model="record.first_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group is-required">
                        <label for="last_name">Apellidos</label>
                        <input type="text" id="apellido" class="form-control input-sm" data-toggle="tooltip"
							   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ\s]*"
                               title="Indique los apellidos del solicitante" v-model="record.last_name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group is-required">
                        <label for="id_number">Cédula de identidad</label>
                        <input type="text" class="form-control input-sm" data-toggle="tooltip"
                               title="Indique la cédula de identidad del solicitante" v-model="record.id_number">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group is-required">
                        <label for="email">Correo electrónico</label>
                        <input type="email" id="email" class="form-control input-sm" data-toggle="tooltip"
                               title="Indique el correo electrónico del solicitante" v-model="record.email">
                    </div>
                </div>
            </div>
            <h6 class="card-title">
                Números Telefónicos <i class="fa fa-plus-circle cursor-pointer" @click="addPhone"></i>
            </h6>
            <div class="row" v-for="(phone, index) in record.phones">
                <div class="col-3">
                    <div class="form-group is-required">
                        <select data-toggle="tooltip" v-model="phone.type" class="select2"
                                title="Seleccione el tipo de número telefónico">
                            <option value="">Seleccione...</option>
                            <option value="M">Móvil</option>
                            <option value="T">Teléfono</option>
                            <option value="F">Fax</option>
                        </select>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group is-required">
                        <input type="text" placeholder="Cod. Area" data-toggle="tooltip"
                               title="Indique el código de área" v-model="phone.area_code"
                               class="form-control input-sm">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group is-required">
                        <input type="text" placeholder="Número" data-toggle="tooltip"
                               title="Indique el número telefónico"
                               v-model="phone.number" class="form-control input-sm">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group is-required">
                        <input type="text" placeholder="Extensión" data-toggle="tooltip"
                               title="Indique la extención telefónica (opcional)"
                               v-model="phone.extension" class="form-control input-sm">
                    </div>
                </div>
                <div class="col-1">
                    <div class="form-group">
                        <button class="btn btn-sm btn-danger btn-action" type="button"
                                @click="removeRow(index, record.phones)"
                                title="Eliminar este dato" data-toggle="tooltip">
                            <i class="fa fa-minus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
            <hr>
		    <div class="row">
		    	<div class="col-md-4">
					<div class="form-group is-required">
						<label for="countries">País</label>
						<select2 :options="countries" @input="getEstates()" v-model="record.country_id"></select2>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="estates">Estado</label>
						<select2 :options="estates" @input="getCities()" v-model="record.estate_id"></select2>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="cities">Ciudad</label>
						<select2 :options="cities" @input="getMunicipalities()" v-model="record.city_id"></select2>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="municipalities">Municipio</label>
						<select2 :options="municipalities" v-model="record.municipality_id"></select2>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="address">Dirección</label>
    					<input type="text" id="address" class="form-control input-sm" data-toggle="tooltip"
                               title="Indique la dirección" v-model="record.address">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="motive_request">Motivo de la solicitud</label>
    					<input type="text" id="motive_request" class="form-control input-sm" data-toggle="tooltip"
                               title="Indique el motivo de la solicitud" v-model="record.motive_request">
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="citizenserviceRequestTypes">Tipo de solicitud</label>
						<select2 :options="citizen_service_request_types"
								  @input="getCitizenServiceRequestType()"
								  v-model="record.citizen_service_request_type_id"></select2>
                    </div>
				</div>
			</div>
			<div v-if="citizenServiceRequestType == 'Soporte técnico'">
				<div class="col-md-12">
					<b>Datos del equipo</b>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="type_team">Tipo de equipo</label>
        					<input type="text" id="type_team" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique el tipo de equipo" v-model="record.type_team"/>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="brand">Marca</label>
        					<input type="text" id="brand" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique la marca del equipo" v-model="record.brand"/>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="model">Modelo</label>
        					<input type="text" id="model" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique el modelo del equipo" v-model="record.model"/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="serial">Serial</label>
        					<input type="text" id="serial" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique el serial del equipo" v-model="record.serial"/>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="color">Color</label>
        					<input type="text" id="color" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique el color del equipo" v-model="record.color"/>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="transfer">Motivo de traslado</label>
        					<input type="text" id="transfer" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique el motivo de traslado" v-model="record.transfer"/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="inventory_code">Código de inventario</label>
        					<input type="text" id="inventory_code" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique el código de inventario" v-model="record.inventory_code"/>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="entryhour">Hora de entrada</label>
        					<input type="time" id="entryhour" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique la hora de entrada del equipo" v-model="record.entryhour"/>
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group">
							<label for="exithour">Hora de salida</label>
        					<input type="time" id="exithour" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique la hora de salida del equipo" v-model="record.exithour"/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="informationteam">Información adicional del equipo</label>
        					<input type="text" id="informationteam" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique la información adicional del equipo" v-model="record.informationteam"/>
						</div>
					</div>
				</div>
			</div>

			<div class="row" v-if="((citizenServiceRequestType == 'Migración a software libre')
					|| (citizenServiceRequestType == 'Talleres de formación - asesorias')
					|| (citizenServiceRequestType == 'Desarrollo de software libre'))">
				<div class="col-md-4">
					<div class="form-group is-required">
						<label for="citizenserviceDepartment">Dirección de departamento</label>
						<select2 :options="citizen_service_departments" v-model="record.citizen_service_department_id"></select2>
					</div>
				</div>
			</div>
    			<div class="col-md-4">
    				<div class="form-group">
    					<label>Institución</label>
    					<div class="col-12">
                            <div class="col-12 bootstrap-switch-mini">
        						<input type="checkbox" name="type_institution"
        							   id="type_institution"
        							   class="form-control bootstrap-switch"
        							   data-toggle="tooltip"
        							   data-on-label="SI" data-off-label="NO"
        							   v-model="record.type_institution"
        							   value="true"/>
                            </div>
    					</div>
    				</div>
    			</div>

			<div v-show="this.record.type_institution">
				<div class="col-md-12">
					<b>Datos de la institución</b>
				</div>
				<div class="row">
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="institution_name">Nombre de la institución</label>
        					<input type="text" id="institution_name" class="form-control input-sm" data-toggle="tooltip"
        					 	   v-input-mask data-inputmask-regex="[a-zA-ZÁ-ÿ\s]*"
                                   title="Indique el nombre de la institución" v-model="record.institution_name">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="rif">RIF</label>
        					<input type="text" id="rif" class="form-control input-sm" data-toggle="tooltip"
								   placeholder="J000000000"
                                   title="Indique el rif de la institución" v-model="record.rif">
                        </div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="institution_address">Dirección de la institución</label>
        					<input type="text" id="institution_address" class="form-control input-sm"
                                   data-toggle="tooltip" title="Indique la dirección de la institución"
                                   v-model="record.institution_address">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="web">Dirección web</label>
        					<input type="url" id="web" class="form-control input-sm" data-toggle="tooltip"
                                   title="Indique la dirección web" v-model="record.web">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
        	<button type="button" @click="reset()" class="btn btn-default btn-icon btn-round"
					data-toggle="tooltip" v-has-tooltip
                    title ="Borrar datos del formulario">
					<i class="fa fa-eraser"></i>
			</button>
        	<button type="button" @click="redirect_back(route_list)"
                        class="btn btn-warning btn-icon btn-round" data-toggle="tooltip"
                        title="Cancelar y regresar">
                    <i class="fa fa-ban"></i>
            </button>
			<button type="button"  @click="createRecord('citizenservice/requests')"
					class="btn btn-success btn-icon btn-round btn-modal-save"
					title="Guardar registro">
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
					first_name: '',
					last_name: '',
					id_number: '',
					email: '',
					phones: [],
					city_id: '',
        			municipality_id: '',
        			address: '',
        			motive_request: '',
        			citizen_service_request_type_id: '',
        			citizen_service_department_id: '',

        			type_institution: '',
					institution_name: '',
					rif: '',
        			institution_address: '',
        			web: '',

                    // Datos del equipo
        			type_team: '',
        			brand: '',
        			model: '',
        			serial: '',
        			color: '',
        			transfer: '',
        			inventory_code: '',
        			entryhour: '',
        			exithour: '',
        			informationteam: ''
				},
				errors: [],
				records: [],
				countries: [],
				estates: [],
				cities: [],
				municipalities: [],
				citizenServiceRequestType: '',
				citizen_service_request_types: [],
				citizen_service_departments: [],
				citizen_service_documents: []
			}
		},
		methods: {
			async loadForm(id){
				const vm = this;

	            await axios.get('/citizenservice/requests/vue-info/'+id).then(response => {
	                if(typeof(response.data.record != "undefined")){
						vm.record = response.data.record;
						vm.record.country_id = vm.record.municipality.estate.country_id;
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
					date: '',
					first_name: '',
					last_name: '',
					id_number: '',
					email: '',
					phones: [],
					city_id: '',
        			municipality_id: '',
        			address: '',
        			motive_request: '',
					citizen_service_request_type_id: '',
					citizen_service_department_id: '',

					type_institution: false,
					institution_name: '',
        			rif: '',
        			institution_address: '',
        			web: '',


        			type_team: '',
        			brand: '',
        			model: '',
        			serial: '',
        			color: '',
        			transfer: '',
        			inventory_code: '',
        			entryhour: '',
        			exithour: '',
        			informationteam: ''
				};
				this.citizenServiceRequestType = '';
			},
			getCitizenServiceRequestType() {
                const vm = this;
                $.each(vm.citizen_service_request_types, function(index, field) {
                    if (field['id'] == '') {
                        vm.citizenServiceRequestType = '';
                    } else if (field['id'] == vm.record.citizen_service_request_type_id) {
                        vm.citizenServiceRequestType = field['text'];
                    }
                });
            }
		},
		mounted() {
			const vm = this;
			this.switchHandler('type_institution');
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
			vm.getCountries();
			vm.getCitizenServiceRequestTypes();
			vm.getCitizenServiceDepartments();
            vm.record.phones = [];
            this.record.type_institution = false;
		},
		watch: {
			record: {
				deep: true,
				handler: function() {
					const vm = this;
					if (vm.record.type_institution) {
						$('#type_institution').bootstrapSwitch('state', true, true);
					}
				}
			}
		}
	};
</script>
