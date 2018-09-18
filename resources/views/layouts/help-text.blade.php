{{-- Plantilla para textos de ayuda (generales) en formularios --}}
@if (isset($codeSetting))
	<hr>
	<div class="row">
		<div class="col-12">
			<span class="form-text">
				<strong>Formato:</strong> prefijo-digitos-año
				<ul>
					<li>prefijo (opcional): 3 carácteres</li>
					<li>digitos (requerido): 4 carácteres (mínimo), 8 carácteres (máximo)</li>
					<li>año (opcional): 2 o 4 caracteres (YY o YYYY)</li>
				</ul>
				<strong>Longitud total máxima:</strong> 20 carácteres<br>
				<strong>Ej.</strong> XXX-000000000-YYYY
			</span>
		</div>
	</div>
@endif