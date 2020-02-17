
<template>																																		
	<div class="col-md-12">
		
		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="id" slot-scope="props" class="text-center">
				<button @click="acceptRequest(props.index)" 
						class="btn btn-success btn-xs btn-icon btn-action"
						title="Aceptar Solicitud" data-toggle="tooltip" type="button">
					<i class="fa fa-check"></i>
				</button>
				
				<button @click="rejectedRequest(props.index)" 
						class="btn btn-danger btn-xs btn-icon btn-action" title="Rechazar Solicitud" data-toggle="tooltip" type="button">
					<i class="fa fa-ban"></i>
				</button>
			</div>
			<div slot="requested_by" slot-scope="props" class="text-center">
                <span>
                    {{ 
                        props.row.first_name + ' ' + props.row.last_name
                    }}

                </span>
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
				columns: ['requested_by', 'motive_request', 'state', 'date', 'id']
			}
		},
		created() {
			this.readRecords(this.route_list);
			this.table_options.headings = {
				'requested_by': 'Solicitado por',
				'motive_request': 'Motivo',
				'state': 'Estado de la Solicitud',
				'date': 'Fecha de la Solicitud',
				'id': 'Acción'
			};
			this.table_options.sortable = ['requested_by', 'motive_request', 'state', 'date'];
			this.table_options.filterable = ['requested_by', 'motive_request', 'state', 'date'];

		},
		methods: {

			acceptRequest(index)
			{
				const vm = this;
				var fields = this.records[index-1];
				var id = this.records[index-1].id;
				
				axios.put('/'+this.route_update+'/request-approved/'+id, fields).then(response => {
					if (typeof(response.data.redirect) !== "undefined") {
						location.href = response.data.redirect;
					}
					else {
						vm.readRecords(url);
						vm.reset();
						vm.showMessage('update');
					}
				}).catch(error => {
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});
			},
			rejectedRequest(index)
			{
				const vm = this;
				var fields = this.records[index-1];
				var id = this.records[index-1].id;

				axios.put('/'+this.route_update+'/request-rejected/'+id, fields).then(response => {
					if (typeof(response.data.redirect) !== "undefined") {
						location.href = response.data.redirect;
					}
					else {
						vm.readRecords(url);
						vm.reset();
						vm.showMessage('update');
					}
				}).catch(error => {
					vm.errors = [];

					if (typeof(error.response) !="undefined") {
						for (var index in error.response.data.errors) {
							if (error.response.data.errors[index]) {
								vm.errors.push(error.response.data.errors[index][0]);
							}
						}
					}
				});
			},

		}
	}
</script>