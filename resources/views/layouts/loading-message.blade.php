{{-- Ventana modal que muestra el mensaje de espera en la carga de datos --}}
{{-- <div class="modal fade modal-loading" id="modal-loading" role="dialog" data-backdrop="static" data-keyboard="false" v-if="loading">
	<div class="modal-dialog modal-sm transparent-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Cargando Datos...</h5>
			</div>
			<div class="modal-body text-center">
				<p class="text-justify">Su petición se está cargando. Por favor espere</p>
				<img src="{{ asset('images/loader.gif', Request::secure()) }}" alt="Cargando Datos" class="img-fluid">
			</div>
		</div>
	</div>
</div> --}}
<section class="preloader" style="z-index: 99999">
	<div class="preloader-content">
		<p class="text-center">{{ __('Su petición se está cargando. Por favor espere') }}</p>
		{{--<img src="{{ asset('images/loader.gif', Request::secure()) }}" alt="Cargando Datos" class="img-fluid">--}}
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
