@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	Configuración
@stop

@section('maproute-title')
	Configuración
@stop

@section('content')
	@include('admin.settings-parameters')
	@include('admin.settings-commons')
	{{-- @include('admin.setting-modules') --}}
	@include('admin.setting-institution')
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