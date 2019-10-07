<template>
	<div>
		<h6>Asientos Contables</h6>
		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="from_date" slot-scope="props" class="text-center">
				{{ formatDate(props.row.from_date) }}
			</div>
			<div slot="total" slot-scope="props" class="text-right">
				<strong>Debe: </strong> {{ props.row.currency.symbol }} {{ parseFloat(props.row.tot_debit).toFixed(props.row.currency.decimal_places) }}
				<br>
				<strong>Haber</strong> {{ props.row.currency.symbol }} {{ parseFloat(props.row.tot_assets).toFixed(props.row.currency.decimal_places) }}
			</div>
			<div slot="approved" slot-scope="props" class="text-center">
				<span class="badge badge-success" v-show="props.row.approved"><strong>Aprobado</strong></span>
				<span class="badge badge-danger" v-show="!props.row.approved"><strong>No Aprobado</strong></span>
			</div>
			<div slot="action" slot-scope="props" class="text-center">
				<button @click="approve(props.index)"
						class="btn btn-success btn-xs btn-icon btn-action" 
						title="Aprobar Registro" data-toggle="tooltip"
						v-if="!props.row.approved">
					<i class="fa fa-check"></i>
				</button>
				<button @click="editForm(props.row.id)"
						class="btn btn-warning btn-xs btn-icon btn-action" 
						title="Modificar registro" data-toggle="tooltip"
						v-if="!props.row.approved">
					<i class="fa fa-edit"></i>
				</button>
				<button @click="deleteRecord(props.index,'/accounting/seating')" 
						class="btn btn-danger btn-xs btn-icon btn-action" 
						title="Eliminar Registro" data-toggle="tooltip"
						v-if="!props.row.approved">
					<i class="fa fa-trash-o"></i>
				</button>
				<a class="btn btn-primary btn-xs btn-icon"
						:href="url+'pdf/'+props.row.id"
						title="Imprimir Registro" 
						data-toggle="tooltip"
						target="_blank"
						v-if="props.row.approved">
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
				reload:false,
				records: [],
				url:'/accounting/seating/',
				columns: ['from_date', 'reference', 'concept', 'total', 'approved', 'action']
			}
		},
		created() {
			this.table_options.headings = {
				'from_date': 'FECHA',
				'reference': 'REFERENCIA',
				'concept': 'CONCEPTO',
				'total': 'TOTAL',
				'approved': 'ESTADO DEL ASIENTO',
				'action': 'ACCIÓN'
			};
			this.table_options.sortable = [];
			this.table_options.filterable = [];
		},
		mounted(){
			this.loadRecords();
		},
		methods:{
			/**
			 * Redirecciona al formulario de actualización de datos
			 * 
			 * @author Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
			 * @param  {integer} id Identificador del registro a actualizar
			 */
			editForm(id) {
				location.href = this.url+id+'/edit';
			},

			/**
			 * Obtiene los registros de asientos contable
			 * 
			 * @author Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
			 */
			loadRecords(){
				axios.post('/accounting/lastOperations').then(response=>{
					this.records = response.data.lastRecords;
				});
			}
		},
		watch:{
			reload(res){
				if (res) {
					this.loadRecords();
					this.reload = false;
				}
			}
		}
	};
</script>
