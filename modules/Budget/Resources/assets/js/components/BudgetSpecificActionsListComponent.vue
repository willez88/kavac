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
		<div slot="specificable_type" slot-scope="props">
			<span v-if="props.row.specificable_type=='Modules\\Budget\\Models\\BudgetProject'">Proyecto</span>
			<span v-else>Acción Centralizada</span>
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
				columns: ['code', 'name', 'specificable_type', 'active', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'name': 'Acción Específica',
				'specificable_type': 'Proyecto / Acc. Centralizada',
				'active': 'Activa',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'name', 'specificable_type'];
			this.table_options.filterable = ['code', 'name', 'specificable_type'];
			this.table_options.columnsClasses = {
				'code': 'col-md-2',
				'name': 'col-md-4',
				'specificable_type': 'col-md-3',
				'active': 'col-md-1',
				'id': 'col-md-2'
			};
		},
		mounted() {
			this.initRecords(this.route_list, '');
		},
		methods: {
			/**
			 * Inicializa los datos del formulario
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
			 */
			reset() {

			},
		}
	};
</script>
