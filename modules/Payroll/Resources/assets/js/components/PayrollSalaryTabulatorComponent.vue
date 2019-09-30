<template>
	<div class="col-xs-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary"
		   href="#" title="Registros Tabuladores de Nómina" data-toggle="tooltip"
		   @click="addRecord('add_tabulator', 'salary-tabulators', $event)">
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
						<ul class="nav nav-tabs custom-tabs justify-content-center" role="tablist">
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#define_tabulator_pane" id="definition_tabulator" role="tab">
	                                <i class="ion-compose"></i> Definir Tabulador
	                            </a>
	                        </li>
	                        <li class="nav-item">
	                            <a class="nav-link" data-toggle="tab" href="#viewer_tabulator_pane" id="viewer_tabulator" role="tab">
	                                <i class="ion-eye"></i> Visualizar Tabulador
	                            </a>
	                        </li>
	                    </ul>

	                    <div class="tab-content">
	                    	<div class="tab-pane active" id="define_tabulator_pane" role="tabpanel">
	                    		<div class="alert alert-danger" v-if="errors.length > 0">
									<ul>
										<li v-for="error in errors">{{ error }}</li>
									</ul>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class=" form-group is-required">
													<label>Tipo de Cargo</label>
													<select2 :options="payroll_position_types"
														v-model="record.position_type_id"></select2>
												</div>
											</div>
											<div class="col-md-8">
												<div class=" form-group is-required">
													<label>Nombre</label>
													<input type="text" placeholder="Nombre del tabulador"
															data-toggle="tooltip"
															class="form-control input-sm"
															v-model="record.name">
												</div>
											</div>
											<div class="col-md-4">
												<div class=" form-group">
													<label>¿Activa?</label>
													<div class="col-12">
														<input type="checkbox" class="form-control bootstrap-switch"
														   data-toggle="tooltip" name="active"
														   title="Indique si el tabulador esta activo"
														   data-on-label="SI" data-off-label="NO"
														   v-model="record.active" value="true">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Descripción:</label>
													<textarea  data-toggle="tooltip"
															   title="Indique alguna descripción asociada al tabulador"
															   class="form-control"
															   rows="3"
															   v-model="record.description">
												   </textarea>
							                    </div>
											</div>
										</div>
									</div>
								</div>

								<ul class="nav nav-tabs custom-tabs justify-content-left" role="tablist">
			                        <li class="nav-item">
			                            <a class="nav-link active" data-toggle="tab" href="#horizontal" id="tab_horizontal" role="tab">
			                                Escalafón Horizontal
			                            </a>
			                        </li>

			                        <li class="nav-item">
			                            <a class="nav-link" data-toggle="tab" href="#vertical" id="tab_vertical" role="tab">
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
														<input type="radio" name="clasification_ladder" value="experience" id="sel_experience"
															   class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
															   data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class=" form-group">
													<label>Antigüedad</label>
													<div class="col-12">
														<input type="radio" name="clasification_ladder" value="antiquity" id="sel_antiquity"
															   class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
															   data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class=" form-group">
													<label>Grado de Instrucción</label>
													<div class="col-12">
														<input type="radio" name="clasification_ladder" value="instruction_degree" id="sel_instruction_degree"
															   class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
															   data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class=" form-group">
													<label>Cargo</label>
													<div class="col-12">
														<input type="radio" name="clasification_ladder" value="position" id="sel_position"
															   class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
															   data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class=" form-group is-required">
													<label>Nombre del Escalafón</label>
													<input type="text" placeholder="Nombre del Escalafón"
																	data-toggle="tooltip"
																	class="form-control input-sm"
																	v-model="salary_ladder_h.name">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Descripción:</label>
													<textarea  data-toggle="tooltip"
															   title="Indique alguna descripción asociada al escalafón"
															   class="form-control input-sm"
															   rows="1"
															   v-model="salary_ladder_h.description">
												   </textarea>
							                    </div>
											</div>
										</div>
										<div class="row">
											<div v-if="this.salary_ladder_h.name != '' ">
												<table class="table table-hover table-striped table-responsive  table-ladder">
													<thead>
														<tr class="text-center">
															<th :colspan="1+salary_ladder_h.scales.length">{{ salary_ladder_h.name}}</th>
														</tr>
													</thead>
													<tbody>
														<tr class="selected-row text-center">
															<th>
																<span>Código:</span>
															</th>
															<td v-for="(field,index) in salary_ladder_h.scales">
																{{ field.code}}
															</td>
														</tr>
														<tr class="selected-row text-center">
															<th>
																<span>Nombre:</span>
															</th>
															<td v-for="(field,index) in salary_ladder_h.scales">
																{{ field.name}}
															</td>
														</tr>
														<tr class="config-row text-center">
															<th>Acción:</th>
															<td v-for="(field,index) in salary_ladder_h.scales">
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
										</div>
										<div class="row">
											<div class="col-md-12">
												<strong>Nueva Escala</strong>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group is-required">
															<label>Código:</label>
															<input type="text" placeholder="Código de la Escala"
																	data-toggle="tooltip"
																	class="form-control input-sm"
																	v-model="scale.code">
									                    </div>
													</div>
													<div class="col-md-6">
														<div class=" form-group is-required">
															<label id="parameter_text">Parametros</label>
															<select2 :options="parameters"
																	v-model="scale.value_id"></select2>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class=" form-group is-required">
															<label>Nombre:</label>
															<input type="text" placeholder="Nombre de la Escala"
																	data-toggle="tooltip"
																	class="form-control input-sm"
																	v-model="scale.name">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Descripción:</label>
															<textarea  data-toggle="tooltip"
																	   title="Indique alguna descripción asociada a la escala"
																	   class="form-control input-sm"
																	   rows="1"
																	   v-model="scale.description">
														   </textarea>
									                    </div>
													</div>
													<div class="col-md-12" style="margin-bottom:0px; margin-top: auto;">
														<button type="button" @click="addScale($event, 'horizontal')"class="btn btn-sm btn-primary btn-custom float-right"
																title="Agregar registro a la lista"
																data-toggle="tooltip">
															<i class="fa fa-plus-circle"></i>
															Agregar
														</button>
													</div>
												</div>
											</div>
										</div>
			                    	</div>

			                    	<div class="tab-pane" id="vertical" role="tabpanel">
			                    		<div class="row">
			                    			<div class="col-md-12">
			                    				<strong>Agrupar por</strong>
			                    			</div>
											<div class="col-md-3">
												<div class=" form-group">
													<label>Experiencia Laboral</label>
													<div class="col-12">
														<input type="radio" name="clasification_ladder_v" value="experience" id="sel_experience_v"
															   class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
															   data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class=" form-group">
													<label>Antigüedad</label>
													<div class="col-12">
														<input type="radio" name="clasification_ladder_v" value="antiquity" id="sel_antiquity_v"
															   class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
															   data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class=" form-group">
													<label>Grado de Instrucción</label>
													<div class="col-12">
														<input type="radio" name="clasification_ladder_v" value="instruction_degree" id="sel_instruction_degree_v"
															   class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
															   data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>

											<div class="col-md-3">
												<div class=" form-group">
													<label>Cargo</label>
													<div class="col-12">
														<input type="radio" name="clasification_ladder_v" value="position" id="sel_position_v"
															   class="form-control bootstrap-switch bootstrap-switch-mini sel_clasification"
															   data-on-label="SI" data-off-label="NO">
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-6">
												<div class=" form-group is-required">
													<label>Nombre del Escalafón</label>
													<input type="text" placeholder="Nombre del Escalafón"
																	data-toggle="tooltip"
																	class="form-control input-sm"
																	v-model="salary_ladder_v.name">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Descripción:</label>
													<textarea  data-toggle="tooltip"
															   title="Indique alguna descripción asociada al escalafón"
															   class="form-control input-sm"
															   rows="1"
															   v-model="salary_ladder_v.description">
												   </textarea>
							                    </div>
											</div>
										</div>
										<div class="row">
											<div v-if="this.salary_ladder_v.name != '' ">
												<table class="table table-hover table-striped table-responsive  table-ladder">
													<thead>
														<tr class="text-center">
															<th :colspan="1+salary_ladder_v.scales.length">{{ salary_ladder_v.name}}</th>
														</tr>
													</thead>
													<tbody>
														<tr class="selected-row text-center">
															<th>
																<span>Código:</span>
															</th>
															<td v-for="(field,index) in salary_ladder_v.scales">
																{{ field.code}}
															</td>
														</tr>
														<tr class="selected-row text-center">
															<th>
																<span>Nombre:</span>
															</th>
															<td v-for="(field,index) in salary_ladder_v.scales">
																{{ field.name}}
															</td>
														</tr>
														<tr class="config-row text-center">
															<th>Acción:</th>
															<td v-for="(field,index) in salary_ladder_v.scales">
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
										</div>

										<div class="row">
											<div class="col-md-12">
												<strong>Nueva Escala</strong>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group is-required">
															<label>Código:</label>
															<input type="text" placeholder="Código de la Escala"
																	data-toggle="tooltip"
																	class="form-control input-sm"
																	v-model="scale_v.code">
									                    </div>
													</div>
													<div class="col-md-6">
														<div class=" form-group is-required">
															<label id="parameter_v_text">Parámetros</label>
															<select2 :options="parameters_v"
																	v-model="scale_v.value_id"></select2>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class=" form-group is-required">
															<label>Nombre:</label>
															<input type="text" placeholder="Nombre de la Escala"
																	data-toggle="tooltip"
																	class="form-control input-sm"
																	v-model="scale_v.name">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Descripción:</label>
															<textarea  data-toggle="tooltip"
																	   title="Indique alguna descripción asociada a la escala"
																	   class="form-control input-sm"
																	   rows="1"
																	   v-model="scale_v.description">
														   </textarea>
									                    </div>
													</div>
													<div class="col-md-12" style="margin-bottom:0px; margin-top: auto;">
														<button type="button" @click="addScale($event, 'vertical')"class="btn btn-sm btn-primary btn-custom float-right"
																title="Agregar registro a la lista"
																data-toggle="tooltip">
															<i class="fa fa-plus-circle"></i>
															Agregar
														</button>
													</div>
												</div>
											</div>
										</div>
			                    	</div>
			                    </div>
			                </div>
			                <div class="tab-pane" id="viewer_tabulator_pane" role="tabpanel">
			                	<div v-if="((this.salary_ladder_h.scales.length > 0)||(this.salary_ladder_v.scales.length > 0))">
		                    		<div class="row">
		                    			<div class="col-md-12">
											<button type="button" class="btn btn-sm btn-success btn-custom float-right"
													title="Exportar tabulador en formato xls"
													data-toggle="tooltip">
												<i class="fa fa-file-excel-o"></i>
												Exportar
											</button>
										</div>
		                    		</div>
		                    		<div class="row">

									</div>
								</div>
								<div v-else>
									<div class="alert alert-danger">
										<ul>
											<li>No se a definido ningun tabulador !</li>
										</ul>
									</div>
								</div>
			                </div>
			            </div>
			        </div>

	                <div class="modal-footer">

	                	<button type="button" class="btn btn-default btn-sm btn-round btn-modal-close"
	                			data-dismiss="modal">
	                		Cerrar
	                	</button>
	                	<button type="button" @click="createTabulator('payroll/salary-tabulators')"
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
	.table-ladder thead tr.selected-row {
		background-color: #d1d1d1;
	}
	.table-ladder tbody tr.config-row {
		background-color: #fff;
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
					name: '',
					description: '',
					position_type_id: '',
					active: '',

					clasification_ladder: '',
					clasification_ladder_v: '',

				},
				salary_ladder_h: {
					id: '',
					name: '',
					description: '',
					scales: [],
					editIndex: null,
				},

				salary_ladder_v: {
					id: '',
					name: '',
					description: '',
					scales: [],
					editIndex: null,
				},
				scale: {
					id: '',
					name: '',
					code: '',
					description: '',
					value_id: ''
				},
				scale_v: {
					id: '',
					name: '',
					code: '',
					description: '',
					value_id: ''
				},

				records: [],
				errors: [],

				parameters: [],
				parameters_v: [],
				payroll_position_types: [],
			}
		},
		created() {
		},
		methods: {
			reset() {
				this.errors = [];
				this.resetScale('all');
			},
			resetScale(type) {
				if (type != 'veltical'){
					this.scale = {
						id: '',
						name: '',
						code: '',
						description: '',
						value_id: '',
					};
				}
				if (type != 'horizontal') {
					this.scale_v = {
						id: '',
						name: '',
						code: '',
						description: '',
						value_id: '',
					};
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
			getParamenters(ladder, clasification){
				const vm = this;
				(ladder == 'horizontal')?vm.parameters = []:vm.parameters_v = [];

				if (clasification == 'position') {
					(ladder == 'horizontal')?document.getElementById('parameter_text').innerText = 'Cargos:':document.getElementById('parameter_v_text').innerText = 'Cargos:'
					vm.getPositions(ladder);
				}
				else if (clasification == 'instruction_degree') {
					(ladder == 'horizontal')?document.getElementById('parameter_text').innerText = 'Grados de Instrucción:':document.getElementById('parameter_v_text').innerText = 'Grados de Instrucción:'
					vm.getInstructionDegrees(ladder);
				}
				else if (clasification == 'experience') {
					var years = [{"id":"","text":"Seleccione..."}];
					for( var i = 0; i <= 30; i++ ) {
						years.push({"id":i,"text":i+ ' Años de experiencia'});
					}
					(ladder == 'horizontal')? vm.parameters = years:vm.parameters_v = years;
					(ladder == 'horizontal')?document.getElementById('parameter_text').innerText = 'Años de Experiencia:':document.getElementById('parameter_v_text').innerText = 'Años de Experiencia:'
				}
				else if (clasification == 'antiquity') {
					var years = [{"id":"","text":"Seleccione..."}];
					for( var i = 0; i <= 30; i++ ) {
						years.push({"id":i,"text":i+ ' Años dentro de la institución'});
					}
					(ladder == 'horizontal')? vm.parameters = years:vm.parameters_v = years;
					(ladder == 'horizontal')?document.getElementById('parameter_text').innerText = 'Años de Antiguedad:':document.getElementById('parameter_v_text').innerText = 'Años de Antiguedad:'
				}
			},
			addScale(event,type) {
				const vm = this;
				var parameters = [];
				var scale = {};

				scale = {
					id: (type == 'horizontal')?vm.scale.id:vm.scale_v.id,
					name: (type == 'horizontal')?vm.scale.name:vm.scale_v.name,
					code: (type == 'horizontal')?vm.scale.code:vm.scale_v.code,
					description: (type == 'horizontal')?vm.scale.description:vm.scale_v.description,
					value_id: (type == 'horizontal')?vm.scale.value_id:vm.scale_v.value_id,
				};
				/*
				 * Se validan los campos requeridos
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
				/**
				 * se crea la cadena de texto que contiene el mensaje de error enviado, deacuerdo al tipo de escalafón seleccionado
				 */
				var parameter = (type == 'horizontal')? vm.record.clasification_ladder:vm.record.clasification_ladder_v;
				var parameter_text = '';
					parameter_text = (parameter == 'experience')?'años de experiencia':parameter_text;
					parameter_text = (parameter == 'antiquity')?'años de antiguedad':parameter_text;
					parameter_text = (parameter == 'instruction_degree')?'grado de instrucción':parameter_text;
					parameter_text = (parameter == 'position')?'cargo':parameter_text;

				if(parameter_text == '') {
					bootbox.alert('Debe seleccionar un parametro de agrupación del escalafón');
					return false;
				}
				if((scale.name == '')&&(scale.code == '')&&(scale.value_id == '')) {
					var text = 'Debe ingresar el nombre, codigo y ' + parameter_text + ' de la escala';
					bootbox.alert(text);
					return false;
				}
			    if((scale.name == '')&&(scale.code == '')) {
					bootbox.alert('Debe ingresar el nombre, codigo de la escala');
					return false;
				}
				if((scale.code == '')&&(scale.value_id == '')) {
					var text = 'Debe ingresar el codigo y ' +  parameter_text + ' de la escala';
					bootbox.alert(text);
					return false;
				}
				if((scale.name == '')&&(scale.value_id == '')) {
					var text = 'Debe ingresar el nombre y ' + parameter_text + ' de la escala';
					bootbox.alert(text);
					return false;
				}
				vm.resetScale(type);

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
			},
			editScale(index, type, event){
				const vm = this;
				var scale = {};

				if(type =='horizontal'){
					vm.salary_ladder_h.editIndex = index;
					vm.scale = vm.salary_ladder_h.scales[index];
				}
				else{
					vm.salary_ladder_v.editIndex = index;
					vm.scale_v = vm.salary_ladder_v.scales[index];
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
				vm.getPayrollPositionTypes();
			});
			vm.switchHandler('active');
			vm.switchHandler('clasification_ladder');
			vm.switchHandler('clasification_ladder_v');

			$('.sel_clasification').on('switchChange.bootstrapSwitch', function(e) {

				if(vm.record.clasification_ladder != ''){
					if (e.target.id === "sel_experience"){
						vm.getParamenters('horizontal', 'experience');
						vm.disabledSwitch('sel_experience_v','horizontal');
					}
					else if (e.target.id === "sel_instruction_degree"){
						vm.getParamenters('horizontal', 'instruction_degree');
						vm.disabledSwitch('sel_instruction_degree_v','horizontal');
					}
					else if (e.target.id === "sel_antiquity"){
						vm.getParamenters('horizontal', 'antiquity');
						vm.disabledSwitch('sel_antiquity_v','horizontal');
					}
					else if (e.target.id === "sel_position"){
						vm.getParamenters('horizontal', 'position');
						vm.disabledSwitch('sel_position_v','horizontal');
					}
				}
				if(vm.record.clasification_ladder_v != ''){
					if (e.target.id === "sel_experience_v"){
						vm.getParamenters('vertical', 'experience');
						vm.disabledSwitch('sel_experience','vertical');
					}
					else if (e.target.id === "sel_instruction_degree_v"){
						vm.getParamenters('vertical', 'instruction_degree');
						vm.disabledSwitch('sel_instruction_degree','vertical');
					}
					else if (e.target.id === "sel_antiquity_v"){
						vm.getParamenters('vertical', 'antiquity');
						vm.disabledSwitch('sel_antiquity','vertical');
					}
					else if (e.target.id === "sel_position_v"){
						vm.getParamenters('vertical', 'position');
						vm.disabledSwitch('sel_position','vertical');
					}
				}
			});
		},
	};
</script>
