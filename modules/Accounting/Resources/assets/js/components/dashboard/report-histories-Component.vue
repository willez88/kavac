<template>
	<div>
		<h6>Reportes generados</h6>
		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="name" slot-scope="props" class="text-left">
				{{ props.row.name }}
			</div>
			<div slot="created_at" slot-scope="props" class="text-center">
				{{ props.row.created_at }}
			</div>
			
			<div class="interval"></div>

			<div slot="id" slot-scope="props" class="text-center">
				<a class="btn btn-primary btn-xs btn-icon"
					data-toggle="tooltip"
					:href="url+props.row.url"
					title="Generar Reporte" 
					target="_blank">
					<i class="fa fa-print" style="text-align: center;"></i>
				</a>
			</div>
		</v-client-table>
	</div>
</template>

<script>
	export default {
		data(){
			return {
				records: [],
				url:'http://'+window.location.host+'/accounting/report/',
				columns: ['name', 'created_at', 'interval', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'created_at': 'FECHA',
				'interval': 'TIEMPO TRANSCURRIDO',
				'name': 'TIPO DE REPORTE',
				'id': 'ACCIÓN'
			};
			this.table_options.sortable = ['created_at','interval', 'name'];
			this.table_options.filterable = ['created_at','interval', 'name'];
		},
		mounted(){
			this.loadRecords();
		},
		methods:{
			/**
			 * Obtiene los registros de asientos contable
			 * 
			 * @author Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
			 */
			loadRecords(){
				axios.post('/accounting/get_report_histories').then(response=>{
					this.records = response.data.report_histories;
				});
			}
		}
	};
</script>
