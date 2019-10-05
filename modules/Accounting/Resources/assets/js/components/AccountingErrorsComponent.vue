<template>
	<div class="alert alert-danger" role="alert" v-if="existErrors">
		<div class="container">
			<div class="alert-icon">
				<i class="now-ui-icons objects_support-17"></i>
			</div>
			<strong>Cuidado!</strong> Debe verificar los siguientes errores antes de continuar:
            <button type="button" @click="this.reset" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">
					<i class="now-ui-icons ui-1_simple-remove"></i>
				</span>
			</button>
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
				if (Array.isArray(data)) {
					if (data.length == 0) {
						this.options = [];	
					}else{
						this.options = data;
					}
				}else{
					this.options = [];
					this.options.push(data);
				}
			});
		},
		methods:{
			reset(){
				this.options = [];
			}
		}
	};
</script>
