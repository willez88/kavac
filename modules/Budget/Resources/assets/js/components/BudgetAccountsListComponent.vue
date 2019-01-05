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
	</v-client-table>
	<!--<table class="table table-big table-hover table-striped dt-responsive nowrap datatable">
		<thead>
			<tr class="text-center">
				<th>Código</th>
				<th>Denominación</th>
				<th>Original</th>
				<th>Acción</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(rec, index) in records">
				<td width="20%">
					{{ rec.group + "." + rec.item + "." + rec.generic + "." + rec.specific + "." + rec.subspecific }}
				</td>
				<td width="60%" class="wrapping">{{ rec.denomination }}</td>
				<td class="text-center" width="10%">{{ (rec.original)?'SI':'NO' }}</td>
				<td class="text-center" width="10%">
					<button @click="editForm(rec.id)" 
							class="btn btn-warning btn-xs btn-icon btn-round" 
							title="Modificar registro" data-toggle="tooltip" type="button">
						<i class="fa fa-edit"></i>
					</button>
					<button @click="deleteRecord(index, '')" 
							class="btn btn-danger btn-xs btn-icon btn-round" title="Eliminar registro" data-toggle="tooltip" type="button">
						<i class="fa fa-trash-o"></i>
					</button>
				</td>
			</tr>
		</tbody>
	</table>-->
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				columns: ['code', 'denomination', 'original', 'id']
			}
		},
		created() {
			this.table_options.headings = {
				'code': 'Código',
				'denomination': 'Denominación',
				'original': 'Original',
				'id': 'Acción'
			};
			this.table_options.sortable = ['code', 'denomination', 'original'];
			this.table_options.filterable = ['code', 'denomination', 'original'];
		},
		mounted() {
			this.initRecords(this.route_list, '');
			//this.readRecords(this.route_list);
		},
		methods: {
			reset() {
				
			},
			editForm(id) {
				location.href = this.route_edit + '/' + id;
			}
		}
	};
</script>