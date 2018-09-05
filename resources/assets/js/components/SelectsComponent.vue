<template>
	<select class="form-control select2" data-toggle="tooltip" title="Seleccione una opción">
		<slot></slot>
	</select>
</template>

<script>
	import Select2 from 'select2';

	export default {
		props: ['options', 'value'],
		mounted: function() {
			var vm = this;
			$(this.$el).select2({data: this.options})
					   .val(this.value)
					   .trigger('change')
					   .on('change', function() {
					   		vm.$emit('input', this.value)
					   });
		},
		/**
		 * Monitorea el valor de un select y carga los datos del select dependiente cuando este cambia su valor
		 *
		 * @author Ing. Roldan Vargas (rvargas at cenditel.gob.ve)
		 * @type {Object}
		 */
		watch: {
			value: function(value) {
				$(this.$el).val(value).trigger('change');
			},
			options: function(options) {
				$(this.$el).empty().trigger('change').select2({data: options});
			}
		},
		destroyed: function() {
			$(this.$el).off().select2('destroy');
		}
	};
</script>

<style>
	select {
		width: 100%;
	}
</style>