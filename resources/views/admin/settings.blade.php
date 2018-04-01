@extends('layouts.app')

@section('maproute-icon')
	<i class="now-ui-icons ui-2_settings-90"></i>
@stop

@section('maproute-icon-mini')
	<i class="now-ui-icons ui-2_settings-90"></i>
@stop

@section('maproute-actual')
	Configuración
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	@include('admin.setting-institution')
	@include('admin.settings-parameters')
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					<h6 class="card-title">Módulos</h6>
					<div class="card-btns">
						<a href="#" class="card-minimize btn btn-card-action btn-round" title="Minimizar" 
						   data-toggle="tooltip">
	    					<i class="now-ui-icons arrows-1_minimal-up"></i>
	    				</a>
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Presupuesto</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Finanzas</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Compras</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Almacén</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Contabilidad</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Facturación</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="dash-box dash-box-warning">
								<div class="dash-box-icon">
									<i class="fa fa-download"></i>
								</div>
								<div class="dash-box-body">
									<img src="{{ asset('images/no-image.png') }}" class="img-fluid" alt="" style="min-height:100px">
									<br>
									<span class="dash-box-title">Cuentas por Cobrar</span>
								</div>
								<div class="dash-box-action">
									<button>Activar</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer"></div>
			</div>
		</div>
	</div>
@stop

@section('extra-js')
	@parent
	<script>
		$(document).ready(function() {
			$('#active').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Institución activa?',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#retention_agent').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Es agente de retención de impuestos?',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#support').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Activar la comunicación con soporte técnico',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#chat').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Activar la comunicación por chat interno',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#notify').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Activar las notificaciones del sistema',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#report_banner').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Incluir imagen de banner en reportes',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#multi_institution').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Activar gestión administrativa para el uso con multiples instituciones',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#digital_sign').closest('.bootstrap-switch-wrapper').attr({
	            'title': 'Activar firma electrónica para todos los procesos del sistema?. Requiere conexión externa.',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
		});
	</script>
@endsection