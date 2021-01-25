{{-- Plantilla para textos de ayuda (generales) en formularios --}}
@if (isset($codeSetting))
	<hr>
	<div class="row">
		<div class="col-12">
			<span class="form-text">
				<strong>{{ __('Formato') }}:</strong> {{ __('prefijo-digitos-año') }}
				<ul>
					<li>{{ __('Prefijo (requerido): 1 a 3 caracteres') }}</li>
					<li>{{ __('Dígitos (requerido): 4 caracteres (mínimo), 8 caracteres (máximo)') }}</li>
					<li>{{ __('Año (requerido): 2 o 4 caracteres (YY o YYYY)') }}</li>
				</ul>
				<strong>{{ __('Longitud total máxima') }}:</strong> {{ __('20 caracteres') }}<br>
				<strong>{{ __('Ej.') }}</strong> XXX-00000000-YYYY
			</span>
		</div>
	</div>
@endif
