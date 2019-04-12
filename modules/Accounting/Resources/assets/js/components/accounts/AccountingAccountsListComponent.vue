<template>
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

			<button @click="changeView(props.row.id, 'edit')"
					class="btn btn-warning btn-xs btn-icon btn-action btn-round" 
					title="Modificar registro" data-toggle="tooltip">
				<i class="fa fa-edit"></i>
			</button>
			<button @click="deleteAccount(props.index,props.row.id)" 
					class="btn btn-danger btn-xs btn-icon btn-action btn-round" 
					title="Eliminar registro" data-toggle="tooltip">
				<i class="fa fa-trash-o"></i>
			</button>
		</div>
	</v-client-table>
</template>

<script>
	export default {
		props:['accountslist'],
		data(){
			return {
				records: [],
				columns: ['code', 'denomination', 'status', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'CÓDIGO',
				'denomination': 'DENOMINACIÓN',
				'status': 'ESTADO DE LA CUENTA',
				'id': 'ACCIÓN'
			};
			this.table_options.sortable = ['code', 'denomination', 'status'];
			this.table_options.filterable = ['code', 'denomination', 'status'];
		},
		mounted(){
			this.records = this.accountslist;
		},
		methods:{
			changeView:function(idAccount, status) {
				window.location.href = 'http://'+window.location.host+'/accounting/accounts/'+idAccount+'/edit';
			},
			deleteAccount(index, id) {
    		var records = this.records;
    		var confirmated = false;
    		var index = index - 1;
    		const vm = this;

    		bootbox.confirm({
    			title: "Eliminar registro?",
    			message: "Esta seguro de eliminar este registro?",
    			buttons: {
    				cancel: {
    					label: '<i class="fa fa-times"></i> Cancelar'
    				},
    				confirm: {
    					label: '<i class="fa fa-check"></i> Confirmar'
    				}
    			},
    			callback: function (result) {
					if (result) {
    					confirmated = true;
						axios.delete('/accounting/accounts/' + id).then(response => {
							if (typeof(response.data.error) !== "undefined") {
								/** Muestra un mensaje de error si sucede algún evento en la eliminación */
    							vm.showMessage('custom', 'Alerta!', 'warning', 'screen-error', response.data.message);
    							return false;
							}
							vm.showMessage('destroy');
						}).catch(error => {});
    				}
    			}
    		});

    		if (confirmated) {
    			this.records = records;
    			this.showMessage('destroy');
    		}
		},
		}
	}
</script>
