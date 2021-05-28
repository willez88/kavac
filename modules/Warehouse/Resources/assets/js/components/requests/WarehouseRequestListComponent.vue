<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="code" slot-scope="props" class="text-center">
			<span>
				{{ props.row.code }}
			</span>
		</div>
		<div slot="department" slot-scope="props">
			<span>
				{{ (props.row.department)?props.row.department.name:'N/A' }}
			</span>
		</div>
		
		<div slot="id" slot-scope="props" class="text-center">
			<div class="d-inline-flex">
				<warehouse-request-info 
					:route_list = "'warehouse/requests/info/' + props.row.id">
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
				columns: ['code', 'department', 'motive', 'state', 'created_at', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code':       'Código',
				'department': 'Departamento solicitante',
				'motive': 	  'Motivo',
				'state':      'Estado de la solicitud',
				'created_at': 'Fecha de la solicitud',
				'id':         'Acción'
			};
			this.table_options.sortable = ['code', 'department', 'motive', 'state', 'created_at'];
			this.table_options.filterable = ['code', 'department', 'motive', 'state', 'created_at'];
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
