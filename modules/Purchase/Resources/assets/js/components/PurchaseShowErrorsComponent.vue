<template>
	<div :class="'alert alert-'+classAlert" role="alert" v-if="existErrors">
		<div class="container">
			<div class="alert-icon">
				<i class="now-ui-icons objects_support-17"></i>
			</div>
			<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
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
		}
	};
</script>
