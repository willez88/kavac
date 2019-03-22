<template>

	<form class='form-horizontal' v-on:submit.prevent="sendData">
		<div class='card-body'>
			<div class='row'>
				<!-- INCLUIR COMPONENTE PARA EL MANEJO DE MENSAJES DE ERROR -->
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label'>Cuenta</label>
						<select class='select2'
								id="account_id"
								name="account_id"
								title = 'Seleccione una cuenta presupuestaria'
								data-toggle='tooltip'>
								<option selected value="">Selecciona una opción</option>
								<option v-for='acc in all_accounts' :value='acc.id'>
									{{acc.group+'.'+
									acc.subgroup+'.'+
									acc.item+'.'+
									acc.generic+'.'+
									acc.specific+'.'+
									acc.subspecific+' - '+
									acc.denomination}}
								</option>
						</select>
					</div>
				</div>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label'>Código</label>
						<div class='row inline-inputs'>
							<div class='col-1'>
								<input type='text'
										id="group"
										name="group" 
										class='form-control'
										data-toggle='tooltip'
										title='Grupo al que pertenece la cuenta'
										maxlength='1'
										v-model="data_account.group"
										required>
							</div>
							<div class='col-1'>.</div>
							<div class='col-1'>
								<input type='text'
										id="subgroup"
										name="subgroup"
										class='form-control'
										data-toggle='tooltip'
										title='Sub-grupo al que pertenece la cuenta'
										maxlength='1'
										v-model="data_account.subgroup"
										required>
							</div>
							<div class='col-1'>.</div>
							<div class='col-1'>
								<input type='text' 
										id="item"
										name="item"
										class='form-control'
										data-toggle='tooltip'
										title='Rubro al que pertenece la cuenta'
										maxlength='1'
										v-model="data_account.item"
										required>
							</div>
							<div class='col-1'>.</div>
							<div class='col-1'>
								<input type='text'
										id="generic"
										name="generic" 
										class='form-control'
										data-toggle='tooltip'
										title='identificador de cuenta a la que pertenece'
										maxlength='2'
										v-model="data_account.generic"
										required>
							</div>
							<div class='col-1'>.</div>
							<div class='col-1'>
								<input type='text'
										id="specific"
										name="specific"
										class='form-control'
										data-toggle='tooltip'
										title='Identificador de cuenta de 1er orden'
										maxlength='2'
										v-model="data_account.specific"
										required>
							</div>
							<div class='col-1'>.</div>
							<div class='col-1'>
								<input type='text'
										id="subspecific"
										name="subspecific"
										class='form-control'
										data-toggle='tooltip'
										title='Identificador de cuenta de 2do orden'
										maxlength='2'
										v-model="data_account.subspecific"
										required>
							</div>
						</div>
					</div>
				</div>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label'>Denominación</label>
						<input type='text' class='form-control'
								id="denomination"
								name="denomination"
								data-toggle='tooltip'
								placeholder='Descripción de la cuenta'
								title='Denominación o concepto de la cuenta'
								v-model="data_account.denomination"
								required>
					</div>
				</div>
				<div class='col-6'>
					<div class='row'>
						<div class='col-3'>
							<div class='form-group'>
								<label class='control-label'>Activa</label>
								<div class='col-12'>
									<input id="active"
										 data-on-label="SI" data-off-label="NO" 
										 checked="checked" 
										 name="active" 
										 type="checkbox" 
										 value="1" 
										 class="form-control bootstrap-switch"
										 v-model="data_account.active">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class='card-footer text-right'>
			<button class="btn btn-default btn-icon btn-round"
					data-toggle="tooltip"
					title="Borrar datos del formulario"
					type="reset">
					<i class="fa fa-eraser"></i>
			</button>

			<a :href="urlPrevious" class="btn btn-warning btn-icon btn-round"
					data-toggle="tooltip"
					title="Cancelar y regresar">
					<i class="fa fa-ban"></i>
			</a>
			<!-- se muestra en caso de crear -->
			<button v-if="showButton == 'create'" class="btn btn-success btn-icon btn-round"
					data-toggle="tooltip"
					title="Guardar registro"
					id="save">
					<i class="fa fa-save"></i>
			</button>
			<!-- se muestra en caso de actualizar -->
			<button v-else class="btn btn-success btn-icon btn-round"
					data-toggle="tooltip"
					title="Actualizar registro"
					id="save">
					<i class="fa fa-save"></i>
			</button>
		</div>
	</form>

</template>

<script>
	$(document).ready(function() {
			/** Genera una nueva cuenta a partir de la cuenta seleccionada */
			$("#account_id").on('change', function() {
				$("input[type=text]").each(function() {
					$(this).val("");
				});
				
				if ($(this).val()) {
						axios.get('/accounting/get-children-account/' + $(this).val()).then(response => {
								let account = response.data.account;
								// configurar funcion para que genere un nuevo codigo de cuenta disponible
								// $("#combo option").each(function(){
								//    alert('opcion '+$(this).text()+' valor '+ $(this).attr('value'))
								// });

								/** Selecciona en pantalla la nueva cuentas */
								$("input[name=group]").val(account.group);
								$("input[name=subgroup]").val(account.subgroup);
								$("input[name=item]").val(account.item);
								$("input[name=generic]").val(account.generic);
								$("input[name=specific]").val(account.specific);
								$("input[name=subspecific]").val(account.subspecific);
								$("input[name=denomination]").val(account.denomination);
								$("input[name=active]").bootstrapSwitch("state", account.active);
						}).catch(error => {
							console.log(error);
						});
					// }
				}
			});
		});
	export default {
		props:['accounts','account'],
		data(){
			return{
				data_account:{
					group:'',
					subgroup:'',
					item:'',
					generic:'',
					specific:'',
					subspecific:'',
					denomination:'',
					active:true,
				},
				all_accounts:null,
				urlPrevious:'http://'+window.location.host+'/accounting/accounts',
				showButton:'create', // puede tomar valores ['create' o 'update']
			}
		},
		mounted(){
			this.all_accounts = this.accounts;
			if (this.account != null) {
				this.data_account = this.account;
				this.showButton = 'update';
			}
		},
		methods:{
			sendData:function(){
				this.data_account = {
					group:$('#group').val(),
					subgroup:$('#subgroup').val(),
					item:$('#item').val(),
					generic:$('#generic').val(),
					specific:$('#specific').val(),
					subspecific:$('#subspecific').val(),
					denomination:$('#denomination').val(),
					active:$('#active').prop('checked'),
				}
				if (this.showButton == 'create') {
					axios.post('/accounting/accounts',this.data_account).then(response=>{
						window.location.href = this.urlPrevious;
					}).catch(error=>{

					});
				} else {
					axios.put('/accounting/accounts/'+this.account.id,this.data_account).then(response=>{
						window.location.href = this.urlPrevious;
					}).catch(error=>{

					});
				}
			},
		},
		watch:{

		}

	}
</script>