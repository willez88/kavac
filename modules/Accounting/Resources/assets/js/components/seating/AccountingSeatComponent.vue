<template>
	<div>
		<form @submit.prevent="" class="form">
			<div class="row">
				<div class="col-2"></div>
				<div class="col-3">
					<label for="" class="control-label">Por Referencia
						<input type="radio" 
								name="sel_Search"
								id="sel_ref"
								data-on-label="SI" data-off-label="NO" 
								class="form-control bootstrap-switch sel_search">
					</label>
				</div>
				<div class="col-3">
					<label for="" class="control-label">Por Origen
						<input type="radio"
								name="sel_Search" 
								id="sel_origin"
								data-on-label="SI" data-off-label="NO" 
								class="form-control bootstrap-switch sel_search">
					</label>
				</div>
				<div class="col-3">
					<label for="" class="control-label">Por Rango
						<input type="radio"
								name="sel_Search" 
								id="sel_range"
								data-on-label="SI" data-off-label="NO" 
								class="form-control bootstrap-switch sel_search">
					</label>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-2"></div>
				<div class="col-1">
					<div class="form-group">
						<label class="control-label">Referencia</label>
					</div>
				</div>
				<div class="col-7">
					<div class="form-group">
						<input type="text" class="form-control"
								v-model="data.reference">
					</div>
				</div>
				<div class="col-2"></div>
				<br>
				<div class="col-2"></div>
				<div class="col-1">
					<div class="form-group">
						<label class="control-label">Generado por</label>
					</div>
				</div>
				<div class="col-7">
					<div class="form-group">
						<select2 :options="OptionMonths" v-model="data.origin"></select2>
					</div>
				</div>
				<div class="col-2"></div>
				<br>

				<div class="col-2"></div>
				<div class="col-2">
					<div class="form-group">
						<label class="control-label">Fecha de emisión</label>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<select2 :options="OptionMonths" v-model="data.origin_init"></select2>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<select2 :options="OptionsYears" v-model="data.origin_end"></select2>
					</div>
				</div>
				<div class="col-2"></div>

				<div class="col-3">
					<label for="" class="control-label">Por Período
						<input type="radio" 
								name="sel_Search"
								id="sel_ref"
								data-on-label="SI" data-off-label="NO" 
								class="form-control bootstrap-switch sel_search">
					</label>
				</div>
				<div class="col-3">
					<label for="" class="control-label">Por Mes
						<input type="radio"
								name="sel_Search" 
								id="sel_origin"
								data-on-label="SI" data-off-label="NO" 
								class="form-control bootstrap-switch sel_search">
					</label>
				</div>
			</div>
			<!-- <div v-if="typeSearch == 'reference'" class="row">
				<div class="col-3"></div>
				<div class="col-5">
					<div class="form-group">
						<label class="control-label">Referencia</label>
						<input type="text" class="form-control"
								v-model="data.reference">
					</div>
				</div>
			</div>
			<div v-if="typeSearch == 'origin'">
					
			</div>
			<div v-if="typeSearch == 'range'">
					
			</div> -->
			
			<!-- <div class="form-group">
				<label class="control-label">Referencia</label>
				<input type="text" class="form-control">
			</div> -->
		</form>
	</div>
</template>

<script>
	export default{
		data(){
			return {
				typeSearch:'', //states: 'reference', 'origin', 'range'
				data:{
					reference:'',
					origin:'',
					origin_init:0,
					origin_end:0,
				},
				OptionMonths:[
					{id:0, text:'Todos'},
					{id:1, text:'Enero'},
					{id:2, text:'Febrero'},
					{id:3, text:'Marzo'},
					{id:4, text:'Abril'},
					{id:5, text:'Mayo'},
					{id:6, text:'Junio'},
					{id:7, text:'Julio'},
					{id:8, text:'Agosto'},
					{id:9, text:'Septiembre'},
					{id:10, text:'Octubre'},
					{id:11, text:'Noviembre'},
					{id:12, text:'Diciembre'}
				],
				OptionsYears:[],
			}
		},
		created(){
			this.CalculateOptionsYears();
		},
		mounted(){
						/** 
			 * Evento para determinar los datos a requerir segun la busqueda seleccionada
			 */
			const vm = this;
			$('.sel_search').on('switchChange.bootstrapSwitch', function(e) {
				if (e.target.id === "sel_ref") {
					vm.typeSearch = 'reference';
				}
				else if (e.target.id === "sel_origin") {
					vm.typeSearch = 'origin';
				}
				else if (e.target.id === "sel_range") {
					vm.typeSearch = 'range';
				}
			});
		},
		methods:{
			CalculateOptionsYears:function(){
				var date = new Date();
				this.OptionsYears.push({
					id:0,
					text:'Todos'
				});
				for (var year = 2007; year <= date.getFullYear(); year++) {
					this.OptionsYears.push({
						id:year,
						text:year
					});
				}
			},
		},
	}
</script>