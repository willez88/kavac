<a id="back-to-top" href="#" class="btn btn-primary btn-md back-to-top" title="Ir al inicio de la página"
   data-toggle="tooltip" data-placement="top">
	<i class="fa fa-chevron-up"></i>
</a>

@section('extra-js')
    @parent
    <script>
    	$(document).ready(function() {
    		$(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('#back-to-top').fadeIn();
                }
                else {
                    $('#back-to-top').fadeOut();
                }
            });

            $('#back-to-top').click(function () {
                $('#back-to-top').tooltip('hide');
                $('body,html').animate({scrollTop: 0}, 300);
                return false;
            });
    	});
    </script>
@endsection
