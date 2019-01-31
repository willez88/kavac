<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
			<button @click="showRecord(props.row.id)" v-if="route_show" 
    				class="btn btn-info btn-xs btn-icon btn-round" 
    				title="Ver registro" data-toggle="tooltip" type="button">
    			<i class="fa fa-eye"></i>
    		</button>
			<button @click="editForm(props.row.id)" v-if="!props.row.assigned" 
    				class="btn btn-warning btn-xs btn-icon btn-round" 
    				title="Modificar registro" data-toggle="tooltip" type="button">
    			<i class="fa fa-edit"></i>
    		</button>
    		<button @click="deleteRecord(props.index, '')" 
					class="btn btn-danger btn-xs btn-icon btn-round" 
					title="Eliminar registro" data-toggle="tooltip" 
					type="button">
				<i class="fa fa-trash-o"></i>
			</button>
		</div>
		<div slot="year" slot-scope="props" class="text-center">
			{{ props.row.year }}
		</div>
		<div slot="specific_action" slot-scope="props">
			{{ props.row.specific_action.code }} - {{ props.row.specific_action.name }}
		</div>
		<div slot="assigned" slot-scope="props">
			<span class="text-danger text-bold" v-if="!(props.row.assigned)">NO</span>
			<span class="text-success text-bold" v-else>SI</span>
		</div>
	</v-client-table>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['code', 'year', 'specific_action', 'total_formulated', 'assigned', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'year': 'Año',
				'specific_action': 'Acc. Especifica',
				'total_formulated': 'Total Formulado',
				'assigned': 'Asignado',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'year', 'specific_action'];
			this.table_options.filterable = ['code', 'year', 'specific_action'];
			this.table_options.columnsClasses = {
				'code': 'col-md-2',
				'name': 'col-md-1',
				'specific_action': 'col-md-4',
				'total_formulated': 'col-md-2 text-right',
				'assigned': 'col-md-1 text-center',
				'id': 'col-md-2'
			};
			this.table_options.orderBy = { 'column': 'code'};
		},
		mounted() {
			this.initRecords(this.route_list, '');
			//this.readRecords(this.route_list);
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