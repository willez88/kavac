/** Corrige el uso del campo de búsqueda en elementos select2 en ventanas modales con el uso de bootstrap 4 */
$.fn.modal.Constructor.prototype._enforceFocus = function() {};

/** Instrucciones a ejecutar una vez se haya cargado la página */
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
        $('select').select2({});
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

    /** Tooltips personalizados */
    if ($('.close').length) {
        $('.close').attr({
            'title': 'Presione para cerrar la ventana',
            'data-toggle': 'tooltip',
            'data-placement': 'left',
        });
        $('.close').tooltip({
            trigger:"hover", delay:{hide:200}
        });
    }

    if ($('.btn-modal-close').length) {
        $('.btn-modal-close').attr({
            'title': 'Presione para cerrar la ventana',
            'data-toggle': 'tooltip'
        });
        $('.btn-modal-close').tooltip({
            trigger:"hover", delay:{hide:200}
        });
    }

    if ($('.btn-modal-save').length) {
        $('.btn-modal-save').attr({
            'title': 'Presione para guardar el registro',
            'data-toggle': 'tooltip'
        });
        $('.btn-modal-save').tooltip({
            trigger:"hover", delay:{hide:200}
        });
    }
    if ($('.btn-add-record').length) {
        $('.btn-add-record').attr({
            'title': 'Agregar un nuevo registro',
            'data-toggle': 'tooltip'
        });
        $('.btn-add-record').tooltip({
            trigger:"hover", delay:{hide:200}
        });
    }
    if ($('.btn-tooltip').length) {
        $('.btn-tooltip').tooltip({
            trigger:"hover", delay:{hide:200}
        });
    }
    if ($('.btn-file').length) {
        $('.btn-file').attr({
            'title': 'Seleccione un archivo a cargar',
            'data-toggle': 'tooltip'
        });
        $('.btn-file').tooltip({
            trigger:"hover", delay:{hide:200}
        });
    }

    /** Reemplazo de icono indicador en el menú del panel izquierdo */
    $('.submenu-indicator').html('<i class="ion-ios-arrow-left text-center text-info"></i>');

    /** Acciones para ocultar los mensajes tooltip cuando se posiciona o se hace clic en otro elemento */
    $('a').on('hover, click', function() {
        $('.tooltip:last').remove();
        $('.tooltip:last').tooltip({
            trigger:"hover", delay:{hide:200}
        });
    });

    /** Formularios */
    $('form').each(function() {
        if ($(this).find('.is-required').length) {
            $(this).find('.card-body').prepend(
                "<div class='row' style='margin:10px 0'>" + 
                    "<div class='col-12 form-group'>" + 
                        "<span class='text-muted'>" + 
                            "Los campos con <span class='text-required'>*</span> son obligatorios" +
                        "</span>" + 
                    "</div>" + 
                "</div>"
            );
        }
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
            "bAutoWidth": false,
            "initComplete": function(settings, json) {
                $('.dataTables_length select').select2();
            }
        };
        $('.datatable').dataTable(dt_options);
        $('.dataTables_length .selection').attr({
            'title': 'Seleccione la cantidad de registros a mostrar por cada página',
            'data-toggle': 'tooltip'
        });
        $('dataTables_length .selection').tooltip();
        $('.dataTables_filter input').attr({
            'title': 'Indique los datos del registro a buscar',
            'data-toggle': 'tooltip'
        });
        $('.dataTables_filter input').tooltip();

    }

    /** Evento que permite mostrar datos sobre la aplicación (acerca de) */
    $('.about_app').on('click', function(e) {
        e.preventDefault();
        const appInfo = new AppInfo([
            {
                name: 'Roldan Vargas', 
                email: 'rvargas@cenditel.gob.ve | roldandvg@gmail.com', 
                group: 'Lider de proyecto / Diseño / Desarrollo'
            },
            {
                name: 'Julie Vera',
                email: 'jvera@cenditel.gob.ve',
                group: 'Analistas'
            },
            {
                name: 'María González',
                email: 'mgonzalez@cenditel.gob.ve',
                group: 'Analistas'
            },
            {
                name: 'María Rujano',
                email: 'mrujano@cenditel.gob.ve',
                group: 'Analistas'
            },
            {
                name: 'Mariangel Molero',
                email: 'mmolero@cenditel.gob.ve',
                group: 'Analistas'
            },
            {
                name: 'Francisco Berbesí',
                email: 'fberbesi@cenditel.gob.ve',
                group: 'Analistas'
            },
            {
                name: 'William Paéz',
                email: 'wpaez@cenditel.gob.ve',
                group: 'Desarrolladores'
            },
            {
                name: 'Henry Paredes',
                email: 'henryp2804@gmail.com',
                group: 'Desarrolladores'
            },
            {
                name: 'Juan Rosas',
                email: 'jrosas@cenditel.gob.ve',
                group: 'Desarrolladores'
            }
        ]);
        bootbox.alert(
            appInfo.showAbout()
        );
    });

    /** Evento que permite mostrar datos sobre el licenciamiento de la aplicación */
    $('.license_app').on('click', function(e) {
        e.preventDefault();
        const appInfo = new AppInfo([
            {name: 'Roldan Vargas'},
            {name: 'Julie Vera'},
            {name: 'María González'},
            {name: 'Francisco Berbesí'},
            {name: 'William Paéz'},
            {name: 'Henry Paredes'},
            {name: 'Juan Rosas'}
        ]);
        bootbox.alert(appInfo.showLicense());
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

/**
 * Permite mostrar alerta de mensajes de acciones realizadas con vue o js
 *
 * @author Ing. Roldan Vargas  <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @param  {string} msg_title  Título de la ventana de alerta
 * @param  {string} msg_class  Clase de estilo a usar en la ventana de alerta
 * @param  {string} msg_icon   Ícono a usar en la ventana de alerta
 * @param  {string} msg_custom Mensaje personalizado
 * @param  {string} type       Tipo de mensaje a mostrar (store|update|destroy)
 */
function gritter_messages(msg_title, msg_class, msg_icon, type, msg_custom) {
    msg_title = (!msg_title)?'Éxito':msg_title;
    msg_class = (!msg_class)?'growl-success':'glowl-'+msg_class;
    msg_icon = (!msg_icon)?'screen-ok':msg_icon;

    var msg_text = (!msg_custom)?'':msg_custom;
    if (type=='store') {
        msg_text = 'Registro almacenado con éxito';
    }
    else if (type=='update') {
        msg_text = 'Registro actualizado con éxito';
    }
    else if (type=='destroy') {
        msg_text = 'Registro eliminado con éxito';
    }
    else if (type==='load') {
        msg_text = 'Los datos fueron cargados correctamente';
    }

    $.gritter.add({
        title: msg_title,
        text: msg_text,
        class_name: msg_class,
        image: "/images/" + msg_icon + ".png",
        sticky: false,
        time: ''
    });
}

/*
 * Función que permite eliminar registros mediante ajax
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @param {string} url URL del controlador que realiza la acción de eliminación
 * @return Un mensaje al usuario solicitando confirmación de la eliminación del registro
 */
function delete_record(url) {
    bootbox.confirm('Esta seguro de querer eliminar este registro?', function(result) {
        if (result) {
            /** Ajax config csrf token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /** Ajax delete record */
            $.ajax({
                type: 'DELETE',
                cache: false,
                dataType: 'JSON',
                url: url,
                data: {},
                success: function(data){
                    if (data.result) {
                        location.reload();
                    }
                },
                error: function(jqxhr, textStatus, error) {
                    var err = textStatus + ", " + error;
                    bootbox.alert('Error interno del servidor al eliminar el registro.');
                    logs('resources/js/custom.js', 406, `Error con la petición solicitada. Detalles: ${err}`, 'delete_record');
                }
            });
        }
    });
}