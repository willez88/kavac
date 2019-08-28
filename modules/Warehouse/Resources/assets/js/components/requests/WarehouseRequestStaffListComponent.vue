<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="code" slot-scope="props" class="text-center">
			<span>
				{{ props.row.code }}
			</span>
		</div>
		<div slot="payroll_staff" slot-scope="props">
			<span>
				{{ (props.row.payroll_staff)?props.row.payroll_staff.first_name+' '+props.row.payroll_staff.last_name:'N/A' }}
			</span>
		</div>
		
		<div slot="id" slot-scope="props" class="text-center">
			<div class="d-inline-flex">
				<warehouse-request-info 
					:route_list = "'requests/info/' + props.row.id">
				</warehouse-request-info>
				<button @click="editForm(props.row.id)" 
	    				class="btn btn-warning btn-xs btn-icon btn-action" 
	    				title="Modificar registro" data-toggle="tooltip" type="button"
	    				:disabled="props.row.state != 'Pendiente'">
	    			<i class="fa fa-edit"></i>
	    		</button>
	    		<button @click="deleteRecord(props.index, '')" 
						class="btn btn-danger btn-xs btn-icon btn-action" 
						title="Eliminar registro" data-toggle="tooltip" type="button"
						:disabled="props.row.state != 'Pendiente'">
					<i class="fa fa-trash-o"></i>
				</button>
			</div>
		</div>
	</v-client-table>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['code', 'payroll_staff', 'motive', 'state', 'created_at', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'payroll_staff': 'Solicitante',
				'motive': 'Motivo',
				'state': 'Estado de la Solicitud',
				'created_at': 'Fecha de la Solicitud',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'payroll_staff', 'motive', 'state', 'created_at'];
			this.table_options.filterable = ['code', 'payroll_staff', 'motive', 'state', 'created_at'];
		},
		mounted () {
			this.initRecords(this.route_list, '');
		},
		methods: {
			/**
			 * Inicializa los datos del formulario
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				
			},
		}
	};
</script>
