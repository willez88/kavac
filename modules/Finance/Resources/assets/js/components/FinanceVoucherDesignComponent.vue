<template>
	<div class="container">
		<div class="row">
			<div class="col-7 pad-top-20 with-border with-radius">
				<h6 class="text-center">Diseño</h6>
				<div class="container">
					<div class="row mt10">
						<div class="col-12">
							<div class="with-border with-shadow vertical-middle" 
								 :style="{
								 	'width':  record.page.size_custom.width + 'px', 
								 	'height': (record.page.size_custom.height / 1.5) + 'px',
								 	'max-width': '100%'
								 }" 
								 v-if="record.page.size_custom.width !== '0' && record.page.size_custom.height !== '0'">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-4 offset-1 pad-top-20 with-border with-radius">
				<h6 class="text-center">Herramientas</h6>
				<div class="row mt10">
					<div class="col-12">
						<hr>
						<h6>Página</h6>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group bootstrap-switch-mini">
							<label>Valores por defecto</label>
	                		<div class="col-12">
	                			<input type="checkbox" class="form-control bootstrap-switch bootstrap-switch-mini" 
	                    			   data-toggle="tooltip" data-on-label="SI" data-off-label="NO" 
	                    			   title="Configurar valores por defecto" name="default"
									   v-model.lazy="record.default" value="AP" data-record="default">
	                		</div>
						</div>
					</div>
					<div class="col-12">
						<div class="form-group is-required">
							<label for="">Tamaño</label>
							<select2 :options="page_sizes" v-model="record.page.size" 
									 @input="setSizes"></select2>
						</div>
					</div>
				</div>
				<div class="row" v-if="record.page.size === 'P'">
					<div class="col-4">
						<div class="form-group is-required">
							<label for="">Ancho</label>
							<input type="text" class="form-control input-sm" 
								   v-model="record.page.size_custom.width" data-toggle="tooltip"
								   title="Ancho de la página en milimetros">
						</div>
					</div>
					<div class="col-2" style="padding:25px;">
						<span>X</span>
					</div>
					<div class="col-4">
						<div class="form-group is-required">
							<label for="">Alto</label>
							<input type="text" class="form-control input-sm" 
								   v-model="record.page.size_custom.height" data-toggle="tooltip"
								   title="Alto de la página en milimetros">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label for="">Margénes (en mm)</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4 offset-4">
						<div class="form-group is-required">
							<input type="number" class="form-control input-sm" step="0.01" 
								   title="margén superior en milímetros" data-toggle="tooltip" v-model="record.page.margins.top">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4">
						<div class="form-group is-required">
							<input type="number" class="form-control input-sm" step="0.01" 
								   title="margén izquierdo en milímetros" data-toggle="tooltip" v-model="record.page.margins.left">
						</div>
					</div>
					<div class="col-4 offset-4">
						<div class="form-group is-required">
							<input type="number" class="form-control input-sm" step="0.01" 
								   title="margén derecho en milímetros" data-toggle="tooltip" v-model="record.page.margins.right">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-4 offset-4">
						<div class="form-group is-required">
							<input type="number" class="form-control input-sm" step="0.01" 
								   title="margén inferior en milímetros" data-toggle="tooltip" v-model="record.page.margins.bottom">
						</div>
					</div>
				</div>
				<div class="row mt10">
					<div class="col-12">
						<hr>
						<h6>Layouts</h6>
					</div>
				</div>
				<div class="row">
					<div class="col-2">
						<div class="form-group">
							<label for="">1 fila</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-1-row">
									<i class="fa fa-square" style="font-size:8px"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="form-group">
							<label for="">2 filas</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-2-row">
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="form-group">
							<label for="">3 filas</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-3-row">
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="form-group">
							<label for="">4 filas</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-4-row">
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="form-group">
							<label for="">5 filas</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-5-row">
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-2">
						<div class="form-group">
							<label for="">6 filas</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-6-row">
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i><br>
									<i class="fa fa-square" style="font-size:8px"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="">1 columna</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-1-col">
									<i class="fa fa-square" style="font-size:8px"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="">2 columnas</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-2-col">
									<i class="fa fa-square" style="font-size:8px"></i>
									<i class="fa fa-square" style="font-size:8px;margin-left:5px;"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="">3 columnas</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;line-height: .3" id="layout-3-col">
									<i class="fa fa-square" style="font-size:8px"></i>
									<i class="fa fa-square" style="font-size:8px;margin-left:5px;"></i>
									<i class="fa fa-square" style="font-size:8px;margin-left:5px;"></i>
								</div>
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="">4 columnas</label>
							<div class="row">
								<div class="col-12" style="cursor:pointer;cursor:pointer;line-height: .3" id="layout-4-col">
									<i class="fa fa-square" style="font-size:8px"></i>
									<i class="fa fa-square" style="font-size:8px;margin-left:5px;"></i>
									<i class="fa fa-square" style="font-size:8px;margin-left:5px;"></i>
									<i class="fa fa-square" style="font-size:8px;margin-left:5px;"></i>
								</div>
							</div>
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
								<img src="/images/no-image.png" alt="logo" class="img-fluid img-rounded" 
									 style="cursor:pointer;">
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="">Cheque</label>
							<div class="col-12">
								<img src="/images/formato-cheque.png" alt="logo" class="img-fluid img-rounded" 
									 style="cursor:pointer;">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="">Datos Presupuestarios</label>
							<div class="col-12">
								<img src="/images/voucher-presupuesto.png" alt="logo" class="img-fluid img-rounded" 
									 style="cursor:pointer;">
							</div>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="">Datos Contables</label>
							<div class="col-12">
								<img src="/images/voucher-contabilidad.png" alt="logo" class="img-fluid img-rounded" 
									 style="cursor:pointer;">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label for="">Datos Voucher</label>
							<div class="col-12">
								<img src="/images/voucher-data.png" alt="logo" class="img-fluid img-rounded" 
									 style="cursor:pointer;">
							</div>
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
					page: {
						size: '',
						size_custom: {
							width: '',
							height: ''
						},
						margins: {
							top: '10',
							left: '10',
							right: '10',
							bottom: '10'
						}
					}
				},
				page_sizes: [
					{id: '', text: 'Seleccione...'},
					{id: 'C', text: 'Carta [215,90 mm x 279,40 mm]'},
					{id: 'L', text: 'Legal [215,90 mm x 355,60 mm]'},
					{id: 'O', text: 'Oficio [215,90 mm x 330,20 mm]'},
					{id: 'T', text: 'Tabloide [279,40 mm x 431,80 mm]'},
					{id: 'B6', text: 'B6 [128,00 mm x 122,00 mm]'},
					{id: 'B5', text: 'B5 [182,00 mm x 257,00 mm]'},
					{id: 'B4', text: 'B4 [257,00 mm x 364,00 mm]'},
					{id: 'P', text: 'Personalizado'},
				]
			}
		},
		watch: {
			
		},
		methods: {
			/**
			 * Inicializa los valores del formulario
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			clearForm() {
				this.record = {
					default: false,
					page: {
						size: '',
						size_custom: {
							width: '0',
							height: '0'
						},
						margins: {
							top: '10',
							left: '10',
							right: '10',
							bottom: '10'
						}
					}
				};
			},
			/**
			 * Establece el ancho y alto del voucher
			 *
			 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
			 */
			setSizes() {
				let vm = this;
				let sizes = [
					{type: '', width: '0', height: '0'},
					{type: 'C', width: '215.9', height: '279.4'},
					{type: 'L', width: '215.9', height: '355.6'},
					{type: 'O', width: '215.9', height: '330.2'},
					{type: 'T', width: '279.4', height: '431.8'},
					{type: 'B6', width: '128', height: '122'},
					{type: 'B5', width: '182', height: '257'},
					{type: 'B4', width: '257', height: '364'},
					{type: 'P', width: '0', height: '0'},
				];
				sizes.forEach(function(size) {
					if (size.type === vm.record.page.size) {
						vm.record.page.size_custom.width = vm.measure_converter(size.width, 'mm', 'px').number;
						vm.record.page.size_custom.height = vm.measure_converter(size.height, 'mm', 'px').number;
					}
				});
			}
		},
		created() {
			this.switchHandler('default');
		},
	};
</script>