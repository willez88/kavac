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
            <div slot="payroll_staff" slot-scope="props">
                <span>
                    {{
                        props.row.payroll_staff
                            ? props.row.payroll_staff.id
                                ? props.row.payroll_staff.first_name + ' ' + props.row.payroll_staff.last_name
                                : 'No definido'
                            : 'No definido'

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
				columns: ['payroll_staff', 'motive_permission', 'status', 'id']
			}
		},
		created() {
			this.readRecords(this.route_list);
			this.table_options.headings = {
                'payroll_staff': 'Trabajador',
				'motive_permission': 'Motivo del permiso',
				'status':        'Estatus de la solicitud',
				'id': 'Acción'
			};
			this.table_options.sortable = ['payroll_staff', 'motive_permission', 'status'];
			this.table_options.filterable = ['payroll_staff', 'motive_permission', 'status'];

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
