$(document).ready(function() {
	/** Tooltip para opciones de la barra de navegación superior */
	$('.dropdown-toggle').tooltip();
	$('.dropdown-toggle').on('click', function() {
		$('.tooltip:last').remove();
		$(this).tooltip();
	});

	/** Maximizar / minimizar panel de menú izquierdo */
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


    if ($('select').length) {
        /** Implementación del plugin selec2 para los elementos del DOM de tipo Select */
        $('select').select2();
    }

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
    		p.find('.card-body, .card-footer').fadeOut('fast');
    		t.addClass('maximize');
    		t.find('i').removeClass('arrows-1_minimal-up').addClass('arrows-1_minimal-down');
    		$(this).attr('data-original-title','Maximize Panel').tooltip();
    	} else {
    		p.find('hr').removeClass('nodisplay');
    		p.find('.card-body, .card-footer').fadeIn('fast');
        	t.removeClass('maximize');
        	t.find('i').removeClass('arrows-1_minimal-down').addClass('arrows-1_minimal-up');
        	$(this).attr('data-original-title','Minimize Panel').tooltip();
        }

        return false;
    });

    /** Implementación de sliders sencillos */
    if ($('#sliderRegular').length) {
        /** @type {Object} [Estilos personalizados para el uso de esliders] */
        var slider = document.getElementById('sliderRegular');
        noUiSlider.create(slider, {
            start: 40,
            connect: [true, false],
            range: {
                min: 0,
                max: 100
            }
        });
    }
    
    /** Implementación de sliders dobles */
    if ($('#sliderDouble').length) {
        var slider2 = document.getElementById('sliderDouble');
        noUiSlider.create(slider2, {
            start: [20, 60],
            connect: true,
            range: {
                min: 0,
                max: 100
            }
        });
    }

    /** Reemplazo de icono indicador en el menú del panel izquierdo */
    $('.submenu-indicator').html('<i class="ion-ios-arrow-left text-center"></i>');

    /** Acciones para ocultar los mensajes tooltip cuando se posiciona o se hace clic en otro elemento */
    $('a').on('hover, click', function() {
        $('.tooltip:last').remove();
        $('.tooltip:last').tooltip();
    });

    if ($('.datatable').length) {
        $.extend( $.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "form-control input-sm",
            "sLengthSelect": "input-sm select2",
        });
        dt_options = {
            "language": {
                //"url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                "processing":     "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "Lo sentimos - no existen registros",
                "infoEmpty": "No hay registros disponibles",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "info": "Página _PAGE_ de _PAGES_",
                "search": "Buscar:",
                "paginate": {
                    "first":    "Primero",
                    "last":     "Último",
                    "next":     "Siguiente",
                    "previous": "Anterior"
                },
                "loadingRecords": "Cargando...",
                "infoThousands":  ",",
                "infoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "infoPostFix":    "",
                "aria": {
                    "sortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "ordering": true,
            "order": [[0, 'asc']],
            "bDestroy": true,
            "bPaginate": true,
            "bInfo": true,
            "initComplete": function(settings, json) {
                $('.dataTables_length select').select2();
            }
        };
        $('.datatable').dataTable(dt_options);
    }
    
});