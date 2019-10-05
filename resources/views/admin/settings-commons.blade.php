<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">
					Registros Comúnes
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
					<municipalities id="helpMunicipalities"></municipalities>
					<parishes id="helpParishes"></parishes>
					<cities id="helpCities"></cities>
					<currencies id="helpCurrencies"></currencies>
					@if (App\Models\Currency::all()->count() > 1)
						<exchange-rates id="helpExchangeRates"></exchange-rates>
					@endif
					<taxes id="helpTaxes"></taxes>
					<tax-units id="helpTaxUnits"></tax-units>
					<deductions id="helpDeductions"
								:accounting-account={{ json_encode(Module::has('Accounting') ? true : false) }}></deductions>
					<measurement-units id="helpMeasurementUnits"></measurement-units>
					<!--<div class="col-md-2 text-center">
						<a class="btn-simplex btn-simplex-md btn-simplex-primary"
						   href="#" title="Registros de Deducciones o Retenciones"
						   data-toggle="tooltip">
							<i class="icofont icofont-scroll-long-down ico-3x"></i>
							<span>Deducciones</span>
						</a>
					</div>-->
					@if (!App\Models\Institution::all()->isEmpty())
						<departments id="helpDepartments"></departments>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
