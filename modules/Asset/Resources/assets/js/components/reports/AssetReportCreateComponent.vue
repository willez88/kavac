<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Reporte de Bienes Institucionales</h6>
			<div class="card-btns">
				<a href="#" class="btn btn-sm btn-primary btn-custom" @click="createRecord()"
				   title="Generar reporte" data-toggle="tooltip">
					<i class="fa fa-file-pdf-o"></i>
				</a>
				<a href="#" class="btn btn-sm btn-primary btn-custom" @click="redirect_back(route_list)" 
				   title="Ir atrás" data-toggle="tooltip">
					<i class="fa fa-reply"></i>
				</a>
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
		<div class="card-body">
			<div class="alert alert-danger" v-if="errors.length > 0">
				<ul>
					<li v-for="error in errors">{{ error }}</li>
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12">
					<strong>Tipo de Reporte</strong>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Clasificación de Bienes</label>
						<div class="col-12">
							<input type="radio" name="type_search" value="clasification" id="sel_clasification_search" 
								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search" 
								   data-on-label="SI" data-off-label="NO">
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class=" form-group">
						<label>Generales de Bienes</label>
						<div class="col-12">
							<input type="radio" name="type_search" value="general" id="sel_general_search" 
								   class="form-control bootstrap-switch bootstrap-switch-mini sel_type_search" 
								   data-on-label="SI" data-off-label="NO">
						</div>
					</div>
				</div>
			</div>
		</div>

        <div class="card-footer">
        </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					type_search: ''
				},

				filters: {
					mes_id: '',
					year_id: '',
					start_date: '',
					end_date: '',
				}

				records: [],
				errors: [],
			}
		},

		created() {
			this.loadAssets();
		},
		mounted() {
			this.switchHandler('type_search');
		},
		methods: {

			reset() {
				this.record = {
					id: '',
					type_reserch: '',
				
			},

			loadAssets() {
				const vm = this;
				axios.get('/asset/registers/vue-list').then(response => {
					vm.records = response.data.records;
				});
			},
			createRecord() {
				const vm = this;
				console.log(vm.record);

			},
			filterRecords() {
				const vm = this;
				var url =  '/asset/registers/search';

				var filters = {
					case: (vm.record.id == '')?'1':'2',
					type: vm.record.type_id,
					category: vm.record.category_id,
					subcategory: vm.record.subcategory_id,
					specific_category: vm.record.specific_category_id
				};

				axios.post(url, filters).then(response => {
					vm.records = response.data.records;
				});

			},
		}
	};
</script>