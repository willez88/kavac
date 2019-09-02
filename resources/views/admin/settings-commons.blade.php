<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<h6 class="card-title">Registros Comúnes</h6>
				<div class="card-btns">
					@include('buttons.previous', ['route' => url()->previous()])
					@include('buttons.minimize')
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					{{-- Configuración de estatus de documentos --}}
					<document-status></document-status>
					{{-- Configuración de estados civiles --}}
					<marital-status></marital-status>
					{{-- Configuración de profesiones --}}
					<professions></professions>
					{{-- Configuración de tipos de institución --}}
					<institution-types></institution-types>
					{{-- Configuración de sectores de instituciones --}}
					<institution-sectors></institution-sectors>
					{{-- Configuración de Países --}}
					<countries></countries>
					{{-- Configuración de Estados --}}
					<estates></estates>
					<municipalities></municipalities>
					<parishes></parishes>
					<cities></cities>
					<currencies></currencies>
					<taxes></taxes>
					<tax-units></tax-units>
					<measurement-units></measurement-units>
					<!--<div class="col-md-2 text-center">
						<a class="btn-simplex btn-simplex-md btn-simplex-primary"
						   href="#" title="Registros de Deducciones o Retenciones"
						   data-toggle="tooltip">
							<i class="icofont icofont-scroll-long-down ico-3x"></i>
							<span>Deducciones</span>
						</a>
					</div>-->
					@if (App\Models\Institution::all()->isEmpty())
						<departments></departments>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
