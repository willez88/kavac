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
		<div slot="payroll_staff.first_name" slot-scope="props">
			{{ props.row.payroll_staff.first_name }} {{ props.row.payroll_staff.last_name }}
		</div>
	</v-client-table>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['custom_date', 'code', 'name', 'payroll_staff.first_name', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'custom_date': 'Fecha',
				'code': 'Código',
				'name': 'Acción Centralizada',
				'payroll_staff.first_name': 'Responsable',
				'id': 'Acción'
			};
			this.table_options.sortable = ['custom_date', 'code', 'name', 'payroll_staff.first_name'];
			this.table_options.filterable = ['custom_date', 'code', 'name', 'payroll_staff.first_name'];
			this.table_options.columnsClasses = {
				'custom_date': 'col-md-2',
				'code': 'col-md-2',
				'name': 'col-md-3',
				'payroll_staff.first_name': 'col-md-3',
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
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				
			},
		}
	};
</script>