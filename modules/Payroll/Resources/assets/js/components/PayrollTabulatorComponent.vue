<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros Tabuladores de Nómina" data-toggle="tooltip" 
		   @click="addRecord('add_tabulator', 'tabulators', $event)">
			<i class="icofont icofont-table ico-3x"></i>
			<span>Tabuladores de Nónima</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_tabulator">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-table ico-2x"></i> 
							Nuevo Tabulador
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
								<div class=" form-group is-required">
									<label>Tipo de Cargo</label>
									<select2 :options="position_types"
										v-model="record.position_type_id"></select2>
								</div>
							</div>
							<div class="col-md-6">
								<div class=" form-group">
									<label>Visualizar Tabulador</label>
									<div class="col-12">
										<input type="checkbox" class="form-control bootstrap-switch"
											name="view_tabulator" id="sel_view_tabulator" 
											data-on-label="Si" data-off-label="No" value="true"
											v-model="record.view_tabulator">
									</div>
								</div>
							</div>
						</div>

						<div v-show="!this.record.view_tabulator">
							<ul class="nav nav-tabs custom-tabs justify-content-left" role="tablist">
		                        <li class="nav-item">
		                            <a class="nav-link active" data-toggle="tab" href="#horizontal" id="tab_horizontal" role="tab">
		                                Escalafón Horizontal
		                            </a>
		                        </li>
		                        
		                        <li class="nav-item">
		                            <a class="nav-link" data-toggle="tab" href="#vertical" role="tab">
		                                Escalafón Vertical
		                            </a>
		                        </li>
		                    </ul>

		                    <div class="tab-content">
		                    	<div class="tab-pane active" id="horizontal" role="tabpanel">
		                    		<div class="row">
		                    			<div class="col-md-12">
		                    				<strong>Agrupar por</strong>
		                    			</div>
										<div class="col-md-3">
											<div class=" form-group">
												<label>Experiencia Laboral</label>
												<div class="col-12">
													<input type="radio" name="clasification_year" value="experience" id="sel_experience" 
														   class="form-control bootstrap-switch bootstrap-switch-mini sel_exp_antiquity" 
														   data-on-label="SI" data-off-label="NO">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class=" form-group">
												<label>Antigüedad</label>
												<div class="col-12">
													<input type="radio" name="clasification_ladder" value="antiquity" id="sel_antiquity" 
														   class="form-control bootstrap-switch bootstrap-switch-mini sel_exp_antiquity" 
														   data-on-label="SI" data-off-label="NO">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class=" form-group">
												<label>Grado de Instrucción</label>
												<div class="col-12">
													<input type="radio" name="clasification_ladder" value="instruction_degree" id="sel_instruction_degree" 
														   class="form-control bootstrap-switch bootstrap-switch-mini sel_exp_degree" 
														   data-on-label="SI" data-off-label="NO">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class=" form-group">
												<label>Cargo</label>
												<div class="col-12">
													<input type="radio" name="clasification_ladder" value="position" id="sel_position" 
														   class="form-control bootstrap-switch bootstrap-switch-mini sel_exp_degree" 
														   data-on-label="SI" data-off-label="NO">
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="form-group is-required">
												<label>Nombre del Escalafón:</label>
												<input type="text" placeholder="Nombre del Escalafón" 
														data-toggle="tooltip" 								   
														class="form-control input-sm"
														v-model="salary_ladder_h.name">
						                    </div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<b>Nueva Escala</b>
										</div>
										<div class="col-md-4">
											<div class="form-group is-required">
												<label>Código:</label>
												<input type="text" placeholder="Código del Escalafón" 
														data-toggle="tooltip" 								   
														class="form-control input-sm"
														id="scale_code">
						                    </div>
										</div>
										<div class="col-md-4">
											<div class="form-group is-required">
												<label>Nombre:</label>
												<input type="text" placeholder="Nombre del Escala" 
														data-toggle="tooltip" 								   
														class="form-control input-sm"
														id="scale_name">
						                    </div>
										</div>
										<div class="col-md-4">
											<div class="form-group is-required">
												<label>Parámetro:</label>
												<select2 :options="parameters" id="ladder_parameter_id"></select2>
												
						                    </div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<button type="button" @click="addScale($event,'horizontal')"class="btn btn-sm btn-primary btn-custom float-right" 
													title="Agregar registro a la lista"
													data-toggle="tooltip">
												<i class="fa fa-plus-circle"></i>
												Agregar
											</button>
										</div>
									</div>
									<hr>
									<div class="row">
										<div v-if="this.salary_ladder_h.name != '' ">
											<hr>
											<table class="table table-hover table-striped table-responsive  table-ladder">
												<thead>
													<tr>
														<th colspan="2"><strong>{{ salary_ladder_h.name }}</strong></th>
													</tr>
												</thead>
												<tbody v-if="this.salary_ladder_h.scales.length > 0">
													<tr class="text-center" v-for="(field, index) in salary_ladder_h.scales">
														<td>
															{{ field.code }}
														</th>
														<td>
															{{ field.name }}
														</td>
														<td class="text-center">
															<div class="d-inline-flex">
																<button @click="editScale(index,'horizontal',$event)"
										                				class="btn btn-warning btn-xs btn-icon btn-action" 
										                				title="Modificar registro" data-toggle="tooltip" type="button">
										                			<i class="fa fa-edit"></i>
										                		</button>
										                		<button @click="removeScale(index,'horizontal',$event)" 
																		class="btn btn-danger btn-xs btn-icon btn-action" 
																		title="Eliminar registro" data-toggle="tooltip" 
																		type="button">
																	<i class="fa fa-trash-o"></i>
																</button>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div v-else>
											<span><b>Table Not Defined</b></span>
										</div>
									</div>
		                    	</div>
		                    	<div class="tab-pane" id="vertical" role="tabpanel">
		                    		<div class="row">
										<div class="col-md-3">
											<div class=" form-group">
												<label>Experiencia Laboral</label>
												<div class="col-12">
													<input type="radio" name="clasification_ladder_v" value="experience" id="sel_experience_v" 
														   class="form-control bootstrap-switch bootstrap-switch-mini sel_exp_degree" 
														   data-on-label="SI" data-off-label="NO">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class=" form-group">
												<label>Antigüedad</label>
												<div class="col-12">
													<input type="radio" name="clasification_ladder_v" value="antiquity" id="sel_antiquity_v" 
														   class="form-control bootstrap-switch bootstrap-switch-mini sel_exp_degree" 
														   data-on-label="SI" data-off-label="NO">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class=" form-group">
												<label>Grado de Instrucción</label>
												<div class="col-12">
													<input type="radio" name="clasification_ladder_v" value="instruction_degree" id="sel_instruction_degree_v" 
														   class="form-control bootstrap-switch bootstrap-switch-mini sel_exp_degree" 
														   data-on-label="SI" data-off-label="NO">
												</div>
											</div>
										</div>

										<div class="col-md-3">
											<div class=" form-group">
												<label>Cargo</label>
												<div class="col-12">
													<input type="radio" name="clasification_ladder_v" value="position" id="sel_position_v" 
														   class="form-control bootstrap-switch bootstrap-switch-mini sel_exp_degree" 
														   data-on-label="SI" data-off-label="NO">
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="form-group is-required">
												<label>Nombre del Escalafón:</label>
												<input type="text" placeholder="Nombre del Escalafón" 
														data-toggle="tooltip" 								   
														class="form-control input-sm"
														v-model="salary_ladder_v.name">
						                    </div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<strong>Nueva Escala</strong>
										</div>
										<div class="col-md-4">
											<div class="form-group is-required">
												<label>Código:</label>
												<input type="text" placeholder="Código de la Escala" 
														data-toggle="tooltip" 								   
														class="form-control input-sm"
														id="scale_code_v">
						                    </div>
										</div>
										<div class="col-md-4">
											<div class="form-group is-required">
												<label>Nombre:</label>
												<input type="text" placeholder="Nombre del Escalafón" 
														data-toggle="tooltip" 								   
														class="form-control input-sm"
														id="scale_name_v">
						                    </div>
										</div>
										<div class="col-md-4">
											<div class="form-group is-required">
												<label>Parámetro:</label>
												<select2 :options="parameters_v" id="ladder_parameter_id_v"></select2>
												
						                    </div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<button type="button" @click="addScale($event,'vertical')"class="btn btn-sm btn-primary btn-custom float-right" 
													title="Agregar registro a la lista"
													data-toggle="tooltip">
												<i class="fa fa-plus-circle"></i>
												Agregar
											</button>
										</div>
									</div>
									<hr>
									<div class="row">
										<div v-if="this.salary_ladder_v.name != ''">
											<hr>
											<table class="table table-hover table-striped table-responsive  table-ladder">
												<thead>
													<tr>
														<th colspan="2"><strong>{{ salary_ladder_v.name }}</strong></th>
													</tr>
												</thead>
												<tbody v-if="this.salary_ladder_v.scales.length > 0">
													<tr class="text-center" v-for="(field, index) in salary_ladder_v.scales">
														<td>
															{{ field.code }}
														</th>
														<td>
															{{ field.name }}
														</td>
														<td class="text-center">
															<div class="d-inline-flex">
																<button @click="editScale(index,'vertical',$event)"
										                				class="btn btn-warning btn-xs btn-icon btn-action" 
										                				title="Modificar registro" data-toggle="tooltip" type="button">
										                			<i class="fa fa-edit"></i>
										                		</button>
										                		<button @click="removeScale(index,'vertical',$event)" 
																		class="btn btn-danger btn-xs btn-icon btn-action" 
																		title="Eliminar registro" data-toggle="tooltip" 
																		type="button">
																	<i class="fa fa-trash-o"></i>
																</button>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
										<div v-else>
											<div class="col-md-12">
												<span><b>Table Not Defined</b></span>
											</div>
										</div>
									</div>
		                    	</div>
		                    </div>
		                </div>
		                <div v-show="this.record.view_tabulator">
							<div class="col-md-12 text-center">
								<span><b>Tabulator Not Defined</b></span>
							</div>
						</div>
	                </div>

	                <div class="modal-footer">

	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close" 
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createTabulator('payroll/tabulators')" 
	                			class="btn btn-primary btn-sm btn-round btn-modal-save">
	                		Guardar
		                </button>

		            </div>
		        </div>
		    </div>
		</div>
	</div>
</template>

<style>
	.table-ladder .form-control {
		border-radius:.25rem !important;
		padding: .375rem .1rem;
	    font-size: .6rem;
	    text-align: center;
	}
	.table-ladder thead tr.selected-row {
		background-color: #d1d1d1;
	}
	.table-ladder tbody tr td.td-with-border {
		border-right: 1px solid #d1d1d1;
		border-left: 1px solid #d1d1d1;
	}
	.modal {
		overflow: auto !important;
	}
</style>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					position_type_id: '',
					clasification_ladder: '',
					clasification_ladder_v: '',

					view_tabulator: false,
				},
				salary_ladder_h: {
					id: '',
					name: '',
					scales: [],
					editIndex: null,
				},

				salary_ladder_v: {
					id: '',
					name: '',
					scales: [],
					editIndex: null,
				},
				
				records: [],
				errors: [],

				parameters: [],
				parameters_v: [],
				position_types: [],
			}
		},
		created() {
		},
		methods: {
			reset() {
				this.errors = [];

				var input_code = document.getElementById('scale_code');
				var input_name = document.getElementById('scale_name');
				if((input_code)&&(input_name)){
					input_code.value = '';
					input_name.value = '';
				}

				var input_code = document.getElementById('scale_code_v');
				var input_name = document.getElementById('scale_name_v');
				if((input_code)&&(input_name)){
					input_code.value = '';
					input_name.value = '';
				}

			},
			resetTabulator() {
				const vm = this;
				vm.record.clasification_ladder = '';
				vm.record.clasification_ladder_v = '';

				$('#sel_experience_v').bootstrapSwitch('disabled',false);
				$('#sel_antiquity_v').bootstrapSwitch('disabled',false);
				$('#sel_instruction_degree_v').bootstrapSwitch('disabled',false);
				$('#sel_position_v').bootstrapSwitch('disabled',false);
				
				$('#sel_experience').bootstrapSwitch('disabled',false);
				$('#sel_antiquity').bootstrapSwitch('disabled',false);
				$('#sel_instruction_degree').bootstrapSwitch('disabled',false);
				$('#sel_position').bootstrapSwitch('disabled',false);

				if($('#sel_experience_v').is(':checked') == true)
					$('#sel_experience_v').bootstrapSwitch('toggleState',false);
				if($('#sel_antiquity_v').is(':checked') == true)
					$('#sel_antiquity_v').bootstrapSwitch('toggleState',false);
				if($('#sel_instruction_degree_v').is(':checked') == true)
					$('#sel_instruction_degree_v').bootstrapSwitch('toggleState',false);
				if($('#sel_position_v').is(':checked') == true)
					$('#sel_position_v').bootstrapSwitch('toggleState',false);

				if($('#sel_experience').is(':checked') == true)
					$('#sel_experience').bootstrapSwitch('toggleState',false);
				if($('#sel_antiquity').is(':checked') == true)
					$('#sel_antiquity').bootstrapSwitch('toggleState',false);
				if($('#sel_instruction_degree').is(':checked') == true)
					$('#sel_instruction_degree').bootstrapSwitch('toggleState',false);
				if($('#sel_position').is(':checked') == true)
					$('#sel_position').bootstrapSwitch('toggleState',false);

			},
			getPositions(clasification_ladder){
				const vm = this;
				axios.get('/payroll/get-positions').then(function (response) {
					(clasification_ladder == 'horizontal')? vm.parameters = response.data:vm.parameters_v = response.data;
				});
			},
			getInstructionDegrees(clasification_ladder){
				const vm = this;
				axios.get('/payroll/get-instruction-degrees').then(function (response) {
					(clasification_ladder == 'horizontal')? vm.parameters = response.data:vm.parameters_v = response.data;
				});
			},
			createTabulator(url){
				const vm = this;
				console.log(url);
				console.log(vm.record);
			},

			getInterval(clasification_ladder){
				const vm = this;
				var degrees = [{"id":"","text":"Seleccione..."}];
				for( var i = 0; i <= 30; i++ ) {
					degrees.push({"id":i,"text":i});
				}
				(clasification_ladder == 'horizontal')? vm.parameters = degrees:vm.parameters_v = degrees;
			},
			addScale(event,type) {
				const vm = this;
				var parameters = [];

				if(type == 'horizontal'){
					var input_code = document.getElementById('scale_code');
					var input_name = document.getElementById('scale_name');
				}
				else{
					var input_code = document.getElementById('scale_code_v');
					var input_name = document.getElementById('scale_name_v');
				}
				if (( input_code ) && ( input_name ))
					var scale = {
						id: '',
						code: input_code.value,
						name: input_name.value
					};

				/*
				 * Validaciones
				 */

				if(vm.record.position_type_id == ''){
                	bootbox.alert("Debe ingresar el tipo de cargo al cual se aplica el tabulador");
					return false;
				};
				if (( type == 'horizontal' ) && ( vm.salary_ladder_h.name == '' )) {
					bootbox.alert("Debe ingresar el nombre del escalafón");
					return false;
				}
				else if (( type == 'vertical' ) && ( vm.salary_ladder_v.name == '' )) {
					bootbox.alert("Debe ingresar el nombre del escalafón");
					return false;
				}
				if((scale.code == '')&&(scale.name == '')){
                	bootbox.alert("Debe ingresar el codigo y nombre de la nueva escala");
					return false;
				};

				/*
					$.each(vm.parameters,function(index,campo){
			            if(campo.id == vm.ladder.parameter_id){
			                var field = { name: campo.text };
							parameters.push(field);
						}
			        });
			    */
			    
			    if ( type == 'horizontal' ) {
			    	if ( vm.salary_ladder_h.editIndex === null )
			    		vm.salary_ladder_h.scales.push(scale);
			    	
			    	else if ( vm.salary_ladder_h.editIndex >= 0 ) {
						vm.salary_ladder_h.scales.splice(vm.salary_ladder_h.editIndex, 1);
				    	vm.salary_ladder_h.scales.push(scale);
				    	vm.salary_ladder_h.editIndex = null;
					}
			    }
			    else if ( type == 'vertical' ) {
			    	if ( vm.salary_ladder_v.editIndex === null )
			    		vm.salary_ladder_v.scales.push(scale);

			    	else if ( vm.salary_ladder_v.editIndex >= 0 ) {
						vm.salary_ladder_v.scales.splice(vm.salary_ladder_v.editIndex, 1);
				    	vm.salary_ladder_v.scales.push(scale);
				    	vm.salary_ladder_v.editIndex = null;
					}
			    }

		        event.preventDefault();
				vm.reset();
			},
			editScale(index, type, event){
				const vm = this;
				var scale = {};

				if(type =='horizontal'){
					vm.salary_ladder_h.editIndex = index;
					scale = vm.salary_ladder_h.scales[index];
					var input_code = document.getElementById('scale_code');
					var input_name = document.getElementById('scale_name');
				}
				else{
					vm.salary_ladder_v.editIndex = index;
					scale = vm.salary_ladder_v.scales[index];
					var input_code = document.getElementById('scale_code_v');
					var input_name = document.getElementById('scale_name_v');
				}

				
				if((input_code)&&(input_name)){
					input_code.value = scale.code;
					input_name.value = scale.name;
				}

				event.preventDefault();
			},
			removeScale(index, type, event){
				const vm = this;
				if(type =='horizontal'){
					vm.salary_ladder_h.scales.splice(index, 1);
					vm.salary_ladder_h.editIndex = null;
				}
				else{
					vm.salary_ladder_v.scales.splice(index, 1);
					vm.salary_ladder_v.editIndex = null;
				}

				event.preventDefault();
			},
			disabledSwitch(element,ladder){
				if(ladder == 'horizontal'){

					$('#sel_experience_v').bootstrapSwitch('disabled',(element == 'sel_experience_v')?true:false);
					$('#sel_antiquity_v').bootstrapSwitch('disabled',(element == 'sel_antiquity_v')?true:false);
					$('#sel_instruction_degree_v').bootstrapSwitch('disabled',(element == 'sel_instruction_degree_v')?true:false);
					$('#sel_position_v').bootstrapSwitch('disabled',(element == 'sel_position_v')?true:false);
				}
				else if(ladder == 'vertical'){

					$('#sel_experience').bootstrapSwitch('disabled',(element == 'sel_experience')?true:false);
					$('#sel_antiquity').bootstrapSwitch('disabled',(element == 'sel_antiquity')?true:false);
					$('#sel_instruction_degree').bootstrapSwitch('disabled',(element == 'sel_instruction_degree')?true:false);
					$('#sel_position').bootstrapSwitch('disabled',(element == 'sel_position')?true:false);	

				}
			},
		},
		mounted() {
			const vm = this;
			$("#add_tabulator").on('show.bs.modal', function() {
				vm.getPositionTypes();
			});
			vm.switchHandler('view_tabulator');
			vm.switchHandler('clasification_ladder');
			vm.switchHandler('clasification_ladder_v');

			$('.sel_exp_degree').on('switchChange.bootstrapSwitch', function(e) {
				
				if(vm.record.clasification_ladder != ''){
					if (e.target.id === "sel_experience"){
						vm.getInterval('horizontal');
						vm.disabledSwitch('sel_experience_v','horizontal');
					}
					else if (e.target.id === "sel_instruction_degree"){
						vm.getInstructionDegrees('horizontal');
						vm.disabledSwitch('sel_instruction_degree_v','horizontal');
					}
					else if (e.target.id === "sel_antiquity"){
						vm.getInterval('horizontal');

						vm.disabledSwitch('sel_antiquity_v','horizontal');
					}
					else if (e.target.id === "sel_position"){
						vm.getPositions('horizontal');
						vm.disabledSwitch('sel_position_v','horizontal');
					}
				}
				if(vm.record.clasification_ladder_v != ''){
					if (e.target.id === "sel_experience_v"){
						vm.getInterval('vertical');

						vm.disabledSwitch('sel_experience','vertical');
					}
					else if (e.target.id === "sel_instruction_degree_v"){
						vm.getInstructionDegrees('vertical');

						vm.disabledSwitch('sel_instruction_degree','vertical');
					}
					else if (e.target.id === "sel_antiquity_v"){
						vm.getInterval('vertical');

						vm.disabledSwitch('sel_antiquity','vertical');
					}
					else if (e.target.id === "sel_position_v"){
						vm.getPositions('vertical');
						vm.disabledSwitch('sel_position','vertical');
					}
				}
			});
		},
	};
</script>
