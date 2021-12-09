{{-- Ventana modal que muestra el mensaje de espera en la carga de datos --}}
<section class="preloader" style="z-index: 99999">
	<div class="preloader-content">
		<p class="text-center">{{ __('Su petición se está cargando. Por favor espere') }}</p>
		<div class="lds-css ng-scope">
			<div style="width:100%;height:100%" class="lds-double-ring">
				<div></div>
				<div></div>
				<div>
					<div></div>
				</div>
				<div>
					<div></div>
				</div>
			</div>
		</div>
	</div>
</section>
