<template>

	<div class="col-md-12">
		<hr>
		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="type" slot-scope="props" class="text-center">
				<div v-for="type in types">
					<span v-if="props.row.type == type.id">
						{{ type.text }}
					</span>
				</div>

			</div>
			<div slot="id" slot-scope="props" class="text-center d-inline-flex">
				
				<asset-request-info 
					:route_list="'requests/vue-info/' + props.row.id">
				</asset-request-info>
				
				<asset-request-prorroga :request="props.row">
				</asset-request-prorroga>

				<asset-request-event :id="props.row.id">
				</asset-request-event>

				<button @click="deliverEquipment(props.index)" 
						class="btn btn-primary btn-xs btn-icon btn-action"
						:disabled="(props.row.state == 'Aprobado')?false:true"
						data-toggle="tooltip" title="Entregar Equipos" type="button">
					<i class="icofont icofont-computer"></i>
				</button>

				<button @click="editForm(props.row.id)" 
						class="btn btn-warning btn-xs btn-icon btn-action"
						:disabled="(props.row.state == 'Pendiente')?false:true"
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

				types: [{"id":"","text":"Seleccione..."},
						{"id":1,"text":"Prestamo de Equipos (Uso Interno)"},
						{"id":2,"text":"Prestamo de Equipos (Uso Externo)"},
						{"id":3,"text":"Prestamo de Equipos para Agentes Externos"}],
			}
		},
		created() {
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
			editForm(id) {
				location.href = '/' + this.route_edit + '/' + id;		
			},
			deliverEquipment(index) {
				var id = this.records[index-1].id;
				axios.put('/asset/requests/deliver-equipment/'+ id).then(response => {
					this.showMessage('update');
					setTimeout(function() {
                        window.location.href = '/asset/requests';
                    }, 2000);
				});
			}

		}
	}
</script>