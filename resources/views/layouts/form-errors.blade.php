{{-- Mensajes de error --}}
@if ($errors->any())
	<div class="alert alert-danger" role="alert">
		<div class="container">
			<div class="alert-icon">
				<i class="now-ui-icons objects_support-17"></i>
			</div>
			<strong>{{ __('Cuidado!') }}</strong> {{ __('Debe verificar los siguientes errores antes de continuar') }}:
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">
					<i class="now-ui-icons ui-1_simple-remove"></i>
				</span>
			</button>
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	</div>
@endif
