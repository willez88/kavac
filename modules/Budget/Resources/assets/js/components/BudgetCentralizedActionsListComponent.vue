	<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="id" slot-scope="props" class="text-center">
			<button @click="editForm(props.row.id)"
    				class="btn btn-warning btn-xs btn-icon btn-action"
    				title="Modificar registro" data-toggle="tooltip" type="button">
    			<i class="fa fa-edit"></i>
    		</button>
    		<button @click="deleteRecord(props.index, '')"
					class="btn btn-danger btn-xs btn-icon btn-action"
					title="Eliminar registro" data-toggle="tooltip"
					type="button">
				<i class="fa fa-trash-o"></i>
			</button>
		</div>
		<div slot="active" slot-scope="props" class="text-center">
			<span v-if="props.row.active">SI</span>
			<span v-else>NO</span>
		</div>
	</v-client-table>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['custom_date', 'code', 'name', 'active', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'custom_date': 'Fecha',
				'code': 'Código',
				'name': 'Acción Centralizada',
				'active': 'Activa',
				'id': 'Acción'
			};
			this.table_options.sortable = ['custom_date', 'code', 'name'];
			this.table_options.filterable = ['custom_date', 'code', 'name'];
			this.table_options.columnsClasses = {
				'custom_date': 'col-md-2',
				'code': 'col-md-2',
				'name': 'col-md-5',
				'active': 'col-md-1',
				'id': 'col-md-2'
			};
		},
		mounted() {
			this.initRecords(this.route_list, '');
		},
		methods: {
			/**
			 * Inicializa datos del formulario
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {

			},
		}
	};
</script>
