<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
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
	</v-client-table>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['code', 'name', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'name': 'Acción Específica',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'name'];
			this.table_options.filterable = ['code', 'name'];
			this.table_options.columnsClasses = {
				'code': 'col-md-2',
				'name': 'col-md-8',
				'id': 'col-md-2'
			};
		},
		mounted() {
			this.initRecords(this.route_list, '');
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