<template>
	<div class="card">
		<div class="card-header">
			<h6 class="card-title">Formulación</h6>
			<div class="card-btns">
				<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
				   data-toggle="tooltip">
					<i class="now-ui-icons arrows-1_minimal-up"></i>
				</a>
			</div>
		</div>
		<div class="card-body"></div>
		<div class="card-footer text-right">
			<button type="reset" class="btn btn-default btn-icon btn-round" data-toggle="tooltip" 
					title="Borrar datos del formulario">
				<i class="fa fa-eraser"></i>
			</button>
			<button type="button" class="btn btn-warning btn-icon btn-round" data-toggle="tooltip" 
					title="Cancelar y regresar">
				<i class="fa fa-ban"></i>
			</button>
			<button type="button" class="btn btn-success btn-icon btn-round" data-toggle="tooltip" 
					title="Guardar registro" @click="createRecord('budget/subspecific-formulations')">
				<i class="fa fa-save"></i>
			</button>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					year: '',
					specific_action_id: '',
				},
				errors: [],
			}
		},
	};
</script>