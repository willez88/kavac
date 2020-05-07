<template>
	<section>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="code" slot-scope="props" class="text-center">
			<span>
				{{ props.row.code }}
			</span>
		</div>
		<div slot="id" slot-scope="props" class="text-center">
			<div class="d-inline-flex">
				
				<citizenservice-request-info
					:route_list="'requests/vue-info/' + props.row.id">
				</citizenservice-request-info>

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
		<div slot="requested_by" slot-scope="props" class="text-center">
                <span>
                    {{ 
                        props.row.first_name + ' ' + props.row.last_name
                    }}

                </span>
        </div>
	</v-client-table>


	</section>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['requested_by', 'motive_request', 'state', 'date', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'requested_by': 'Solicitado por',
				'motive_request': 'Motivo',
				'state': 'Estado de la Solicitud',
				'date': 'Fecha de la Solicitud',
				'id': 'Acción'
			};
			this.table_options.sortable = ['requested_by', 'motive_request', 'state', 'date'];
			this.table_options.filterable = ['requested_by', 'motive_request', 'state', 'date'];
		},
		mounted () {
			this.initRecords(this.route_list, '');
		},
		methods: {
			/**
			 * Inicializa los datos del formulario
			 *
			 * @author Ing. Yennifer Ramirez <yramirez@cenditel.gob.ve>
			 */
			reset() {
				
			},
		}
	};
</script>