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

	/** Elimina el prop loading por conflicto con el mixin de la aplicación */
	delete Multiselect.props.loading;
	
	Vue.component('multiselectComponent', Multiselect);

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
			value: {
				type: [String, Array],
				required: false,
                default: function() {
                    return [];
                }
			},
		},
		methods: {
            /**
             * Evento que permite ejecutar las instrucciones necesarias al momento de seleccionar opciones del select
             *
             * @method    onSelect
             *
             * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
             *
             * @param     {string}    option    Texto de la opción
             * @param     {integer}   id        Identificador de la opción
             */
			onSelect (option, id) {
		    	//console.log(this.value, id)
		    }
		},
		watch: {
			selected_values: function() {
				this.$emit('input', this.selected_values)
			},
			value: function(selected) {
				this.selected_values = selected;
			}
		},
	};
</script>
