<div class="row">
	<div class="col-12">
		<div class="card" id="helpCodeSaleSettingForm">
			<div class="card-header">
				<h6 class="card-title">Configuración General
					@include('buttons.help', [
					    'helpId' => 'SaleCodeSettingForm',
					    'helpSteps' => get_json_resource('ui-guides/settings/code_setting.json', 'sale')
			    	])
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					{{-- Configuración de Lista de subservicios--}}
					<sale-list-subservices-method></sale-list-subservices-method>
				</div>
			</div>
		</div>
	</div>
</div>