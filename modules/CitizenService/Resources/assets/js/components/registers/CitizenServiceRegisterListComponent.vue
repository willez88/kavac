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
				
				<citizenservice-register-info
					:route_list="'registers/vue-info/' + props.row.id">
				</citizenservice-register-info>

	    		<button @click="editForm(props.row.id)" 
	    				class="btn btn-warning btn-xs btn-icon btn-action" 
	    				title="Modificar registro" data-toggle="tooltip" 
	    				type="button">
	    			<i class="fa fa-edit"></i>
	    		</button>
	    		<button @click="deleteRecord(props.index, '')" 
						class="btn btn-danger btn-xs btn-icon btn-action" 
						title="Eliminar registro" data-toggle="tooltip" 
						type="button">
					<i class="fa fa-trash-o"></i>
				</button>
			</div>
		</div>
		
	</v-client-table>


	</section>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['first_name', 'date_register', 'project_name',
				'activities','email', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'first_name': 'Nombre del director',
				'date_register': 'Fecha del registro',
				'project_name': 'Nombre del proyecto',
				'activities': 'Actividades',
				'email': 'Correo del responsable',
				'id': 'Acción'
			};
			this.table_options.sortable = ['first_name', 'date_register', 'project_name', 'activities', 'email'];
			this.table_options.filterable = ['first_name', 'date_register', 'project_name', 'activities', 'email'];
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