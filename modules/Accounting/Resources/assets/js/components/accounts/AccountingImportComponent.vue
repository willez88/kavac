<template>
	<div class="card-body">
		
		<accounting-show-errors :options="errors" />

		<form method="post" enctype="multipart/form-data" @submit.prevent="">
			<label>Cargar Hoja de calculo. Formatos permitidos:<strong>.xls .xlsx .ods</strong></label><br>
			<input type="file" 
					id="file" 
					name="file"
					@change="importCalculo()">
			<br>
		</form>

		<div class="card-body">
			<h6>EJEMPLO: Formato de hoja de cálculo </h6>
			<table cellpadding="1" border="1">
				<thead>
					<tr>
						<td align="center">Código</td>
						<td align="center">Denominación</td>
						<td align="center">Activa</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td align="center">9.9.9.99.99.99</td>
						<td align="center">Nombre de denominación</td>
						<td align="center">SI ó NO</td>
					</tr>
				</tbody>
			</table>
		</div>
		
		<div class="modal-footer">
        	<div class="form-group">
        		<modal-form-buttons :saveRoute="'/accounting/importedAccounts'"></modal-form-buttons>
        	</div>
        </div>

		<div>
			<v-client-table :columns="columns" :data="records" :options="table_options">
				<div slot="status" slot-scope="props" class="text-center">
					<div v-if="props.row.active">
						<span class="badge badge-success"><strong>Activa</strong></span>
					</div>
					<div v-else>
						<span class="badge badge-warning"><strong>Inactiva</strong></span>
					</div>
				</div>
			</v-client-table>
		</div>

	</div>
		
</template>
<script>
	export default{
		data(){
			return {
				records: [],
				columns: ['code', 'denomination', 'status'],
				file:'',
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'CÓDIGO',
				'denomination': 'DENOMINACIÓN',
				'status': 'ESTADO DE LA CUENTA',
			};
			this.table_options.sortable = ['code', 'denomination'];
			this.table_options.filterable = ['code', 'denomination'];

			EventBus.$on('reset:import-form',()=>{
				this.reset();	
			});
		},
		methods:{

			/**
			* Limpia los valores de las variables del formulario
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			reset(){
				document.getElementById("file").value = "";
				this.records = [];
			},

			createRecord(url){
				this.$parent.createRecord(url);
			},

			importCalculo(){

				this.records = [];

				EventBus.$emit('show:errors', []);

				/** Se obtiene y da formato para enviar el archivo a la ruta */
				let vm = this;
				var formData = new FormData();
				var inputFile = document.querySelector('#file');
				formData.append("file", inputFile.files[0]);
				axios.post('/accounting/import', formData, {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}).then(response => {

					if ( ! response.data.result) {
						vm.showMessage(
							'custom', 'Error', 'danger', 'screen-error',
							response.data.message
						);
					}
					else{
						vm.showMessage(
							'custom', 'Éxito', 'success', 'screen-ok', 
							'Cuentas cargadas de manera existosa.'
						);
					}

					if (response.data.errors.length > 0) {
						EventBus.$emit('show:errors', response.data.errors);
					}
					else if (response.data.result && response.data.records) {
						this.records = response.data.records;
						EventBus.$emit('register:imported-accounts', this.records);
					}

				}).catch(error => {
					if (typeof(error.response) !== "undefined") {
						if (error.response.status == 422 || error.response.status == 500) {
							vm.showMessage(
								'custom', 'Error', 'danger', 'screen-error', "El documento debe ser un archivo en formato: .xls .xlsx .ods"
							);
						}
					}
				});
			},
		}

	};
</script>
