<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="code" slot-scope="props" class="text-center">
			<span>
				{{ props.row.serial_inventario }}
			</span>
		</div>
		<div slot="institution" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.institution)?props.row.institution.name:props.row.institution_id }}
			</span>
		</div>
		<div slot="condition" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.condition)?props.row.condition.name:'N/A' }}
			</span>
		</div>
		<div slot="status" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.status)?props.row.status.name:'N/A' }}
			</span>
		</div>
		<div slot="id" slot-scope="props" class="text-center">
			<div class="d-inline-flex">
				<asset-info
	            		:route_list="'registers/info/'+ props.row.id">
	        	</asset-info>

				<button @click="assignAsset(props.row.id)" 
	    				class="btn btn-primary btn-xs btn-icon btn-action" 
	    				title="Asignar Bien" data-toggle="tooltip" :disabled="(props.row.status_id == 10)?false:true"
	    				type="button">
	    			<i class="fa fa-filter"></i>
	    		</button>
	    		<button @click="disassignAsset(props.row.id)" 
	    				class="btn btn-danger btn-xs btn-icon btn-action" 
	    				title="Desincorporar Bien" data-toggle="tooltip" :disabled="((props.row.status_id < 6)||(props.row.status_id > 9))?false:true"
	    				type="button">
	    			<i class="fa fa-chain"></i>
	    		</button>

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
				columns: ['code', 'institution', 'condition','status','serial','marca','model', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'institution': 'Ubicación',
				'condition': 'Condición Física',
				'status': 'Estatus de Uso',
				'serial': 'Serial',
				'marca': 'Marca',
				'model': 'Modelo',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'condition', 'status', 'serial', 'marca', 'model'];
			this.table_options.filterable = ['code', 'condition', 'status', 'serial', 'marca', 'model'];
			this.table_options.orderBy = { 'column': 'id'};
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
			assignAsset(id) {
				location.href = '/asset/asignations/asset/' + id;
			},
			disassignAsset(id) {
				location.href = '/asset/disincorporations/asset/' + id;
			},

		}
	};
</script>