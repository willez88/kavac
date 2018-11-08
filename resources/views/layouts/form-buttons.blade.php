@if (!isset($hide_clear) || !$hide_clear)
	{!! Form::button('<i class="fa fa-eraser"></i>', [
		'class' => 'btn btn-default btn-icon btn-round', 'data-toggle' => 'tooltip', 'type' => 'reset',
		'title' => 'Borrar datos del formulario',
	]) !!}
@endif
@if (!isset($hide_previous) || !$hide_previous)
{!! Form::button('<i class="fa fa-ban"></i>', [
	'class' => 'btn btn-warning btn-icon btn-round', 'data-toggle' => 'tooltip', 'type' => 'button',
	'title' => 'Cancelar y regresar', 'onclick' => 'window.location.href="' . url()->previous() . '"',
]) !!}
@endif
@if (!isset($hide_save) || !$hide_save)
	{!! Form::button('<i class="fa fa-save"></i>', [
		'class' => 'btn btn-success btn-icon btn-round', 'data-toggle' => 'tooltip',
		'id' => 'save','title' => 'Guardar registro', 'type' => 'submit'
	]) !!}
@endif