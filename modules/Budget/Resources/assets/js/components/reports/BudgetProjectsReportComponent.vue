<template>
	<div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-12">
					<strong>Filtros</strong>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Código</label>
						<input
							v-model="params.project_code"
							type="text"
							class="form-control input-sm"
						/>
					</div>
				</div>
				<!-- trabajador -->
				<div class="col-md-6">
					<div class="form-group">
						<label>Nombre del proyecto:</label>
						<input
							v-model="params.search"
							type="text"
							class="form-control input-sm"
						/>
					</div>
				</div>
				<!-- ./trabajador -->
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="d-flex justify-content-end">
						<button
							class="btn btn-primary btn-xs btn-icon btn-action mr-3"
							title="Generar reporte"
							data-toggle="tooltip"
							type="button"
							@click="getPdf"
						>
							<i class="fa fa-file-pdf-o"></i>
						</button>
						<button
							type="button"
							class="btn btn-sm btn-info float-right"
							title="Buscar registro"
							data-toggle="tooltip"
							@click="getData"
						>
							<i class="fa fa-search"></i>
						</button>
					</div>
				</div>
			</div>
			<hr />
		</div>
		<v-client-table
			:columns="columns"
			:data="records"
			:options="table_options"
		>
		</v-client-table>
	</div>
</template>

<script>
export default {
	props: {
		url: {
			type: String,
			required: true
		},
		pdf: {
			type: String,
			required: true
		}
	},
	data() {
		return {
			codes: [],
			params: {
				project_code: '',
				search: ''
			},
			records: [],
			columns: ['code', 'name']
		};
	},
	created() {
		this.table_options.headings = {
			code: 'Código',
			name: 'Proyecto'
		};
		this.table_options.sortable = ['code', 'name'];
		this.table_options.filterable = ['code', 'name'];
		this.table_options.columnsClasses = {
			code: 'col-md-6',
			name: 'col-md-6'
		};

		this.getData();
	},
	methods: {
		async getData() {
			try {
				const config = {
					params: this.params
				};

				const { data } = await axios.get(this.url, config);
				this.records = data.data;
			} catch (error) {
				console.error(error);
			}
		},

		getPdf() {
			const params = Object.keys(this.params).map(key => {
				return `${key}=${this.params[key]}`;
			});

			window.open(`${this.pdf}?${params.join('&')}`);
		},

		reset() {}
	}
};
</script>
