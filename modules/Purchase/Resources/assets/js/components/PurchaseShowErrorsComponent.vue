<template>
	<div :class="'alert alert-'+classAlert" role="alert" v-if="existErrors">
		<div class="container">
			<div class="alert-icon">
				<i class="now-ui-icons objects_support-17"></i>
			</div>
			<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
            <!-- <button type="button" @click="this.reset" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">
					<i class="now-ui-icons ui-1_simple-remove"></i>
				</span>
			</button> -->
			<ul>
				<li v-for="error in options">{{ error }}</li>
			</ul>
		</div>
	</div>
</template>
<script>
	export default{
		data(){
			return{
				options: [],
				classAlert:'danger'
			}
		},
		computed:{
			existErrors:function(){
				// Si hay algun error en el componente padre actualiza
				if (this.$parent.errors) {
					this.options = this.$parent.errors;
				};
				return (this.options.length > 0);
			},
		},
		methods:{
			/**
			 * [reset resetea valores de variables]
			 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			 */
			reset(){
				this.options = [];
			},

			/**
			 * [showAlertMessages carga la informacion de los errores]
			 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
			 * @param  {string|array} messages mensajes de error
			 * @param  {string} messages clase de mensaje
			 */
			showAlertMessages(messages, classAlert = 'danger'){

				this.classAlert = classAlert;

				if (Array.isArray(messages)) {
					if (messages.length == 0) {
						this.options = [];	
					}else{
						this.options = messages;
					}
				}
				else if(!messages){
					this.options = [];
				}
				else{
					this.options = [];
					this.options.push(messages);
				}
			},
		}
	};
</script>
