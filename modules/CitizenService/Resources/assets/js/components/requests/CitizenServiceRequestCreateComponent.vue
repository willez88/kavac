<template>
	<div class="card">
			<div class="card-header">
				<h6 class="card-title">Datos de la Persona Solicitante</h6>
				<div class="card-btns">
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
							<label for="date">Fecha</label>
        					<input type="date" id="date"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique la fecha de solicitud"
        								   v-model="record.date">
        				</div>
					</div>					   

                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="first_name">Nombres</label>
        					<input type="text"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique los nombres del solicitante"
        								   v-model="record.first_name">
						    
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="last_name">Apellidos</label>
        					<input type="text" id="apellido"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique los apellidos del solicitante"
        								   v-model="record.last_name">
						   
						</div>
					</div>
					 <div class="col-md-4">
						<div class="form-group is-required">
							<label for="id_number">Cédula de Identidad</label>
        					<input type="text"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique la cédula de identidad del solicitante"
        								   v-model="record.id_number">
						    
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="email">Correo Electrónico</label>
        					<input type="text" id="email"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique el correo electrónico del solicitante"
        								   v-model="record.email">
						    
						</div>
					</div>
				</div>
                <h6 class="card-title">
                    Números Telefónicos <i class="fa fa-plus-circle cursor-pointer" @click="addPhone"></i>
                </h6>
                <div class="row" v-for="(phone, index) in record.phones">
                    <div class="col-3">
                        <div class="form-group is-required">
                            <select data-toggle="tooltip" v-model="phone.type"
                                    class="select2"
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
							<select2 :options="countries" @input="getEstates()"
									 v-model="record.country_id"></select2>

							
							
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="estates">Estado</label>
							<select2 :options="estates" @input="getCities()"
									 v-model="record.estate_id"></select2>
							

						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="cities">Ciudad</label>
							<select2 :options="cities" @input="getMunicipalities()"
									 v-model="record.city_id"></select2>

						
							
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="municipalities">Municipio</label>
							<select2 :options="municipalities"
									 v-model="record.municipality_id"></select2>
							
						
							
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="address">Dirección</label>
        					<input type="text" id="address"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique la dirección"
        								   v-model="record.address">

						  
						</div>
					</div>
				
			
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="citizenserviceRequestTypes">Tipo de Solicitud</label>
							<select2 :options="citizen_service_request_types"
									 v-model="record.citizen_service_request_type_id"></select2>

						
							
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="motive_request">Motivo de la solicitud</label>
        					<input type="text" id="motive_request"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique el motivo de la solicitud"
        								   v-model="record.motive_request">

						  
						</div>
					</div>
				
				</div>
			<div v-if="record.citizen_service_request_type_id == '1'">
					
				<div class="col-md-12">
					<b>Datos del equipo</b>
				</div>
				<div class="row">
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="team">Tipo de Equipo</label>
        					<input type="text" id="team"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique el tipo de equipo"
        								   v-model="record.team">
						    
						</div>
					</div>
				
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="brand">Marca</label>
        					<input type="text" id="brand"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique la marca del equipo"
        								   v-model="record.brand">
						    
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="model">Modelo</label>
        					<input type="text" id="model"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique el modelo del equipo"
        								   v-model="record.model">
						   
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="serial">Serial</label>
        					<input type="text" id="serial"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique el serial del equipo"
        								   v-model="record.serial">
						    
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="color">Color</label>
        					<input type="text" id="color"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique el color del equipo"
        								   v-model="record.color">
						    
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="transfer">Motivo de Traslado</label>
        					<input type="text" id="transfer"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique el motivo de traslado"
        								   v-model="record.transfer">
						   
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="code">Código de Inventario</label>
        					<input type="text" id="code"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique el código de inventario"
        								   v-model="record.code">
						    
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group is-required">
							<label for="entryhour">Hora de Entrada</label>
        					<input type="time" id="entryhour"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique la hora de entrada del equipo"
        								   v-model="record.entryhour">
						    
						</div>
					</div>
                    <div class="col-md-4">
						<div class="form-group">
							<label for="exithour">Hora de Salida</label>
        					<input type="time" id="exithour"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique la hora de salida del equipo"
        								   v-model="record.exithour">
						   
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="informationteam">Información Adicional del Equipo</label>
        					<input type="text" id="informationteam"
        								   class="form-control input-sm" data-toggle="tooltip"
        								   title="Indique la información adicional del equipo"
        								   v-model="record.informationteam">
						    
						</div>
					</div>
				</div>
					
			</div>

				<div class="row" v-if="((record.citizen_service_request_type_id == '2')
						|| (record.citizen_service_request_type_id == '3')
						|| (record.citizen_service_request_type_id == '4'))">

					<div class="col-md-4">
						<div class="form-group is-required">
							<label for="direction">Dirección</label>
							<select2 :options="directions"
									 v-model="record.direction_id"></select2>
							
						
							
						</div>
					</div>
				</div>

				<div class="col-md-4">
					<div class="form-group">
						<label>Institución</label>
						<div class="col-12">
							<input type="checkbox" name="type_institution" value="institution" id="sel_type_institution" 
								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_institution" 
								   data-on-label="SI" data-off-label="NO">
							<input type="hidden" v-model="record.type_institution">
						</div>
					</div>
				</div>
				
				<div v-show="this.record.type_institution == 'institution'">
					<div class="col-md-12">
						<b>Datos de la institución</b>
					</div>
					<div class="row">
	                    <div class="col-md-4">
							<div class="form-group is-required">
								<label for="institution_name">Nombre de la Institución</label>
	        					<input type="text" id="institution_name"
	        								   class="form-control input-sm" data-toggle="tooltip"
	        								   title="Indique el nombre de la institución"
	        								   v-model="record.institution_name">	
							</div>
						</div>
						<div class="col-md-4">
								<div class="form-group is-required">
									<label for="rif">RIF</label>
		        					<input type="text" id="rif"
		        								   class="form-control input-sm" data-toggle="tooltip"
		        								   title="Indique el rif de la institución"
		        								   v-model="record.rif">	  
								</div>
						</div>
					
						<div class="col-md-4">
							<div class="form-group is-required">
								<label for="institution_address">Dirección de la Institución</label>
	        					<input type="text" id="institution_address"
	        								   class="form-control input-sm" data-toggle="tooltip"
	        								   title="Indique la dirección de la institución"
	        								   v-model="record.institution_address">	  
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="web">Dirección Web</label>
	        					<input type="text" id="web"
	        								   class="form-control input-sm" data-toggle="tooltip"
	        								   title="Indique la dirección web"
	        								   v-model="record.web">
							</div>
						</div>

					</div>
				</div>
				
				
			</div>

					



			<div class="card-footer text-right">
	        	<button type="button" @click="reset()"
						class="btn btn-default btn-icon btn-round"
						title ="Borrar datos del formulario">
						<i class="fa fa-eraser"></i>
				</button>
			
		

	        	<button type="button"
	        			class="btn btn-warning btn-icon btn-round btn-modal-close"
	        			data-dismiss="modal"
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

					
					institution_name: '',
					rif: '',
        			institution_address: '',
        			web: '',
        			type_institution: '',
  			
        			
        // Datos del equipo
        			team: '',
        			brand: '',
        			model: '',
        			serial: '',
        			color: '',
        			transfer: '',
        			code: '',
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
				citizen_service_request_types: [],
				directions: [
					{
						id: '',
						text: 'Seleccione..'
					},
					{
						id: 1,
						text: 'Desarrollo'
					},
					{
						id: 2,
						text: 'Apropiación'
					},
					{
						id: 3,
						text: 'Reflexión'
					},
					{
						id: 4,
						text: 'Investigación'
					},
					{
						id: 5,
						text: 'Presidencia'
					},
					{
						id: 6,
						text: 'Gestión Interna'
					},
					{
						id: 7,
						text: 'Dirección Ejecutiva'
					},
				]
			}
		},
		methods: {
			loadForm(id){
				const vm = this;
	            
	            axios.get('/citizenservice/requests/vue-info/'+id).then(response => {
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

					institution_name: '',
        			rif: '',
        			institution_address: '',
        			web: '',
        			
        			
        			team: '',
        			brand: '',
        			model: '',
        			serial: '',
        			color: '',
        			transfer: '',
        			code: '',
        			entryhour: '',
        			exithour: '',
        			informationteam: ''
				};
			},
		},
		mounted() {
			this.switchHandler('type_institution');
			if(this.requestid){
				this.loadForm(this.requestid);
			}
		},
		props: {
			requestid: Number, 
		},
		created() {
			const vm = this;
			vm.getCountries();
			vm.getCitizenServiceRequestTypes();
            vm.record.phones = [];
		},
	};
</script>
