<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title text-uppercase">Solicitud de Almacén</h6>
			<div class="card-btns">
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
					<b>Datos de la Solicitud</b>
				</div>

				<div class="col-md-6">
					<div class="form-group is-required">
						<label>Fecha de la Solicitud</label>
						<input type="date" data-toggle="tooltip" 
							   title="Fecha de la solicitud" 
							   class="form-control input-sm" 
							   readonly="readonly" v-model="record.created_at">
						<input type="hidden" v-model="record.id">
                    </div>
				</div>
			
				<div class="col-md-6">
					<div class="form-group is-required">
						<label>Motivo de la Solicitud</label>
						<input type="text" data-toggle="tooltip" 
							   title="Indique el motivo de la solicitud (requerido)" 
							   class="form-control input-sm" 
							   v-model="record.motive">
                    </div>
				</div>

			</div>

			<table class="table table-hover table-striped dt-responsive datatable">
				<thead>
					<tr class="text-center">			
						<th>
							<label class="form-checkbox">
								<input type="checkbox" v-model="selectAll" @click="select">
							    <i class="form-icon"></i>
							</label>
						</th>
						<th>Nombre</th>
						<th>Ubicación</th>
						<th>Inventario</th>
						<th></th>
					</tr>
				</thead>


				<tbody>
					<tr v-for="request in records">
						<td>
							<label class="form-checkbox">
		    					<input type="checkbox" :value="request.id" v-model="selected">
								<i class="form-icon"></i>
		  					</label>
						</td>
						<td>{{ request.motive}}</td>
						<td></td>
						<td></td>
						<td></td>

					</tr>
				</tbody>
			</table>


	        <div class="card-footer text-right">
            	<button type="button" @click="reset()"
						class="btn btn-default btn-icon btn-round"
						title ="Borrar datos del formulario">
						<i class="fa fa-eraser"></i>
				</button>

            	<button type="button"
            			class="btn btn-warning btn-icon btn-round btn-modal-close"
            			data-dismiss="modal"
            			title="Cancelar y regresar">
            			<i class="fa fa-ban"></i>
            	</button>

            	<button type="button"  @click=""
            			class="btn btn-success btn-icon btn-round btn-modal-save"
            			title="Guardar registro">
            		<i class="fa fa-save"></i>
                </button>
            </div>

		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id: '',
					motive: '',					
				},
				records: [],
				errors: [],
				selectd: [],
				selectAll: false,
			}
		},
		created() {

		},
		methods: {
			reset() {
				this.record = {
					id: '',
					motive: '',
				}

			},

			select() {
				this.selected = [];
				if (!this.selectAll) {
					for (let index in this.records) {
						this.selected.push(this.records[index].id);
					}
				}
			},
		}
	};
</script>
