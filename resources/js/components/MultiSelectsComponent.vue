<template>
	<div>
		<multiselectComponent v-model="selected_values" :options="options" :multiple="true" :taggable="taggable" :id="id" 
							  :preselect-first="preselect_first" :track-by="track_by" :label="track_by" 
							  placeholder="Seleccione..." :preserve-search="preserve_search" :hide-selected="hide_selected" 
							  :clear-on-select="clear_on_select" :close-on-select="close_on_select" @select="onSelect" 
							  :deselect-group-label="'Deseleccionar grupo'" :deselect-label="'Eliminar'" 
							  :select-group-label="'Seleccionar grupo'" :select-label="'Seleccionar'" 
							  :selected-label="'Seleccionado'" :tag-placeholder="'Crear una etiqueta'"></multiselectComponent>
	</div>
</template>

<script>
	import Multiselect from 'vue-multiselect';

  	Vue.component('multiselectComponent', Multiselect)

	export default {
		data () {
			return {
				selected_values: []
			}
		},
		props: {
			options: {
				type: Array,
				required: true,
			},
			track_by: {
				type: String,
				required: true,
			},
			taggable: {
				type: Boolean,
				required: false,
				default: true
			},
			id: {
				type: String,
				required: false,
				default: 'multiselect'
			},
			preselect_first: {
				type: Boolean,
				required: false,
				default: false
			},
			preserve_search: {
				type: Boolean,
				required: false,
				default: true
			},
			hide_selected: {
				type: Boolean,
				required: false,
				default: true
			},
			clear_on_select: {
				type: Boolean,
				required: false,
				default: true
			},
			close_on_select: {
				type: Boolean,
				required: false,
				default: true
			},
		},
		methods: {
			onSelect (option, id) {
		    	//console.log(this.value, id)
		    }
		}
	};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
	/* Custom styles */
	.multiselect {margin: 25px auto;}
	.multiselect__option--highlight, .multiselect__option--highlight:after {background: #2CA8FF;}
	.multiselect__spinner:after,
	.multiselect__spinner:before {border-top-color: #2CA8FF;}
	.multiselect__tag {background-color: #F76231;}
	.multiselect__tag-icon::after {color: #fff;}
	.multiselect__tag-icon:focus,.multiselect__tag-icon:hover {background: #F44b18;}
</style>