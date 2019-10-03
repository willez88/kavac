<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">
					Registros Comúnes
					@include('buttons.help', ['helpId' => 'CommonRegs', 'helpSteps' => [
						[
							'element' => '#helpDocStatus',
							'intro' => 'Gestiona información acerca de los estados de los documentos dentro de los procesos del sistema'
						],
						[
							'element' => '#helpMaritalStatus',
							'intro' => 'Gestiona información acerca de los estados civiles de las personas'
						],
						[
							'element' => '#helpProfessions',
							'intro' => 'Gestiona información acerca de las distintas profesiones a utilizar en registros de la aplicación'
						],
						[
							'element' => '#helpInstitutionTypes',
							'intro' => 'Gestiona información acerca de los distintos tipos de instituciones'
						],
						[
							'element' => '#helpInstitutionSectors',
							'intro' => 'Gestiona información acerca de los sectores a los cuales pertenecen las instituciones'
						],
						[
							'element' => '#helpCountries',
							'intro' => 'Gestiona información sobre los Países del mundo'
						],
						[
							'element' => '#helpEstates',
							'intro' => 'Gestiona información acerca de los Estados pertenecientes a los diferentes Países del mundo'
						],
						[
							'element' => '#helpMunicipalities',
							'intro' => 'Gestiona información acerca de los Municipios pertenecientes a los diferentes Estados'
						],
						[
							'element' => '#helpParishes',
							'intro' => 'Gestiona información acerca de las Parroquias pertenecientes a los diferentes Municipios'
						],
						[
							'element' => '#helpCities',
							'intro' => 'Gestiona información acerca de las Ciudades pertenecientes a los diferentes Estados'
						],
						[
							'element' => '#helpCurrencies',
							'intro' => 'Gestiona información acerca de los tipos de moneda bajo los cuales se podrá gestionar información del sistema'
						],
						[
							'element' => '#helpExchangeRates',
							'intro' => 'Gestiona información acerca del tipo de cambio entre monedas. Esta opción solo se habilita siempre y cuando exista más de una moneda registrada'
						],
						[
							'element' => '#helpTaxes',
							'intro' => 'Gestiona información acerca de los diferentes impuestos a aplicar en los registros del sistema'
						],
						[
							'element' => '#helpTaxUnits',
							'intro' => 'Gestiona información acerca de las Unidades Tributarias (U.T.) disponibles por el sistema'
						],
						[
							'element' => '#helpDeductions',
							'intro' => 'Gestiona información acerca de las distintas deducciones a aplicar en registros del sistema'
						],
						[
							'element' => '#helpMeasurementUnits',
							'intro' => 'Gestiona información acerca de las unidades de medida'
						],
						[
							'element' => '#helpDepartments',
							'intro' => 'Gestiona información acerca de los departamentos de las instituciones'
						]
					]])
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
