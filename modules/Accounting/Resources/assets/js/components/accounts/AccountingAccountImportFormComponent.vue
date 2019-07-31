<template>
	<div class="card-body">
		<form method="post" enctype="multipart/form-data" @submit.prevent="">
			<label>Cargar Hoja de calculo</label><br>
			<input type="file" 
					id="excel_file" 
					name="file"
					@change="importCalculo()">
			<br>
		</form>

		<div class="card-body">
			<h6>EJEMPLO: Formato de hoja de cálculo</h6>
			<table cellpadding="1" border="1">
				<thead>
					<tr>
						<td align="center">grupo</td>
						<td align="center">subgrupo</td>
						<td align="center">rubro</td>
						<td align="center">n cuenta orden</td>
						<td align="center">n subcuenta primer orden</td>
						<td align="center">n subcuenta segundo orden</td>
						<td align="center">denominacion</td>
						<td align="center">estatus</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td align="center">9</td>
						<td align="center">9</td>
						<td align="center">9</td>
						<td align="center">99</td>
						<td align="center">99</td>
						<td align="center">99</td>
						<td align="center">Nombre de denominación</td>
						<td align="center">activo ó inactivo</td>
					</tr>
				</tbody>
			</table>
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
				<div slot="id" slot-scope="props" class="text-center">

					<button @click="loadData(props.row)"
							class="btn btn-warning btn-xs btn-icon btn-action" 
							title="Modificar registro" data-toggle="tooltip">
						<i class="fa fa-edit"></i>
					</button>
					<button @click="deleteRecord(props.index,'/accounting/accounts')" 
							class="btn btn-danger btn-xs btn-icon btn-action" 
							title="Eliminar registro" data-toggle="tooltip">
						<i class="fa fa-trash-o"></i>
					</button>
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
				columns: ['code', 'denomination', 'status']
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

		},
		methods:{
			importCalculo(){
				let vm = this;
				var formData = new FormData();
				var inputFile = document.querySelector('#excel_file');
				formData.append("file", inputFile.files[0]);
				axios.post('/accounting/import', formData, {
					headers: {
						'Content-Type': 'multipart/form-data'
					}
				}).then(response => {
					if (response.data.result && response.data.records) {
						this.records = response.data.records;
						EventBus.$emit('register:imported-accounts', this.records);
					}
					else {
						vm.showMessage(
							'custom', 'Error!', 'danger', 'screen-error', 
							response.data.message
						);
					}
				}).catch(error => {
					if (typeof(error.response) !== "undefined") {
						if (error.response.status == 422 || error.response.status == 500) {
							vm.showMessage(
								'custom', 'Error', 'danger', 'screen-error', "El documento debe ser un archivo en formato: xls, xlsx, ods, csv."
							);
						}
					}
				});
			},
		}

	};
</script>