<template>
	<div class="col-md-2 text-center">
		<a class="btn-simplex btn-simplex-md btn-simplex-primary" 
		   href="#" title="Registros de las Reglas de Almacén" data-toggle="tooltip" 
		   @click="addRecord('add_rule', 'rules', $event)">
			<i class="icofont icofont-papper ico-3x"></i>
			<span>Reglas de Almacén</span>
		</a>
		<div class="modal fade text-left" tabindex="-1" role="dialog" id="add_rule">
			<div class="modal-dialog vue-crud" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
						<h6>
							<i class="icofont icofont-papper ico-2x"></i> 
							Reglas de Almacén
						</h6>
					</div>
					<div class="modal-body">
						<div class="alert alert-danger" v-if="errors.length > 0">
							<ul>
								<li v-for="error in errors">{{ error }}</li>
							</ul>
						</div>

						<table class="table table-formulation">
						</table>
	                </div>	     

	                <div class="modal-footer">
		            </div>
		            
		        </div>
		    </div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					id:'',
					name: '',
				},
				errors: [],
				records: [],
				columns: ['name','id'],
			}
		},
		methods: {
			/**
			 * Método que borra todos los datos del formulario
			 * 
			 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			reset() {
				this.record = {
					id: '',
					name: '',
				};
			},
		},
		created() {
			this.table_options.headings = {
				'inventary.product.name': 'Producto',
				'min': 'Minimo',
				'user.name': 'Usuario',
				'id': 'Acción'
			};
			this.table_options.sortable = ['name'];
			this.table_options.filterable = ['name'];
		},
	}
</script>
