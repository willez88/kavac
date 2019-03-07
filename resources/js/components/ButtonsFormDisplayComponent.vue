<template>
	<div class="btn-display">
		<button type="button" @click="reset" class="btn btn-default btn-icon btn-round" data-toggle="tooltip" 
				title="Borrar datos del formulario">
			<i class="fa fa-eraser"></i>
		</button>
		<button type="button" @click="redirect_back(route_list)" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" 
				title="Cancelar y regresar">
			<i class="fa fa-ban"></i>
		</button>
		<button type="button" @click="createRecord(route_create)" class="btn btn-success btn-icon btn-round" data-toggle="tooltip" 
				title="Guardar registro">
			<i class="fa fa-save"></i>
		</button>
	</div>
</template>

<script>
	export default {
		methods: {
			reset() {

			}
		},
		mounted() {
			$(window).scroll(function () {
	            if ($(this).scrollTop() > 50) {
	                $('.btn-display').fadeIn();
	            }
	            else {
	                $('.btn-display').fadeOut();
	            }
	        });
		}
	};
</script>