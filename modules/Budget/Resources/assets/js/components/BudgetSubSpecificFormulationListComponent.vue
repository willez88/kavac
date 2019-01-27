<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
			<button @click="showRecord(props.row.id)" v-if="route_show" 
    				class="btn btn-info btn-xs btn-icon btn-round" 
    				title="Ver registro" data-toggle="tooltip" type="button">
    			<i class="fa fa-eye"></i>
    		</button>
			<button @click="editForm(props.row.id)" 
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
			{{ (props.row.assigned)?'SI':'NO' }}
		</div>
	</v-client-table>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['code', 'year', 'specific_action', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'year': 'Año',
				'specific_action': 'Acc. Especifica',
				'assigned': 'Asignado',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'year', 'specific_action'];
			this.table_options.filterable = ['code', 'year', 'specific_action'];
			this.table_options.columnsClasses = {
				'code': 'col-md-2',
				'name': 'col-md-1',
				'specific_action': 'col-md-7',
				'id': 'col-md-2'
			};
		},
		mounted() {
			this.initRecords(this.route_list, '');
			//this.readRecords(this.route_list);
		},
		methods: {
			reset() {
				
			},
			editForm(id) {
				if (this.route_edit.indexOf("{id}") >= 0) {
					location.href = this.route_edit.replace("{id}", id);
				}
				else {
					location.href = this.route_edit + '/' + id;
				}
			}
		}
	};
</script>