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
        $('.select2').attr({
            'title': 'Seleccione un registro de la lista',
            'data-toggle': 'tooltip'
        });
        $('.select2').tooltip();
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

    if ($('.btn-add-record').length) {
        $('.btn-add-record').attr({
            'title': 'Agregar un nuevo registro',
            'data-toggle': 'tooltip'
        });
        $('.btn-add-record').tooltip();
    }

    /** Reemplazo de icono indicador en el menú del panel izquierdo */
    $('.submenu-indicator').html('<i class="ion-ios-arrow-left text-center text-info"></i>');

    /** Acciones para ocultar los mensajes tooltip cuando se posiciona o se hace clic en otro elemento */
    $('a').on('hover, click', function() {
        $('.tooltip:last').remove();
        $('.tooltip:last').tooltip();
    });

    if ($('.datatable').length) {
        /** Configuración de atributos para tablas con datatable */
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

    /** Evento que permite mostrar datos sobre la aplicación (acerca de) */
    $('.about_app').on('click', function(e) {
        e.preventDefault();
        bootbox.alert(
            '<h6>SISTEMA DE GESTION ADMINISTRATIVA | KAVAC</h6>' +
            '<p class="text-justify">Sistema administrativo que permite la automatización de los procesos inherentes a la administración pública. Registra y controla el presupuesto de la institución.</p>' +
            '<h6 class="card-title">Créditos</h6>' +
            '<ul>' +
                '<li class="special-title">Lider de proyecto / Diseño / Desarrollo</li>' +
                '<li>Roldan Vargas (rvargas@cenditel.gob.ve)</li>' +
                '<li class="special-title">Analistas</li>' +
                '<li>Julie Vera (jvera@cenditel.gob.ve)</li>' +
                '<li>María Gónzalez (mgonzalez@cenditel.gob.ve)</li>' +
                '<li class="special-title">Desarrolladores</li>' +
                '<li>William Paéz (wpaez@cenditel.gob.ve)</li>' +
                '<li>Juan Vizcarrondo (jvizcarrondo@cenditel.gob.ve)</li>' +
            '</ul>' +
            '<h6 class="card-title">Repositorio</h6>' +
            '<ul>' +
                '<li class="no-list-symbol">' +
                    '<a href="#" target="_blank">Repositorio</a>' +
                '</li>' +
            '</ul>' +
            '<h6 class="card-title">Documentación</h6>' +
            '<ul>' +
                '<li class="no-list-symbol">' +
                    '<a href="#" target="_blank">Documentación</a>' +
                '</li>' +
            '</ul>'    
        );
    });

    /** Evento que permite mostrar datos sobre el licenciamiento de la aplicación */
    $('.license_app').on('click', function(e) {
        e.preventDefault();
        bootbox.alert(
            '<h6>LICENCIA | Copyleft <i class="fa fa-copyright"></i></h6>' + 
            '<p>La aplicación, salvo aquellos paquetes de tercero con licenciamiento personalizado excluyentes de esta aplicación, se distribuye bajo los terminos de licenciamiento de la GPL v2.</p>' +
            '<p>Esto quiere decir que eres libre de copiarla, estudiarla, modificarla y/o distribuirla.<p>' +
            '<p>A continuación un extracto de la licencia:</p>' +
            '<p class="text-justify text-info">' +
                'This program is free software. You can redistribute it and/or modify ' +
                'it under the terms of the GNU General Public License as published by ' +
                'the Free Software Foundation; either version 2 of the License.' +
                '<br><br>' +
                'This program is distributed in the hope that it will be useful, ' +
                'but WITHOUT ANY WARRANTY; without even the implied warranty of ' +
                'MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the ' +
                'GNU General Public License for more details.' +
                '<br><br>' +
                'You should have received a copy of the GNU General Public License ' +
                'along with this program; if not, write to the Free Software ' +
                'Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA.' +
            '</p>' +
            '<p>El texto completo de la licencia se puede leer <a href="" title="">aquí</a></p>'
        );
    });
});

/** Script para medir la fortaleza de la contraseña */
(function($) {
    $('#password').complexify({}, function (valid, complexity) {
        var progressBar = $('#complexity-bar');
        var progressContainer = progressBar.closest('.progress-container');
        var color;
        $('#complexity').removeClass(['text-danger', 'text-warning', 'text-success']);
        progressContainer.toggleClass('progress-danger', (complexity<43));
        progressContainer.toggleClass('progress-warning', (complexity>=43&&complexity<=70));
        progressContainer.toggleClass('progress-success', (complexity>70));

        if ((complexity<43)) {
            color = "text-danger";
            progressContainer.find('.progress-badge').html('Débil');
        }
        else if (complexity>=43&&complexity<=70) {
            color = "text-warning";
            progressContainer.find('.progress-badge').html('Aceptable');
        }
        else if (complexity>70) {
            color = "text-success";
            progressContainer.find('.progress-badge').html('Fuerte');
        }
        
        progressBar.css({'width': complexity + '%'});

        $('#complexity').addClass(color);
        $('#complexity').text(Math.round(complexity) + '%');
        $('#complexity-level').val(Math.round(complexity));
    });
})(jQuery);