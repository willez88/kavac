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
						<label class='control-label'>Cuenta pariente</label>
						<select2 :options="records_select" v-model="record"></select2>
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
										 name="active" 
										 type="checkbox" 
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
			<button class="btn btn-sm btn-default"
					data-toggle="tooltip"
					title="Borrar datos del formulario"
					type="reset">
					<i class="fa fa-eraser"></i>
			</button>
			<button class="btn btn-sm btn-success"
					data-toggle="tooltip"
					title="Guardar registro">
					Guardar
					<i class="fa fa-save"></i>
			</button>
		</div>
	</form>

</template>

<script>
	export default {
		props:['records'],
		data(){
			return{
				errors:[],
				AccOptions:[],
				record:'',
				data_account:{
					id:'',
					group:'',
					subgroup:'',
					item:'',
					generic:'',
					specific:'',
					subspecific:'',
					denomination:'',
					active:false,
				},
				urlPrevious:'http://'+window.location.host+'/accounting/accounts',
				operation:'create', // puede tomar valores ['create' o 'update']
			}
		},
		created(){
			this.records_select = this.records;
			// this.records_select.unshift({id:'', text:'Seleccione...'});

			EventBus.$on('reload:list-accounts',(data)=>{
				this.reset();
				this.records_select = data;
			});

			EventBus.$on('load:data-account-form',(data)=>{

				var dt = data.code.split('.');
				this.data_account={
					id:data.id,
					group:dt[0],
					subgroup:dt[1],
					item:dt[2],
					generic:dt[3],
					specific:dt[4],
					subspecific:dt[5],
					denomination:data.denomination,
					active:data.active,
				};
				this.operation = 'update';
			});
		},
		methods:{

			/**
			* Limpia los valores de las variables del formulario
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			reset:function(){
				this.records_select = [];

				this.data_account={
					id:'',
					group:'',
					subgroup:'',
					item:'',
					generic:'',
					specific:'',
					subspecific:'',
					denomination:'',
					active:false,
				};

				this.operation = 'create';
			},
			/**
			* Valida que los campos del código sean validos 
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			* @return {boolean} retorna falso si algun campo no cumple el formato correspondiente
			*/
			FormatCode:function(){
				if (this.data_account.group.length < 1 ||this.data_account.subgroup.length < 1 ||
					this.data_account.item.length < 1 || this.data_account.generic.length < 1 ||
					this.data_account.specific.length < 1 || this.data_account.subspecific.length < 1) {

					/** Cargo el error para ser mostrado*/
					this.errors = [];
					this.errors.push('Los campos del codigó de la cuenta son obligatorios');
					return false;
				}
				return true;
			},
			/**
			* Envia la información a ser almacenada de la cuenta patrimonial
			* en caso de que se este actualizando la cuenta, se envia la información a la ruta para ser actualizada
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			sendData:function(){
				if (!this.FormatCode()) { return; }
				var dt = this.data_account;

				/** Se formatean los ultimos tres campos del codigo de ser necesario */
				this.data_account.generic = (dt.generic.length < 2) ? '0'+dt.generic : dt.generic ;
				this.data_account.specific = (dt.specific.length < 2) ? '0'+dt.specific : dt.specific ;
				this.data_account.subspecific = (dt.subspecific.length < 2) ? '0'+dt.subspecific : dt.subspecific ;

				var url = '/accounting/accounts/';
				this.data_account.active = $('#active').prop('checked');
				if (this.operation == 'create') {
					axios.post(url, this.data_account).then(response=>{

						/** Se emite un evento para actualizar el listado de cuentas en el select */
						this.records_select = [];
						this.records_select = response.data.records;

						/** Se emite un evento para actualizar el listado de cuentas de la tablas del componente accounting-accounts-list */
						EventBus.$emit('reload:list-accounts',response.data.records);

						const vm = this;
						vm.showMessage('store');
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
					axios.put(url+this.data_account.id, this.data_account).then(response=>{

						/** Se emite un evento para actualizar el listado de cuentas en el select */
						this.records_select = [];
						this.records_select = response.data.records;

						/** Se emite un evento para actualizar el listado de cuentas de la tablas del componente accounting-accounts-list */
						EventBus.$emit('reload:list-accounts',response.data.records);

						const vm = this;
						vm.showMessage('update');
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
			/**
			* Obtiene el código disponible para la subcuenta y carga la información en el formulario
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			record:function(res) {
				if (res != '') {
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
					});
				}
			}
		}

	};
</script>