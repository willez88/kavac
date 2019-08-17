<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="code" slot-scope="props" class="text-center">
			<span>
				{{ props.row.code }}
			</span>
		</div>
		<div slot="payrollStaff" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.payrollStaff)?(props.row.payrollStaff.first_name + ' ' + props.row.payrollStaff.last_name):'N/A' }}
			</span>
		</div>
		<div slot="created" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.created_at)?props.row.created_at:'N/A' }}
			</span>
		</div>
		<div slot="id" slot-scope="props" class="text-center">
			<div class="d-inline-flex">
				<asset-asignation-info
					:route_list="'asignations/vue-info/' + props.row.id">
				</asset-asignation-info>

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
		</div>
	</v-client-table>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['code', 'payrollStaff', 'created', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'payrollStaff': 'Trabajador',
				'created': 'Fecha de Asignación',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'payrollStaff', 'created'];
			this.table_options.filterable = ['code', 'payrollStaff', 'created'];
			this.table_options.orderBy = { 'column': 'code'};
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
