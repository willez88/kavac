<div class="row">
	<div class="col-12 text-right">
		@if (isset($print))
			{!! Form::button('<i class="fa fa-print"></i>', [
				'class' => 'btn btn-sm btn-primary btn-custom', 'data-toggle' => 'tooltip', 'type' => 'button',
				'title' => __('Imprimir registro'), 'onclick' => (isset($print['action']))?$print['action']:'print()'
			]) !!}
		@endif
	</div>
</div>
