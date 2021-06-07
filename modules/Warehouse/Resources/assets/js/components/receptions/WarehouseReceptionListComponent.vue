<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="code" slot-scope="props" class="text-center">
            <span>
                {{ props.row.code }}
            </span>
        </div>
		<div slot="warehouse" slot-scope="props">
			<span>
				{{ (props.row.warehouse_institution_warehouse_end)?props.row.warehouse_institution_warehouse_end.warehouse.name:'N/A' }}
			</span>
		</div>
		<div slot="state" slot-scope="props">
			<span>
				{{ (props.row.state)?props.row.state:'N/A' }}
			</span>
		</div>
		<div slot="id" slot-scope="props" class="text-center">
			<div class="d-inline-flex">
				<warehouse-reception-info 
					:route_list="'/warehouse/receptions/info/'+ props.row.id">
				</warehouse-reception-info>

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
				columns: ['code', 'description', 'warehouse', 'created_at', 'state', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'description': 'Descripción',
				'warehouse': 'Almacén',
				'created_at': 'Fecha de ingreso',
				'state': 'Estado de la solicitud',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'description', 'warehouse', 'created_at', 'state'];
			this.table_options.filterable = ['code', 'description', 'warehouse', 'created_at', 'state'];
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
