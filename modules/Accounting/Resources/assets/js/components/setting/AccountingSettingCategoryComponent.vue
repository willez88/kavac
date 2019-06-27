<template>

<div class="row">
	<div class="alert alert-warning col-12" role="alert" v-if="warnings.length > 0">
		<div class="container">
			<div class="alert-icon">
				<i class="now-ui-icons objects_support-17"></i>
			</div>
			<strong>Atención!</strong>
			<ul>
				<li v-for="warning in warnings">{{ warning }}</li>
			</ul>
		</div>
	</div>
	<table class="table table-striped col-5" style="margin-top: 2rem; margin-left: 5rem;">
		<thead>
			<tr>
				<td><strong>NOMBRE</strong></td>
				<td><strong>ACRÓNIMO</strong></td>
				<td><strong>ACCIÓN</strong></td>
			</tr>
		</thead>
		<tbody>
			<tr v-for="record in records">
				<td>{{ record.name }}</td>
				<td>{{ record.acronym }}</td>
				<td>
					<button class="btn btn-warning btn-xs btn-icon"
							title="Actualizar Registro"
							data-toggle="tooltip"
							@click="loadCategory(record)"><i class="fa fa-edit"></i>
					</button>
					<button class="btn btn-danger btn-xs btn-icon"
							title="Eliminar Registro"
							data-toggle="tooltip"
							@click="deleteRecord(records.indexOf(record)+1,'/accounting/settings/categories')">
						<i class="fa fa-trash"></i>
					</button>
					
				</td>
			</tr>
		</tbody>
	</table>
	<form @submit.prevent="" class="form-horizontal col-5" style="margin-left: 3rem;">
		<div class="card-body">
			<div class="row">
				<div class="form-group col-12 is-required">
					<label class="control-label">Nombre</label>
					<input type="text"
							class="form-control"
							title="Nombre de la nueva categoria de origen"
							data-toggle="tooltip"
							v-model="NewCategory.name">
				</div>
				<div class="form-group col-12 is-required">
					<label class="control-label">Acrónimo</label>
					<input type="text"
							class="form-control"
							title="Acrónimo"
							data-toggle="tooltip"
							v-model="NewCategory.acronym">
				</div>
			</div>
		</div>
		<div class="card-footer" align="right">
			<div class="form-group">
				<button class="btn btn-success btn-xs" 
						title="Guardar registro"
						data-toggle="tooltip"
						style="margin-top: 1.3rem !important;" 
						:disabled="NewCategory.name=='' || NewCategory.acronym==''"
						@click="storeCategory()"
						v-if="state == 'store'">Guardar
				</button>
				<button class="btn btn-success btn-xs" 
						title="Actualizar registro"
						data-toggle="tooltip"
						style="margin-top: 1.3rem !important;" 
						:disabled="NewCategory.name=='' || NewCategory.acronym==''"
						@click="updateCategory()"
						v-if="state == 'update'">Actualizar
				</button>
			</div>
		</div>
	</form>
</div>
</template>

<script>
export default{
	props:['categories'],
	data(){
		return{
			warnings:[],
			columns:['name','acronym','id'],
			records:[],
			NewCategory:{
				name:'',
				acronym:'',
			},
			state:'store'
		}
	},
	created(){
		this.table_options.headings = {
			'name': 'NOMBRE',
			'acronym': 'ACRÓNIMO',
			'id':'ACCIÓN'
		};
		this.records = this.categories;
	},
	methods:{
		/**
		* Valida información del formulario de categoria
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		* @param  {boolean} name bandera que establece si hay que validar el nombre de la categoria
		* @param  {boolean} acronym bandera que establece si hay que validar el acronimo de la categoria
		* @return {boolean} Devuelve falso si la información no es única
		*/
		validInformation(name=true , acronym=true){
			var jumpOne = (this.state == 'update') ? true : false;

			// verifica que no este repetida la información
			// en caso de estar actualizando se lo salta
			for (var i = 0; i < this.categories.length; i++) {
				if (acronym && this.NewCategory.acronym == this.categories[i].acronym) {
					if (jumpOne) {
						jumpOne = false;
						continue;
					}
					this.warnings = [];
					this.warnings.push('El acrónimo debe ser único.');
					return false;
				}
				if (name && this.NewCategory.name == this.categories[i].name) {
					if (jumpOne) {
						jumpOne = false;
						continue;
					}
					this.warnings = [];
					this.warnings.push('El nombre debe ser único.');
					return false;
				}
			}
			return true;
		},
		/**
		* Guarda la información de la nueva categoria
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		*/
		storeCategory(){
			if (!this.validInformation()) return;

			const vm = this;
			this.NewCategory.acronym = this.NewCategory.acronym.toUpperCase();
			axios.post('/accounting/settings/categories',this.NewCategory).then(response=>{
				this.records = response.data.records;
				this.NewCategory = {
					name:'',
					acronym:''
				};
				vm.showMessage('store');
			});
		},

		/**
		* Actualiza la información de la categoria
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		*/
		updateCategory(){
			if (!this.validInformation(false)) return;

			const vm = this;
			this.NewCategory.acronym = this.NewCategory.acronym.toUpperCase();
			axios.put('/accounting/settings/categories/'+this.NewCategory.id,this.NewCategory).then(response=>{
				this.records = response.data.records;
				this.NewCategory = {
					name:'',
					acronym:''
				};
				vm.state = 'store'; // se cambia el estado para mostrar el boton guardar
				vm.showMessage('update');
			});
		},

		/**
		* Carga la información de la categoria en el formulario
		*
		* @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
		*/
		loadCategory(record){
			this.NewCategory.id = record.id;
			this.NewCategory.name = record.name;
			this.NewCategory.acronym = record.acronym;
			this.state = 'update'; // se cambia el estado para mostrar el boton actualizar
		},
	}
}
</script>