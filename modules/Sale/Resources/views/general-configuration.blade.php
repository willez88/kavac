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
					<sale-settings-charge-money></sale-settings-charge-money>
					<sale-settings-form-payment></sale-settings-form-payment>
					<sale-frecuencies></sale-frecuencies>
					<sale-goods-to-be-traded></sale-goods-to-be-traded>
				</div>
			</div>
		</div>
	</div>
</div>
