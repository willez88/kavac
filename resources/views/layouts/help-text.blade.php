{{-- Plantilla para textos de ayuda (generales) en formularios --}}
@if (isset($codeSetting))
	<hr>
	<div class="row">
		<div class="col-12">
			<span class="form-text">
				<strong>{{ __('Formato') }}:</strong> {{ __('prefijo-digitos-año') }}
				<ul>
					<li>{{ __('prefijo (requerido): 1 a 3 carácteres') }}</li>
					<li>{{ __('digitos (requerido): 4 carácteres (mínimo), 8 carácteres (máximo)') }}</li>
					<li>{{ __('año (requerido): 2 o 4 caracteres (YY o YYYY)') }}</li>
				</ul>
				<strong>{{ __('Longitud total máxima') }}:</strong> {{ __('20 carácteres') }}<br>
				<strong>{{ __('Ej.') }}</strong> XXX-000000000-YYYY
			</span>
		</div>
	</div>
@endif
