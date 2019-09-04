<template>
<div>
	<form @submit.prevent="" class="form-horizontal">
		<div class="card-body">
			
			<accounting-show-errors />

			<div class="row">
				<div class="col-4">
					<div class="form-group is-required">
						<label class="control-label">Fecha
						</label>
						<input :disabled="data_edit != null" type="date" class="form-control" v-model="date"
								tabindex="1">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="control-label">Concepto ó Descripción
						</label>
						<input type="text" class="form-control" v-model="concept" tabindex="1">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="control-label">Observaciones
						</label>
						<input type="text" class="form-control" v-model="observations" tabindex="1">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group is-required">
						<label class="control-label">Categoría del asiento
						</label>
						<select2 :options="categories" v-model="category" tabindex="1"></select2>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group is-required">
						<label class="control-label">Referencia
						</label>
						<input type="text" class="form-control" v-model="reference" id="reference" tabindex="1">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group is-required">
						<label class="control-label">Institución que genera
						</label>
						<select2 :options="institutions" v-model="institution" tabindex="1"></select2>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>
</template>
<script>
	export default{
		props:['categories','institutions','data_edit'],
		data(){
			return{
				date:'',
				reference:'',
				concept:'',
				observations:'',
				category:'',
				validated:false,
				institution:'',
				institution_id:null,
				data_edit_mutable:null,
			}
		},
		created(){
			if (this.data_edit != null) {
				this.data_edit_mutable = this.data_edit;

				this.reference = this.data_edit.reference;

				this.category = this.data_edit.category;
				this.institution = this.data_edit.institution;
			}
		},
		mounted(){
			if (this.data_edit != null) {
				this.date = this.data_edit.date;
				this.concept = this.data_edit.concept;
				this.observations = this.data_edit.observations;
			}
		},
		methods:{
			/**
			* Valida las variables del formulario para realizar el filtrado, y emite el evento para actualizar los datos al componente AccountingAccountsInSeatingComponent
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			validateRequired:function() {
				if (this.validated == false) {
					/**
					 * se verifica que la fecha, la referencia, la institucion y la categoria no esten vacios
					*/ 
					if (this.date != '' && this.reference != '' && this.institution_id != null && this.category != '') {
						EventBus.$emit('enableInput:seating-account',{'value':true,
																	  'date':this.date,
																	  'reference':this.reference,
																	  'concept':this.concept,
																	  'observations':this.observations,
																	  'category':this.category,
																	  'institution_id':this.institution_id,
																	});
						this.validated = true;
					}
				}
				else {
					/**
					 *si se modifica la fecha o la referencia se envia la información actualizada
					*/
					EventBus.$emit('enableInput:seating-account',{'value':true,
																  'date':this.date,
																  'reference':this.reference,
																  'concept':this.concept,
																  'observations':this.observations,
																  'category':this.category,
																  'institution_id':this.institution_id,
																});
				}
			},
		},
		watch:{
			date:function(res) {
				if (res == '') {
					this.validated = false;
					EventBus.$emit('enableInput:seating-account',{'value':false});
				}else
					this.validateRequired();
			},
			reference:function(res) {
				if (res == '') {
					this.validated = false;
					EventBus.$emit('enableInput:seating-account',{'value':false});
				}else
					this.validateRequired();
			},
			concept:function(res) {
				this.validateRequired();
			},
			observations:function(res) {
				this.validateRequired();
			},
			category:function(res,ant) {
				if (ant != '' && res != ant) {
					/** extrae el valor del acronimo de la categoria anterior */
					for (var i in this.categories) {
						if (this.categories[i].id == ant) {
							var tam = this.categories[i].acronym.length;
							this.reference = this.reference.slice(tam);
							break;
						}
					}
				}

				if (res != ant) {
					/** Se valida que en caso de estar editando en la primera iteracion no cambie la referencia */
						for (var i in this.categories) {
							/** si es la primera carga de los datos no modifica la referencia */
							if (this.data_edit_mutable != null && this.categories[i].id == this.data_edit_mutable.category) {
								this.reference = this.reference;
								this.validated = false;
								break;
							}
							else if (this.categories[i].id == res) {
								this.reference = this.categories[i].acronym + this.reference;
								this.validated = false;
								break;
							}
						}


					if (this.validated) {
						this.validateRequired();
					}else{
						EventBus.$emit('enableInput:seating-account',{'value':false});
					}
				}
			},
			institution:function(res) {
				this.institution_id = res;
				
				if (res == '') {
					this.validated = false;
					EventBus.$emit('enableInput:seating-account',{'value':false});
				}else{
					this.validateRequired();
				}
				if (this.data_edit_mutable != null) {
					/** Se vacia la variable que trae la informacion para no*/
					this.data_edit_mutable = null;
				}
			}
		}
	};
</script>
