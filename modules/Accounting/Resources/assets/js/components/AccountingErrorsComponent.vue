<template>
	<div class="alert alert-danger" role="alert" v-if="existErrors">
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
				options:[],
			}
		},
		computed:{
			existErrors:function(){
				return (this.options.length > 0);
			}
		},
		created(){
			EventBus.$on('show:errors',(data)=>{
				this.options = [];
				this.options = data;
			});
		}
	};
</script>
