<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="institution" slot-scope="props">
			{{ props.row.institution.acronym }}
		</div>
		<div slot="approved_at" slot-scope="props">
			{{ format_date(props.row.approved_at) }}
		</div>
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
				columns: ['code', 'approved_at', 'description', 'document', 'institution', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'approved_at': 'Fecha',
				'code': 'Código',
				'description': 'Descripción',
				'document': 'Documento',
				'institution': 'Institución',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'approved_at', 'description', 'document', 'institution'];
			this.table_options.filterable = ['code', 'approved_at', 'description', 'document', 'institution'];
			this.table_options.columnsClasses = {
				'approved_at': 'col-md-1',
				'code': 'col-md-1',
				'description': 'col-md-4',
				'document': 'col-md-2',
				'institution': 'col-md-2',
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
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				
			},
		}
	};
</script>