{{-- Ventana modal que muestra el mensaje de espera en la carga de datos --}}
<div class="modal fade modal-loading" id="modal-loading" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm transparent-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Cargando Datos...</h5>
			</div>
			<div class="modal-body text-center">
				<p class="text-justify">Su petición se está cargando. Por favor espere</p>
				<img src="{{ asset('images/loader.gif') }}" alt="Cargando Datos" class="img-fluid">
			</div>
		</div>
	</div>
</div>