<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="code" slot-scope="props" class="text-center">
			<span>
				{{ props.row.code }}
			</span>
		</div>
		<div slot="motive" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.asset_disincorporation_motive)?props.row.asset_disincorporation_motive.name:'N/A' }}
			</span>
		</div>
		<div slot="created" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.date)?props.row.date:props.row.created_at }}
			</span>
		</div>
		<div slot="id" slot-scope="props" class="text-center">
			<div class="d-inline-flex">
				<asset-disincorporation-info
					:route_list="'asset/disincorporations/vue-info/' + props.row.id">
				</asset-disincorporation-info>

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
				columns: ['code', 'motive', 'created', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'motive': 'Motivo',
				'created': 'Fecha de desincorporación',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'motive', 'created'];
			this.table_options.filterable = ['code', 'motive', 'created'];
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
		},
	};
</script>
