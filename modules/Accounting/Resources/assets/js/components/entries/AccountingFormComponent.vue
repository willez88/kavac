<template>
<div>
	<form @submit.prevent="" class="form-horizontal">
		<div class="card-body">

			<div class="row">
				<div class="col-3" id="helpEntriesDate">
					<div class="form-group is-required">
						<label class="control-label">Fecha</label>
						<input :disabled="data_edit != null" type="date" class="form-control input-sm" v-model="date">
					</div>
				</div>
                <div class="col-6 offset-3" id="helpEntriesInstitution">
                    <div class="form-group is-required">
                        <label class="control-label">Institución que genera</label>
                        <select2 :options="institutions" v-model="institution_id"></select2>
                    </div>
                </div>
                <div class="col-6" id="helpEntriesCategory">
                    <div class="form-group is-required">
                        <label class="control-label">Categoría del asiento</label>
                        <select2 :options="categories" v-model="category"></select2>
                    </div>
                </div>
                <div class="col-6" id="helpEntriesCurrency">
                    <div class="form-group is-required">
                        <label class="control-label">Tipo de moneda</label>
                        <select2 :options="currencies" v-model="currency_id"></select2>
                    </div>
                </div>
				<div class="col-3" id="helpEntriesDescription">
					<div class="form-group is-required">
						<label class="control-label">Concepto ó Descripción</label>
						<input type="text" class="form-control input-sm" v-model="concept">
					</div>
				</div>
				<div class="col-3" id="helpEntriesObservation">
					<div class="form-group">
						<label class="control-label">Observaciones</label>
						<input type="text" class="form-control input-sm" v-model="observations">
					</div>
				</div>
				<div class="col-3" id="helpEntriesReference">
					<div class="form-group">
						<label class="control-label">Código Referencia</label><br>
						<h5 class="control-label"><strong>{{ reference }}</strong></h5>
					</div>
				</div>
			</div>

		</div>
	</form>
</div>
</template>
<script>
	export default{
		props:{
            categories:{
                type:Array,
                default: function(){
                	return []
                }
            },
            institutions:{
                type:Array,
                default: function(){
                	return [{ id:'', text:'Seleccione...'}];
                }
            },
            currencies:{
                type:Array,
                default: function(){
                	return [{ id:'', text:'Seleccione...'}];
                }
            },
            data_edit:{
                type:Object,
                default: function(){
                	return null
                }
            },
        },
		data(){
			return{
				date:'',
				reference:'',
				concept:'',
				observations:'',
				category:'',
				validated:false,
				institution_id:'',
				currency_id:'',
				data_edit_mutable:null,
			}
		},
		created(){
			this.institution_id = this.institutions[0]['id'];
			if (this.data_edit) {
				this.data_edit_mutable = this.data_edit;

				this.reference = this.data_edit.reference;

				this.category = this.data_edit.category;
				this.institution_id = this.data_edit.institution;
				this.currency_id = this.data_edit.currency;
				this.date = this.data_edit.date;
				this.concept = this.data_edit.concept;
				this.observations = this.data_edit.observations;
			}

			EventBus.$on('reset:accounting-entry-edit-create',()=>{
				this.reset();
			});
		},
		methods:{

			reset(){
				this.date = '';
				this.concept = '';
				this.observations = '';
				this.category = '';
				this.currency_id = null;
				this.institution_id = null;
			},

			/**
			* Valida las variables del formulario para realizar el filtrado, y emite el evento para actualizar los datos al componente AccountingAccountsInFormComponent
			*
			* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			*/
			validateRequired:function() {

				if (!this.validated &&
					(this.date == '' ||
					this.concept == '' ||
					this.observations == '' ||
					this.category == '' ||
					this.institution_id == null)) {

					EventBus.$emit('enableInput:entries-account',{
						'value':false,
						'date':this.date,
						'reference':this.reference,
						'concept':this.concept,
						'observations':this.observations,
						'category':this.category,
						'institution_id':this.institution_id,
						'currency_id':this.currency_id,
					});
				}

				if (this.validated == false) {
					/**
					 * se verifica que la fecha, la referencia, la institucion, la categoria y el tipo de moneda no esten vacios
					*/
					if (this.date != '' && this.institution_id != null && this.category != ''
						&& this.currency_id != '') {
						EventBus.$emit('enableInput:entries-account', {
							'value':true,
							'date':this.date,
							'reference':this.reference,
							'concept':this.concept,
							'observations':this.observations,
							'category':this.category,
							'institution_id':this.institution_id,
							'currency_id':this.currency_id,
						});
						this.validated = true;
					}
				}
				else {
					/**
					 *si se modifica la fecha o la referencia se envia la información actualizada
					*/
					EventBus.$emit('enableInput:entries-account',{
						'value':true,
						'date':this.date,
						'reference':this.reference,
						'concept':this.concept,
						'observations':this.observations,
						'category':this.category,
						'institution_id':this.institution_id,
						'currency_id':this.currency_id,
					});
				}
			},

			// generateReferenceCode(){
			// 	axios.post('/accounting/settings/generateReferenceCode').then(response=>{
			// 		if (response.data.result) {
			// 			location.href = '/accounting/settings';
			// 		}
			// 		this.reference = response.data.code;
			// 		this.validated = false;
			// 		this.validateRequired();
			// 	})
			// }
		},
		watch:{
			date:function(res) {
				if (res == '') {
					this.validated = false;
				}else
					this.validateRequired();
			},
			reference:function(res) {
				if (res == '') {
					this.validated = false;
				}else
					this.validateRequired();
			},
			concept:function(res) {
				this.validateRequired();
			},
			observations:function(res) {
				this.validateRequired();
			},
			category:function(res) {
				if (res != '') {
					this.validateRequired();
				}
				else{
					this.validated = false;
					this.validateRequired();
				}

			},
			currency_id:function(res){
				if (res) {
					EventBus.$emit('change:currency', res);
				}
				this.validateRequired();
			},
			institution_id:function(res) {
				if (res == '') {
					this.validated = false;
					this.validateRequired();
				}
				if (!this.data_edit_mutable) {
					this.data_edit_mutable = null;
				}
				this.validateRequired();
			}
		}
	};
</script>
