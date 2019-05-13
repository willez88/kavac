<template>
<div>
	<form @submit.prevent="" class="form-horizontal">
		<div class="card-body">
			<div class="alert alert-danger" role="alert" v-if="errors.length > 0">
				<div class="container">
					<div class="alert-icon">
						<i class="now-ui-icons objects_support-17"></i>
					</div>
					<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
					<ul>
						<li v-for="error in errors">{{ error }}</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="form-group is-required">
						<label class="control-label">Fecha
						</label>
						<input :disabled="date_edit != null" type="date" class="form-control" v-model="date">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="control-label">Concepto
						</label>
						<input type="text" class="form-control" v-model="concept">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="control-label">Observaciones
						</label>
						<input type="text" class="form-control" v-model="observations">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group is-required">
						<label class="control-label">Referencia
						</label>
						<input type="text" class="form-control" v-model="reference">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="control-label">Asiento generado por
						</label>
						<select2 :options="categories" v-model="generated_by_id"></select2>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>
</template>
<script>
	export default{
		props:['categories','category_edit','date_edit','reference_edit','concept_edit','observations_edit'],
		data(){
			return{
				errors:[],
				date:'',
				reference:'',
				concept:'',
				observations:'',
				generated_by_id:'',
				validated:false,
			}
		},
		created(){
			if (this.category_edit != null) {
				this.generated_by_id = this.category_edit.id;
				console.log('CAT '+this.category_edit);
			}
		},
		mounted(){
			if (this.date_edit != null) {
				this.date = this.date_edit;
				this.reference = this.reference_edit;
				this.concept = this.concept_edit;
				this.observations = this.observations_edit;
			}
		},
		methods:{
			validateRequired:function() {
				if (this.validated == false) {
					// se verifica que la fecha y la referencia no esten vacias
					if (this.date != '' && this.reference != '') {
						EventBus.$emit('enableInput:seating-account',{'value':true,
																	  'date':this.date,
																	  'reference':this.reference,
																	  'concept':this.concept,
																	  'observations':this.observations,
																	  'generated_by_id':this.generated_by_id
																	});
						this.validated = true;
					}
				}
				else {
					// si se modifica la fecha o la referencia se envia la información actualizada
					EventBus.$emit('enableInput:seating-account',{'value':true,
																  'date':this.date,
																  'reference':this.reference,
																  'concept':this.concept,
																  'observations':this.observations,
																  'generated_by_id':this.generated_by_id
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
			generated_by_id:function(res) {
				this.validateRequired();
			},
		}
	}
</script>