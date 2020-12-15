<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">
					{{ __('Registros Comúnes') }}
					@include('buttons.help', [
						'helpId' => 'CommonRegs',
						'helpSteps' => get_json_resource('ui-guides/common_settings.json')
					])
				</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					{{-- Configuración de estatus de documentos --}}
					<document-status id="helpDocStatus"></document-status>
					{{-- Configuración de estados civiles --}}
					<marital-status id="helpMaritalStatus"></marital-status>
					{{-- Configuración de profesiones --}}
					<professions id="helpProfessions"></professions>
					{{-- Configuración de tipos de institución --}}
					<institution-types id="helpInstitutionTypes"></institution-types>
					{{-- Configuración de sectores de instituciones --}}
					<institution-sectors id="helpInstitutionSectors"></institution-sectors>
					{{-- Configuración de Países --}}
					<countries id="helpCountries"></countries>
					{{-- Configuración de Estados --}}
					<estates id="helpEstates"></estates>
                    {{-- Configuración de Municipios --}}
					<municipalities id="helpMunicipalities"></municipalities>
                    {{-- Configuración de Parroquias --}}
					<parishes id="helpParishes"></parishes>
                    {{-- Configuración de Ciudades --}}
					<cities id="helpCities"></cities>
                    {{-- Configuración de monedas --}}
					<currencies id="helpCurrencies"></currencies>
					@if (App\Models\Currency::all()->count() > 1)
                        {{-- Configuración de tipos de cambio --}}
						<exchange-rates id="helpExchangeRates"></exchange-rates>
					@endif
                    {{-- Configuración de impuestos --}}
					<taxes id="helpTaxes"></taxes>
                    {{-- Configuración de unidades tributarias --}}
					<tax-units id="helpTaxUnits"></tax-units>
                    {{-- Configuración de deducciones / retenciones --}}
					<deductions id="helpDeductions"
								:accounting-account={{ json_encode(Module::has('Accounting') ? true : false) }}></deductions>
                    {{-- Configuración de unidades de medida --}}
					<measurement-units id="helpMeasurementUnits"></measurement-units>
					@if (!App\Models\Institution::all()->isEmpty())
                        {{-- Configuración de departamentos --}}
						<departments id="helpDepartments"></departments>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
