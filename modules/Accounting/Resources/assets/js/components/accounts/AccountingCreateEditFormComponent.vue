<template>

	<form class='form-horizontal' v-on:submit.prevent="sendData">
		<div class='card-body'>
			<div class="alert alert-danger" role="alert" v-if="errors.length > 0">
				<div class="container">
					<div class="alert-icon">
						<i class="now-ui-icons objects_support-17"></i>
					</div>
					<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
					<ul>
						<li v-for="error in errors">{{ error }}</li>
					</ul>
				</div>
			</div>
			<div class='row'>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label'>Cuenta</label>
						<select2 :options="records" v-model="RecordBase"></select2>
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
										v-model="data_account.group">
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
										v-model="data_account.subgroup">
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
										v-model="data_account.item">
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
										v-model="data_account.generic">
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
										v-model="data_account.specific">
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
										v-model="data_account.subspecific">
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
								v-model="data_account.denomination">
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
	export default {
		props:['records','account'],
		data(){
			return{
				errors:[],
				AccOptions:[],
				RecordBase:'',
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
				urlPrevious:'http://'+window.location.host+'/accounting/accounts',
				showButton:'create', // puede tomar valores ['create' o 'update']
			}
		},
		mounted(){
			if (this.account != null) {
				this.data_account = this.account;
				this.showButton = 'update';
			}
		},
		methods:{
			FormatCode:function(){
				if (this.data_account.group.length < 1 ||this.data_account.subgroup.length < 1 ||
					this.data_account.item.length < 1 || this.data_account.generic.length < 1 ||
					this.data_account.specific.length < 1 || this.data_account.subspecific.length < 1) {
					this.errors = [];
					this.errors.push('Los campos del codigó de la cuenta son obligatorios');
					return false;
				}
				return true;
			},
			sendData:function(){
				if (!this.FormatCode()) { return; }
				var dt = this.data_account;

				// estos ultimos 3(tres) campos del codigó deben tener 2(dos) digitos
				this.data_account.generic = (dt.generic.length < 2) ? '0'+dt.generic : dt.generic ;
				this.data_account.specific = (dt.specific.length < 2) ? '0'+dt.specific : dt.specific ;
				this.data_account.subspecific = (dt.subspecific.length < 2) ? '0'+dt.subspecific : dt.subspecific ;

				var url = '/accounting/accounts/';
				this.data_account.active = $('#active').prop('checked');
				if (this.showButton == 'create') {
					axios.post(url, this.data_account).then(response=>{
						window.location.href = this.urlPrevious;
					}).catch(error=>{
						this.errors = [];
						if (typeof(error.response) !="undefined") {
							for (var index in error.response.data.errors) {
								if (error.response.data.errors[index]) {
									this.errors.push(error.response.data.errors[index][0]);
								}
							}
						}
					});
				} else {
					axios.put(url+this.account.id, this.data_account).then(response=>{
						window.location.href = this.urlPrevious;
					}).catch(error=>{
						this.errors = [];
						if (typeof(error.response) != "undefined") {
							for (var index in error.response.data.errors) {
								if (error.response.data.errors[index]) {
									this.errors.push(error.response.data.errors[index][0]);
								}
							}
						}
					});
				}
			},
		},
		watch:{
			RecordBase:function(res) {
				axios.get('/accounting/get-children-account/' + res).then(response => {
						var account = response.data.account;
						/** Selecciona en pantalla la nueva cuentas */
						this.data_account = {
							group:account.group,
							subgroup:account.subgroup,
							item:account.item,
							generic:account.generic,
							specific:account.specific,
							subspecific:account.subspecific,
							denomination:account.denomination,
							active:account.active
						};
						$("input[name=active]").bootstrapSwitch("state", this.data_account.active);
				}).catch(error => {
					console.log(error);
				});
			}
		}

	}
</script>