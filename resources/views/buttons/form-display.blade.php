<div class="btn-display">
	{!! Form::button('<i class="fa fa-eraser"></i>', [
		'class' => 'btn btn-default btn-icon btn-round', 'data-toggle' => 'tooltip', 'type' => 'reset',
		'title' => 'Borrar datos del formulario', 'id' => 'btn_reset'
	]) !!}
	{!! Form::button('<i class="fa fa-ban"></i>', [
		'class' => 'btn btn-warning btn-icon btn-round', 'data-toggle' => 'tooltip', 'type' => 'button',
		'title' => 'Cancelar y regresar', 'onclick' => 'window.location.href="' . url()->previous() . '"', 'id' => 'btn_cancel'
	]) !!}
	{!! Form::button('<i class="fa fa-save"></i>', [
		'class' => 'btn btn-success btn-icon btn-round', 'data-toggle' => 'tooltip',
		'id' => 'save','title' => 'Guardar registro', 'type' => 'submit', 'id' => 'btn_save'
	]) !!}
</div>

<script>
	$(document).ready(function() {
		$(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                $('.btn-display').fadeIn();
            }
            else {
                $('.btn-display').fadeOut();
            }
        });
	});
</script>