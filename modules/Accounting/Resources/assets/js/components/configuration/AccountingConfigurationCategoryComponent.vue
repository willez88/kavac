<template>

<div>
	<div class="alert alert-warning" role="alert" v-if="warnings.length > 0">
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
	<form @submit.prevent="" class="row">
		<div class="form-group col-6 is-required">
			<label class="control-label">Nombre</label>
			<input type="text"
					class="form-control"
					title="Nombre de la nueva categoria de origen"
					v-model="NewCategory.name">
		</div>
		<div class="form-group col-6 is-required">
			<label class="control-label">Acrónimo</label>
			<input type="text"
					class="form-control"
					title="Acrónimo"
					v-model="NewCategory.acronym">
		</div>
		<div class="col-11"></div>
		<div class="col-1">
			<button class="btn btn-success btn-icon btn-round" 
					title="Guardar registro"
					:disabled="NewCategory.name=='' || NewCategory.acronym==''"
					@click="storeCategory()"
					v-if="state == 'store'"><i class="fa fa-save"></i>
			</button>
			<button class="btn btn-success btn-icon btn-round" 
					title="Actualizar registro"
					:disabled="NewCategory.name=='' || NewCategory.acronym==''"
					@click="updateCategory()"
					v-if="state == 'update'"
					><i class="fa fa-save"></i>
			</button>
		</div>
	</form>
	<br>
	<table class="table">
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
					<button class="btn btn-warning btn-xs btn-icon btn-round"
							@click="loadCategory(record)"><i class="fa fa-edit"></i>
					</button>
					<button class="btn btn-danger btn-xs btn-icon btn-round"
							@click="deleteRecord(records.indexOf(record)+1,'/accounting/settings/categories')">
						<i class="fa fa-trash"></i>
					</button>
					
				</td>
			</tr>
		</tbody>
	</table>
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
		storeCategory(){
			if (!this.validInformation()) return;

			const vm = this;
			axios.post('/accounting/settings/categories',this.NewCategory).then(response=>{
				this.records = response.data.records;
				this.NewCategory = {
					name:'',
					acronym:''
				};
				vm.showMessage('store');
			});
		},
		updateCategory(){
			if (!this.validInformation(false)) return;

			const vm = this;
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
		loadCategory(record){
			this.NewCategory.id = record.id;
			this.NewCategory.name = record.name;
			this.NewCategory.acronym = record.acronym;
			this.state = 'update'; // se cambia el estado para mostrar el boton actualizar
		},
	}
}
</script>