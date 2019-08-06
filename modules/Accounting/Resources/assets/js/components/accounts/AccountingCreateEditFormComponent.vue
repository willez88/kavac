<template>

	<form class='form-horizontal' v-on:submit.prevent="sendData">
		<div class='card-body'>
			<div class='row'>
				<div class='col-md-6'>
					<div class='form-group'>
						<label class='control-label'>Cuenta pariente</label>
						<select2 :options="accRecords" v-model="record_select"></select2>
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
										v-model="record.group">
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
										v-model="record.subgroup">
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
										v-model="record.item">
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
										v-model="record.generic">
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
										v-model="record.specific">
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
										v-model="record.subspecific">
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
								v-model="record.denomination">
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
										 v-model="record.active">
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
				accRecords:[],
				record_select:'',
				record:{
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

			EventBus.$on('load:data-account-form',(data)=>{
				if (data == null) {
					this.reset(false);
				}
				else{
					var dt = data.code.split('.');
					this.record={
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
				}

				$("input[name=active]").bootstrapSwitch("state", this.record.active);
				this.operation = 'update';
			});
		},
		mounted(){
			this.switchHandler('active');
			this.reset();
		},
		methods:{

			/**
			* Limpia los valores de las variables del formulario
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			reset:function(resetRecords = true){
				if (resetRecords) {
					this.accRecords = [];
				}

				this.record={
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
				if (this.record.group.length < 1 ||this.record.subgroup.length < 1 ||
					this.record.item.length < 1 || this.record.generic.length < 1 ||
					this.record.specific.length < 1 || this.record.subspecific.length < 1) {

					/** Cargo el error para ser mostrado*/
					this.errors = [];
					EventBus.$emit('show:errors', ['Los campos del código de la cuenta son obligatorios']);
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
				var dt = this.record;

				/** Se formatean los ultimos tres campos del codigo de ser necesario */
				this.record.generic = (dt.generic.length < 2) ? '0'+dt.generic : dt.generic ;
				this.record.specific = (dt.specific.length < 2) ? '0'+dt.specific : dt.specific ;
				this.record.subspecific = (dt.subspecific.length < 2) ? '0'+dt.subspecific : dt.subspecific ;

				var url = '/accounting/accounts/';
				this.record.active = $('#active').prop('checked');
				if (this.operation == 'create') {
					axios.post(url, this.record).then(response=>{

						/** Se emite un evento para actualizar el listado de cuentas en el select */
						this.accRecords = [];
						this.accRecords = response.data.records;

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
					axios.put(url+this.record.id, this.record).then(response=>{

						/** Se emite un evento para actualizar el listado de cuentas en el select */
						this.accRecords = [];
						this.accRecords = response.data.records;

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

				this.reset();
			},
		},
		watch:{
			/**
			* Obtiene el código disponible para la subcuenta y carga la información en el formulario
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			record_select:function(res) {
				if (res != '') {
					axios.get('/accounting/get-children-account/' + res).then(response => {
							var account = response.data.account;
							/** Selecciona en pantalla la nueva cuentas */
							this.record = {
								group:account.group,
								subgroup:account.subgroup,
								item:account.item,
								generic:account.generic,
								specific:account.specific,
								subspecific:account.subspecific,
								denomination:account.denomination,
								active:account.active
							};
							$("input[name=active]").bootstrapSwitch("state", this.record.active);
					});
				}
			},
			records:function(res){
				this.accRecords = res;
			}
		}

	};
</script>