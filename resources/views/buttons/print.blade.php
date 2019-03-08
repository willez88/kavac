{!! Form::button('<i class="fa fa-print"></i>', [
	'class' => 'btn btn-sm btn-primary btn-custom', 'data-toggle' => 'tooltip', 'type' => 'button',
	'title' => 'Imprimir registro', 'onclick' => (isset($print['action']))?"print({$print['action']})":'print()'
]) !!}