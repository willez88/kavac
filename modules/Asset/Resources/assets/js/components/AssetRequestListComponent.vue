<template>

	<div class="col-md-12">
		<hr>
		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="id" slot-scope="props" class="text-center d-inline-flex">
				
				<request-info 
					:request="props.row">									
				</request-info>
				
				<div v-if="props.row.type > 1">
					<request-prorroga :request="props.row">
					</request-prorroga>
				</div>

				<request-event :id="props.row.id">
				</request-event>

				<button @click="editForm(props.row.id)" 
						class="btn btn-warning btn-xs btn-icon btn-action"
						title="Editar Solicitud" data-toggle="tooltip" type="button">
					<i class="icofont icofont-edit"></i>
				</button>

				<button @click="deleteRecord(props.index, '')" 
						class="btn btn-danger btn-xs btn-icon btn-action" title="Eliminar registro" data-toggle="tooltip" type="button">
					<i class="fa fa-trash-o"></i>
				</button>

			</div>

		</v-client-table>
	</div>

	
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				errors: [],
				columns: ['type', 'motive', 'created_at', 'state', 'id'],
			}
		},
		created() {
			this.readRecords(this.route_list);
			this.table_options.headings = {
				'type': 'Tipo de Solicitud',
				'motive': 'Motivo',
				'created_at': 'Fecha de Emisión',
				'state': 'Estado de la Solicitud',
				'id': 'Acción'
			};
			this.table_options.sortable = ['type','motive','created_at','state'];
			this.table_options.filterable = ['type','motive','created_at','state'];

		},
		methods: {
			editForm(id){
				location.href = '/' + this.route_edit + '/' + id;		
			},

		}
	}
</script>