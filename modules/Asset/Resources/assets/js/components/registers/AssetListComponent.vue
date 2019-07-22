<template>
	<v-client-table :columns="columns" :data="records" :options="table_options">
		<div slot="asset_condition" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.asset_condition)?props.row.asset_condition.name:'N/A' }}
			</span>
		</div>
		<div slot="asset_status" slot-scope="props" class="text-center">
			<span>
				{{ (props.row.asset_status)?props.row.asset_status.name:'N/A' }}
			</span>
		</div>
		<div slot="id" slot-scope="props" class="text-center">
			<div class="d-inline-flex">
				<asset-info
	            		:route_list="'registers/info/'+ props.row.id">
	        	</asset-info>

				<button @click="assignAsset(props.row.id)" 
	    				class="btn btn-primary btn-xs btn-icon btn-action" 
	    				title="Asignar Bien" data-toggle="tooltip" :disabled="(props.row.asset_status_id == 10)?false:true"
	    				type="button">
	    			<i class="fa fa-filter"></i>
	    		</button>
	    		<button @click="disassignAsset(props.row.id)" 
	    				class="btn btn-danger btn-xs btn-icon btn-action" 
	    				title="Desincorporar Bien" data-toggle="tooltip" :disabled="((props.row.asset_status_id < 6)||(props.row.asset_status_id > 9))?false:true"
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
				columns: ['inventory_serial', 'asset_condition','asset_status','serial','marca','model', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'inventory_serial': 'Código',
				'asset_condition': 'Condición Física',
				'asset_status': 'Estatus de Uso',
				'serial': 'Serial',
				'marca': 'Marca',
				'model': 'Modelo',
				'id': 'Acción'
			};
			this.table_options.sortable = ['inventory_serial', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'];
			this.table_options.filterable = ['inventory_serial', 'asset_condition', 'asset_status', 'serial', 'marca', 'model'];
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

			/**
			 * Redirige al formulario de asignación de bienes institucionales
			 *
			 * @param [Integer] $id Identificador único del bien
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			assignAsset(id)
			{
				location.href = '/asset/asignations/asset/' + id;
			},

			/**
			 * Redirige al formulario de desincorporación de bienes institucionales
			 *
			 * @param [Integer] $id Identificador único del bien
			 * @author Henry Paredes <hparedes@cenditel.gob.ve>
			 */
			disassignAsset(id)
			{
				location.href = '/asset/disincorporations/asset/' + id;
			},

		}
	};
</script>