$(document).ready(function() {
	/** Tooltip para opciones de la barra de navegación superior */
	$('.dropdown-toggle').tooltip();
	$('.dropdown-toggle').on('click', function() {
		$('.tooltip:last').remove();
		$(this).tooltip();
	});

	/** Acciones del menu izquierdo */
	$('.menu-collapse').click(function() {
      if (!$('body').hasClass('hidden-left')) {
         if ($('.container-left').hasClass('collapsed')) {
            $('.container-left, .content-wrapper').removeClass('collapsed');
            $(this).find('i').removeClass('arrows-1_minimal-right');
            $(this).find('i').addClass('arrows-1_minimal-left');
            $('.menu-option').removeClass('text-center');
            $('.menu-option a i').removeClass('fa-2x');
            $('.menu-option a span').show();
         } else {
            $('.container-left, .content-wrapper').addClass('collapsed');
            $(this).find('i').removeClass('arrows-1_minimal-left');
            $(this).find('i').addClass('arrows-1_minimal-right');
            $('.children').hide(); // hide sub-menu if leave open
            $('.menu-option').addClass('text-center');
            $('.menu-option a i').addClass('fa-2x');
            $('.menu-option a span').hide();
         }
      } else {
         if (!$('body').hasClass('show-left')) {
            $('body').addClass('show-left');
         } else {
            $('body').removeClass('show-left');
         }
      }
      return false;
   });


	$('.btn-card-action').attr('style', 'background:transparent;color:#2CA8FF');

	$('select').select2();

	/*$('.card-header').hover(function() {
    	$(this).find('.card-btns').fadeIn('fast');
    }, function() {
    	$(this).find('.card-btns').fadeOut('fast');
    });*/

    // Close card
    $('.card .card-close').click(function() {
    	$(this).closest('.card').fadeOut(200);
    	return false;
    });

    // Minimize Panel
    $('.card .card-minimize').click(function(){
    	var t = $(this);
    	var p = t.closest('.card');
    	$('.tooltip:last').remove();
    	
    	if(!$(this).hasClass('maximize')) {
    		p.find('hr').addClass('nodisplay');
    		p.find('.card-body, .card-footer').slideUp(400);
    		t.addClass('maximize');
    		t.find('i').removeClass('arrows-1_minimal-up').addClass('arrows-1_minimal-down');
    		$(this).attr('data-original-title','Maximize Panel').tooltip();
    	} else {
    		p.find('hr').removeClass('nodisplay');
    		p.find('.card-body, .card-footer').slideDown(400);
        	t.removeClass('maximize');
        	t.find('i').removeClass('arrows-1_minimal-down').addClass('arrows-1_minimal-up');
        	$(this).attr('data-original-title','Minimize Panel').tooltip();
        }

        return false;
    });

    // Sliders for demo purpose in refine cards section
    var slider = document.getElementById('sliderRegular');
    noUiSlider.create(slider, {
    	start: 40,
    	connect: [true, false],
    	range: {
    		min: 0,
    		max: 100
    	}
    });

    var slider2 = document.getElementById('sliderDouble');
    noUiSlider.create(slider2, {
    	start: [20, 60],
    	connect: true,
    	range: {
    		min: 0,
    		max: 100
    	}
    });
});