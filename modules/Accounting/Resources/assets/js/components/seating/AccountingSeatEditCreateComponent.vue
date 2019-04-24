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
						<input type="date" class="form-control" v-model="date">
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
			</div>

		</div>
	</form>
</div>
</template>
<script>
	export default{
		data(){
			return{
				errors:[],
				date:'',
				reference:'',
				concept:'',
				observations:'',
				validated:false,
			}
		},
		created(){
			EventBus.$on('show:erros',(data)=>{
				this.errors = [];
				this.errors = data.errors;
			})
		},
		beforeDestroy(){
            this.$EventBus.$off('show:erros');
        },
		methods:{
			validateRequired:function() {
				if (this.validated == false) {
					if (this.date != '' && this.reference != '') {
						EventBus.$emit('enableInput:seating-account',{'value':true,
																	  'date':this.date,
																	  'reference':this.reference,
																	  'concept':this.concept,
																	  'observations':this.observations
																	});
						this.validated = true;
					}
				}
				else {
					EventBus.$emit('enableInput:seating-account',{'value':true,
																  'date':this.date,
																  'reference':this.reference,
																  'concept':this.concept,
																  'observations':this.observations
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
			}
		}
	}
</script>