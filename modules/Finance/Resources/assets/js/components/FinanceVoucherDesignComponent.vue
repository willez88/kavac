<template>
	<div class="row">
		<div class="col-8">
			<h6 class="text-center">Diseño</h6>
		</div>
		<div class="col-4">
			<h6 class="text-center">Herramientas</h6>
			<div class="row mt10">
				<div class="col-12">
					<hr>
					<h6>Página</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-12">
					<div class="form-group">
						<label for="">
                			Valores por defecto
                    		<input type="checkbox" class="form-control bootstrap-switch" 
                    			   data-toggle="tooltip" data-on-label="SI" data-off-label="NO" 
                    			   title="Configurar valores por defecto" 
								   v-model.lazy="record.default" value="AP" data-record="default">
                		</label>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group is-required">
						<label for="">Tamaño</label>
						<select2 :options="page_sizes" v-model="record.page_size"></select2>
					</div>
				</div>
			</div>
			<div class="row" v-if="record.page_size === 'P'">
				<div class="col-4">
					<div class="form-group is-required">
						<label for="">Ancho</label>
						<input type="text" class="form-control input-sm">
					</div>
				</div>
				<div class="col-2" style="padding:25px;">
					<span>X</span>
				</div>
				<div class="col-4">
					<div class="form-group is-required">
						<label for="">Alto</label>
						<input type="text" class="form-control input-sm">
					</div>
				</div>
			</div>
			<div class="row mt10">
				<div class="col-12">
					<hr>
					<h6>Componentes</h6>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="">Logo</label>
						<div class="col-12">
							<img src="/images/no-image.png" alt="logo" class="img-fluid img-rounded">
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="">Cheque</label>
						<div class="col-12">
							<img src="/images/formato-cheque.png" alt="logo" class="img-fluid img-rounded">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="">Datos Presupuestarios</label>
						<div class="col-12">
							<img src="/images/voucher-presupuesto.png" alt="logo" class="img-fluid img-rounded">
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="">Datos Contables</label>
						<div class="col-12">
							<img src="/images/voucher-contabilidad.png" alt="logo" class="img-fluid img-rounded">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="">Datos Voucher</label>
						<div class="col-12">
							<img src="/images/voucher-data.png" alt="logo" class="img-fluid img-rounded">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				record: {
					default: false,
					page_size: '',
					personalized_size: ''
				},
				page_sizes: [
					{id: '', text: 'Seleccione...'},
					{id: 'C', text: 'Carta [21,59 cm x 27,94 cm]'},
					{id: 'L', text: 'Legal [21,59 cm x 35,56 cm]'},
					{id: 'O', text: 'Oficio [21,59 cm x 33,02 cm]'},
					{id: 'T', text: 'Tabloide [27,94 cm x 43,18 cm]'},
					{id: 'B6', text: 'B6 [12,80 cm x 12,20 cm]'},
					{id: 'B5', text: 'B5 [18,20 cm x 25,70 cm]'},
					{id: 'B4', text: 'B4 [25,70 cm x 36,40 cm]'},
					{id: 'P', text: 'Personalizado'},
				]
			}
		},
		watch: {
			
		},
		methods: {
		},
		created() {
			
		},
	};
</script>