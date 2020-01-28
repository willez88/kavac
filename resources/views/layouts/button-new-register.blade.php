<div class="row">
	<div class="col-12">
		<a href="{{ $url ?? 'javascript:void(0)' }}"
		   class="btn btn-sm btn-primary btn-custom float-right"
		   title="{{ __('Crear nuevo registro') }}" data-toggle="tooltip">
			<i class="fa fa-plus-circle"></i>
			<span>{{ $btnText ?? __('Nuevo') }}</span>
		</a>
	</div>
</div>
