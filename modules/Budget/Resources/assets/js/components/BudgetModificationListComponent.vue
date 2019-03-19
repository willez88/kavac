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
				columns: ['code', 'credit_date', 'description', 'document', 'institution', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'credit_date': 'Fecha',
				'code': 'Código',
				'description': 'Descripción',
				'document': 'Documento',
				'institution': 'Institución',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'credit_date', 'description', 'document', 'institution'];
			this.table_options.filterable = ['code', 'credit_date', 'description', 'document', 'institution'];
		},
		mounted() {
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