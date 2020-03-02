<template>
	<div>
		<h6 class="card-title">
			Números Telefónicos <i class="fa fa-plus-circle cursor-pointer" @click="addPhone"></i>
		</h6>
		<div class="row" v-for="(phone, index) in phones">
			<div class="col-3">
				<div class="form-group is-required">
					<select data-toggle="tooltip" v-model="phone.type" name="phone_type[]" class="select2" 
							title="Seleccione el tipo de número telefónico">
						<option value="">Seleccione...</option>
						<option value="M">Móvil</option>
						<option value="T">Teléfono</option>
						<option value="F">Fax</option>
					</select>
				</div>
			</div>
			<div class="col-2">
				<div class="form-group is-required">
					<input type="text" placeholder="Cod. Area" data-toggle="tooltip" name="phone_area_code[]" 
						   title="Indique el código de área" v-model="phone.area_code" class="form-control input-sm">
				</div>
			</div>
			<div class="col-4">
				<div class="form-group is-required">
					<input type="text" placeholder="Número" data-toggle="tooltip" name="phone_number[]"
						   title="Indique el número telefónico" v-model="phone.number" class="form-control input-sm">
				</div>
			</div>
			<div class="col-2">
				<div class="form-group is-required">
					<input type="text" placeholder="Extensión" data-toggle="tooltip" name="phone_extension[]" 
						   title="Indique la extención telefónica (opcional)" v-model="phone.extension" 
						   class="form-control input-sm">
				</div>
			</div>
			<div class="col-1">
				<div class="form-group">
					<button class="btn btn-sm btn-danger btn-action" type="button" @click="removeRow(index, phones)" 
							title="Eliminar este dato" data-toggle="tooltip">
						<i class="fa fa-minus-circle"></i>
					</button>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				phones: [],
			}
		},
		watch: {
			phones: function() {
				localStorage.removeItem('phones');
				if (this.phones) {
					localStorage.phones = JSON.stringify(this.phones);
				}
			}
		},
		props: ['initial_data'],
		methods: {
			addPhone: function() {
				this.phones.push({
					type: '',
					area_code: '',
					number: '',
					extension: ''
				});
			},
		},
		mounted() {
			if (this.initial_data) {
				this.phones = JSON.parse(this.initial_data);
			}
		}
	};
</script>