@extends('layouts.app')

@section('maproute-icon')
	<i class="ion-settings"></i>
@stop

@section('maproute-icon-mini')
	<i class="ion-settings"></i>
@stop

@section('maproute-actual')
	{{ __('Configuración') }}
@stop

@section('maproute-title')
	{{ __('Configuración') }}
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
	            'title': '{{ __('Organización activa?') }}',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#retention_agent').closest('.bootstrap-switch-wrapper').attr({
	            'title': '{{ __('Es agente de retención de impuestos?') }}',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#support').closest('.bootstrap-switch-wrapper').attr({
	            'title': '{{ __('Activar la comunicación con soporte técnico') }}',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#chat').closest('.bootstrap-switch-wrapper').attr({
	            'title': '{{ __('Activar la comunicación por chat interno') }}',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#notify').closest('.bootstrap-switch-wrapper').attr({
	            'title': '{{ __('Activar las notificaciones del sistema') }}',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#report_banner').closest('.bootstrap-switch-wrapper').attr({
	            'title': '{{ __('Incluir imagen de banner en reportes') }}',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#multi_institution').closest('.bootstrap-switch-wrapper').attr({
	            'title': '{{ __('Activar gestión administrativa para el uso con multiples organizaciones') }}',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#digital_sign').closest('.bootstrap-switch-wrapper').attr({
	            'title': '{{ __('Activar firma electrónica para todos los procesos del sistema?') }}. ' +
                         '{{ __('Requiere conexión externa') }}.',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
	        $('#online').closest('.bootstrap-switch-wrapper').attr({
	            'title': '{{ __('Establecer la aplicación en modo de mantenimiento') }}. ' +
	            		 '{{ __('Ningún usuario podrá acceder a la aplicación mientras esta opción este activa') }}. ' +
	            		 '{{ __('Solo usuarios autorizados podrán acceder mientras este en modo mantenimiento') }}.',
	            'data-toggle': 'tooltip'
	        }).tooltip({delay: 4});
		});
	</script>
@endsection
