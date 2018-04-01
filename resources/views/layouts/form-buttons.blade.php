{!! Form::button('<i class="fa fa-eraser"></i>', [
	'class' => 'btn btn-default btn-icon btn-round', 'data-toggle' => 'tooltip', 'type' => 'reset',
	'title' => 'Borrar datos del formulario',
]) !!}
{!! Form::button('<i class="fa fa-ban"></i>', [
	'class' => 'btn btn-warning btn-icon btn-round', 'data-toggle' => 'tooltip', 'type' => 'button',
	'title' => 'Cancelar y regresar', 'onclick' => 'window.location.href="' . url()->previous() . '"',
]) !!}
{!! Form::button('<i class="fa fa-save"></i>', [
	'class' => 'btn btn-success btn-icon btn-round', 'data-toggle' => 'tooltip',
	'title' => 'Guardar registro',
]) !!}