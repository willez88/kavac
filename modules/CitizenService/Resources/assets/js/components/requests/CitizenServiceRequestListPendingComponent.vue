
<template>
	<div class="col-md-12">

		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="id" slot-scope="props" class="text-center">
				<div class="d-inline-flex">
					<citizenservice-request-pending
	                    :requestid="props.row.id"
	                    route_update="citizenservice/requests/pending"
	                    request_type='accept'>
	                </citizenservice-request-pending>

	                <citizenservice-request-pending
	                    :requestid="props.row.id"
	                    route_update="citizenservice/requests/pending"
	                    request_type='rejected'>
	                </citizenservice-request-pending>
	            </div>

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
				'state': 'Estado de la solicitud',
				'date': 'Fecha de la solicitud',
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
	};
</script>
