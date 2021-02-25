<template>
	<section>
		<v-client-table :columns="columns" :data="records" :options="table_options">
			<div slot="code" slot-scope="props" class="text-center">
				<span>
					{{ props.row.code }}
				</span>
			</div>
			<div slot="id" slot-scope="props" class="text-center">
				<div class="d-inline-flex">

					<citizenservice-request-close
						:route_list="'citizenservice/get-documents/' + props.row.id"
						:request_id="props.row.id">
					</citizenservice-request-close>

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
	</section>
</template>

<script>
	export default {
		data() {
			return {
				records: [],
				errors: [],
				columns: ['requested_by', 'state', 'date', 'id']
			}
		},
		created() {
			this.readRecords(this.route_list);
			this.table_options.headings = {
				'requested_by': 'Solicitado por',
				'state': 'Estado de la solicitud',
				'date': 'Fecha de la solicitud',
				'id': 'Acción'
			};
			this.table_options.sortable = ['requested_by', 'state', 'date'];
			this.table_options.filterable = ['requested_by', 'state', 'date'];

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


		}
	};
</script>
