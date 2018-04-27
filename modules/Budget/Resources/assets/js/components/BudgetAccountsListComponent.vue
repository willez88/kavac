<template>
	<table class="table table-big table-hover table-striped dt-responsive nowrap datatable">
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
					<button @click="" 
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
	</table>
</template>

<script>
	export default {
		data() {
			return {
				records: []
			}
		},
		mounted() {
			this.readRecords(this.route_list);
		},
	}
</script>