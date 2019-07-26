<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Historial de Inventario de Bienes Institucionales</h6>
			<div class="card-btns">
				<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)" 
				   title="Ir atrás" data-toggle="tooltip">
					<i class="fa fa-reply"></i>
				</a>
				<a href="#" class="btn btn-sm btn-primary btn-custom" @click="createRecord('asset/inventory-history')" 
				   title="Guardar estado actual de inventario" data-toggle="tooltip">
					<i class="fa fa-plus-circle"></i>
				</a>
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
		<div class="card-body">
			<v-client-table :columns="columns" :data="records" :options="table_options">
				<div slot="id" slot-scope="props" class="text-center">
					<div class="d-inline-flex">
						
						<button @click="showReport(props.row.code, 'general')" 
								class="btn btn-primary btn-xs btn-icon btn-action" 
								title="Generar reporte general de bienes" data-toggle="tooltip" 
								type="button">
							<i class="fa fa-file-pdf-o"></i>
						</button>
						<button @click="showReport(props.row.code, 'clasification')" 
								class="btn btn-primary btn-xs btn-icon btn-action" 
								title="Generar reporte por clasificación de bienes" data-toggle="tooltip" 
								type="button">
							<i class="fa fa-file-pdf-o"></i>
						</button>
						<button @click="showReport(props.row.code, 'dependence')" 
								class="btn btn-primary btn-xs btn-icon btn-action" 
								title="Generar reporte por dependencia de bienes" data-toggle="tooltip" 
								type="button">
							<i class="fa fa-file-pdf-o"></i>
						</button>

			    		<button @click="deleteRecord(props.index, 'inventory-history/delete')" 
								class="btn btn-danger btn-xs btn-icon btn-action" 
								title="Eliminar registro" data-toggle="tooltip" 
								type="button">
							<i class="fa fa-trash-o"></i>
						</button>
					</div>
				</div>
			</v-client-table>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					code: '',
				},
				records: [],
				columns: ['code', 'created', 'registered', 'assigned', 'disincorporated', 'id'],
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'created': 'Fecha de Creación',
				'registered': 'Bienes Registrados',
				'assigned': 'Bienes Asignados',
				'disincorporated': 'Bienes Desincorporados',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'created', 'registered', 'assigned', 'disincorporated'];
			this.table_options.filterable = ['code', 'created', 'registered', 'assigned', 'disincorporated'];
			this.table_options.orderBy = { 'column': 'id'};
		},
		mounted () {
			this.initRecords('/asset/inventory-history/vue-list', '');
		},
		methods: {
			/**
			 * Inicializa los datos del formulario
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					code: '',
				}
			},
			showReport(code, type_report) {
				var url = '/asset/reports/' + type_report + '/show/' + code;
				window.open(url, '_blank');
			}
		}
	};
</script>