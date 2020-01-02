{!! Form::button('<i class="fa fa-trash-o"></i>', [
	'class' => 'btn btn-danger btn-xs btn-icon btn-action',
	'data-toggle' => 'tooltip', 'type' => 'button', 'onclick' => "delete_record('$route')",
	'title' => __('Eliminar registro')
]) !!}
