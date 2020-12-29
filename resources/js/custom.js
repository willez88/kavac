/** Corrige el uso del campo de búsqueda en elementos select2 en ventanas modales con el uso de bootstrap 4 */
$.fn.modal.Constructor.prototype._enforceFocus = function() {};

/** Instrucciones a ejecutar una vez se haya cargado la página */
$(document).ready(function() {
    /** Tooltip para opciones de la barra de navegación superior */
    $('.dropdown-toggle').tooltip({ delay: { hide: 100 } });
    $('.dropdown-toggle').on('click', function() {
        $('.tooltip:last').remove();
        $(this).tooltip({ delay: { hide: 100 } });
    });
    $('.dropdown-toggle').on('shown.bs.tooltip', function() {
        setTimeout(function() {
            $('.dropdown-toggle').tooltip('hide');
        }, 1500);
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
                $('.menu-option a span').show("slow");
                $('.menu-collapse').attr("data-original-title", "Minimizar panel de menú");
            } else {
                $('.container-left, .content-wrapper').addClass('collapsed');
                $(this).find('i').removeClass('arrows-1_minimal-left');
                $(this).find('i').addClass('arrows-1_minimal-right');
                $('.children').hide("slow"); // hide sub-menu if leave open
                $('.menu-option').addClass('text-center');
                $('.menu-option a i').addClass('fa-2x');
                $('.menu-option a span').hide("slow");
                $('.menu-collapse').attr("data-original-title", "Maximizar panel de menú");
            }
            $('.menu-collapse').tooltip();
            setTimeout(function() {
                $('.menu-collapse').tooltip('hide');
            }, 2000);
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
        $('.select2').tooltip({ delay: { hide: 100 } });
        $('.select2').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.select2').tooltip('hide');
            }, 1500);
        });
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
    $('.card .card-minimize').click(function() {
        let el = $(this);
        var p = el.closest('.card');
        $('.tooltip:last').remove();

        if (!$(this).hasClass('maximize')) {
            p.find('hr').addClass('nodisplay');
            p.find('.card-body, .card-footer').fadeOut('fast');
            el.addClass('maximize');
            el.find('i').removeClass('arrows-1_minimal-up').addClass('arrows-1_minimal-down');
            el.attr('data-original-title', 'Maximize Panel').tooltip({ delay: { hide: 100 } });
        } else {
            p.find('hr').removeClass('nodisplay');
            p.find('.card-body, .card-footer').fadeIn('fast');
            el.removeClass('maximize');
            el.find('i').removeClass('arrows-1_minimal-down').addClass('arrows-1_minimal-up');
            el.attr('data-original-title', 'Minimize Panel').tooltip({ delay: { hide: 100 } });
        }

        el.on('shown.bs.tooltip', function() {
            setTimeout(function() {
                el.tooltip('hide');
            }, 1500);
        });

        return false;
    });

    /** Maximinizar / Minimizar secciones */
    if ($(".btn-collapse").length) {
        $(".btn-collapse").on("click", function() {
            if ($(this).hasClass('collapsed')) {
                $(this).find("i").removeClass('arrows-1_minimal-down');
                $(this).find("i").addClass('arrows-1_minimal-up');
            }
            else {
                $(this).find("i").removeClass('arrows-1_minimal-up');
                $(this).find("i").addClass('arrows-1_minimal-down');
            }
        });
        $(".btn-collapse").tooltip({
            trigger: "hover",
            delay: { hide: 100 }
        });
        $('.btn-collapse').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.close').tooltip('hide');
            }, 1500);
        });
    }

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
            trigger: "hover",
            delay: { hide: 100 }
        });
        $('.close').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.close').tooltip('hide');
            }, 1500);
        });
    }

    if ($('.btn-modal-close').length) {
        $('.btn-modal-close').attr({
            'title': 'Presione para cerrar la ventana',
            'data-toggle': 'tooltip'
        });
        $('.btn-modal-close').tooltip({
            trigger: "hover",
            delay: { hide: 100 }
        });
        $('.btn-modal-close').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.btn-modal-close').tooltip('hide');
            }, 1500);
        });
    }

    if ($('.btn-modal-save').length) {
        $('.btn-modal-save').attr({
            'title': 'Presione para guardar el registro',
            'data-toggle': 'tooltip'
        });
        $('.btn-modal-save').tooltip({
            trigger: "hover",
            delay: { hide: 100 }
        });
        $('.btn-modal-save').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.btn-modal-save').tooltip('hide');
            }, 1500);
        });
    }
    if ($('.btn-add-record').length) {
        $('.btn-add-record').attr({
            'title': 'Agregar un nuevo registro',
            'data-toggle': 'tooltip'
        });
        $('.btn-add-record').tooltip({
            trigger: "hover",
            delay: { hide: 100 }
        });
        $('.btn-add-record').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.btn-add-record').tooltip('hide');
            }, 1500);
        });
    }
    if ($('.btn-tooltip').length) {
        $('.btn-tooltip').tooltip({
            trigger: "hover",
            delay: { hide: 100 }
        });
        $('.btn-tooltip').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.btn-tooltip').tooltip('hide');
            }, 1500);
        });
    }
    if ($('.btn-file').length) {
        $('.btn-file').attr({
            'title': 'Seleccione un archivo a cargar',
            'data-toggle': 'tooltip'
        });
        $('.btn-file').tooltip({
            trigger: "hover",
            delay: { hide: 100 }
        });
        $('.btn-file').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.btn-file').tooltip('hide');
            }, 1500);
        });
    }

    /** Reemplazo de icono indicador en el menú del panel izquierdo */
    $('.submenu-indicator').html('<i class="ion-ios-arrow-left text-center text-info"></i>');

    /** Acciones para ocultar los mensajes tooltip cuando se posiciona o se hace clic en otro elemento */
    $('a').on('hover, click', function() {
        $('.tooltip:last').remove();
        $('.tooltip:last').tooltip({
            trigger: "hover",
            delay: { hide: 100 }
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
        $.extend($.fn.dataTableExt.oStdClasses, {
            "sFilterInput": "form-control input-sm",
            "sLengthSelect": "input-sm select2",
        });
        dt_options = {
            "language": {
                //"url": "http://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json",
                "processing": "Procesando...",
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "Lo sentimos - no existen registros",
                "infoEmpty": "No hay registros disponibles",
                "emptyTable": "Ningún dato disponible en esta tabla",
                "info": "Página _PAGE_ de _PAGES_",
                "search": "Buscar:",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "loadingRecords": "Cargando...",
                "infoThousands": ",",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "infoPostFix": "",
                "aria": {
                    "sortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            "ordering": true,
            "order": [
                [0, 'asc']
            ],
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
        $('.dataTables_length .selection').tooltip({ delay: { hide: 100 } });
        $('.dataTables_length .selection').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.dataTables_length .selection').tooltip('hide');
            }, 1500);
        });
        $('.dataTables_filter input').attr({
            'title': 'Indique los datos del registro a buscar',
            'data-toggle': 'tooltip'
        });
        $('.dataTables_filter input').tooltip({ delay: { hide: 100 } });
        $('.dataTables_filter input').on('shown.bs.tooltip', function() {
            setTimeout(function() {
                $('.dataTables_filter input').tooltip('hide');
            }, 1500);
        });
        $('.modal').on('hidden.bs.modal', function() {
            $("input[class^='VueTables__search']").val('');
        });
    }

    /** Gestiona elementos de tablas VueTables */
    if ($('.VueTables__search__input').length > 0 && !$('.VueTables__search__input').hasClass('input-sm')) {
        $('.VueTables__search__input').addClass('input-sm');
    }

    /** Evento que permite mostrar datos sobre la aplicación (acerca de) */
    $('.about_app').on('click', function(e) {
        e.preventDefault();
        const appInfo = new AppInfo([
            {
                name: 'Roldan Vargas',
                email: 'rvargas@cenditel.gob.ve | roldandvg@gmail.com',
                group: 'Lider de proyecto / Diseño / Desarrollo / Autor / Director de Desarrollo (2021)'
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
                name: 'Hyildayra Colmenares',
                email: 'hcolmenares@cenditel.gob.ve',
                group: 'Analistas'
            },
            {
                name: 'Kleibymar Montilla',
                email: 'kmontilla@cenditel.gob.ve',
                group: 'Analistas'
            },
            {
                name: 'Luis Ramírez',
                email: 'lramirez@cenditel.gob.ve',
                group: 'Manuales'
            },
            {
                name: 'Marilyn Caballero',
                email: 'mcaballero@cenditel.gob.ve',
                group: 'Manuales'
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
            },
            {
                name: 'Yennifer Ramírez',
                email: 'yramirez@cenditel.gob.ve',
                group: 'Desarrolladores'
            },
            {
                name: 'Pedro Buitrago',
                email: 'pbuitrago@cenditel.gob.ve',
                group: 'Desarrolladores'
            },
            {
                name: 'Angelo Osorio',
                email: 'adosorio@cenditel.gob.ve',
                group: 'Desarrolladores'
            },
            {
                name: 'José Puentes',
                email: 'jpuentes@cenditel.gob.ve',
                group: 'Desarrolladores'
            },
            {
                name: 'Daniel Contreras',
                email: 'dcontreras@cenditel.gob.ve',
                group: 'Desarrolladores'
            },
            {
                name: 'Miguel Narváez',
                email: 'mnarvaez@cenditel.gob.ve',
                group: 'Desarrolladores'
            },
            {
                name: 'Argenis Osorio',
                email: 'aosorio@cenditel.gob.ve',
                group: 'Director de Desarrollo (2018-2019)'
            },
            {
                name: 'Laura Colina',
                email: 'lcolina@cenditel.gob.ve',
                group: 'Director de Desarrollo (2020)'
            },
            {
                name: 'Santiago Roca',
                email: 'sroca@cenditel.gob.ve',
                group: 'Colaborador'
            }
        ]);
        bootbox.alert({
            className: 'modal-credits',
            closeButton: false,
            message: appInfo.showAbout(),
            buttons: {
                ok: {
                    label: "OK",
                    className: 'btn-primary'
                }
            },
        });

        $('.bootbox.modal [data-bb-handler="ok"]').attr('title', 'Haga clic para cerrar esta ventana');
        $('.bootbox.modal [data-bb-handler="ok"]').attr('data-toggle', 'tooltip');
        $('.bootbox.modal [data-bb-handler="ok"]').tooltip();
        $('.bootbox.modal a').tooltip();
    });

    /** Evento que permite mostrar datos sobre el licenciamiento de la aplicación */
    $('.license_app').on('click', function(e) {
        e.preventDefault();
        const appInfo = new AppInfo([
            { name: 'Roldan Vargas' },
            { name: 'Julie Vera' },
            { name: 'María González' },
            { name: 'María Rujano' },
            { name: 'Mariangel Molero' },
            { name: 'Francisco Berbesí' },
            { name: 'Luis Ramírez' },
            { name: 'Hyildayra Colmenares' },
            { name: 'Kleibymar Montilla' },
            { name: 'Daniel Contreras' },
            { name: 'Marilyn Caballero' },
            { name: 'William Paéz' },
            { name: 'Henry Paredes' },
            { name: 'Juan Rosas' },
            { name: 'Yennifer Ramírez' },
            { name: 'Argenis Osorio' },
            { name: 'Laura Colina' },
            { name: 'Angelo Osorio' },
            { name: 'Santiago Roca' },
            { name: 'Pedro Buitrago' },
            { name: 'José Puentes' },
            { name: 'Miguel Narváez' },
        ]);
        bootbox.alert({
            className: 'modal-credits',
            closeButton: false,
            message: appInfo.showLicense()
        });

        $('.bootbox.modal [data-bb-handler="ok"]').attr('title', 'Haga clic para cerrar esta ventana');
        $('.bootbox.modal [data-bb-handler="ok"]').attr('data-toggle', 'tooltip');
        $('.bootbox.modal [data-bb-handler="ok"]').tooltip();
        $('.bootbox.modal a').tooltip();
    });

    /** Oculta el tooltip de los elementos bootstrap switch después de unos segundos */
    $('.bootstrap-switch').on('shown.bs.tooltip', function() {
        setTimeout(function() {
            $('.bootstrap-switch').tooltip('hide');
        }, 1500);
    });
});

/** Script para medir la fortaleza de la contraseña */
(function($) {
    $('#password').complexify({}, function(valid, complexity) {
        var progressBar = $('#complexity-bar');
        var progressContainer = progressBar.closest('.progress-container');
        var color;
        $('#complexity').removeClass(['text-danger', 'text-warning', 'text-success']);
        progressContainer.toggleClass('progress-danger', (complexity < 43));
        progressContainer.toggleClass('progress-warning', (complexity >= 43 && complexity <= 70));
        progressContainer.toggleClass('progress-success', (complexity > 70));

        if ((complexity < 43)) {
            color = "text-danger";
            progressContainer.find('.progress-badge').html('Débil');
        } else if (complexity >= 43 && complexity <= 70) {
            color = "text-warning";
            progressContainer.find('.progress-badge').html('Aceptable');
        } else if (complexity > 70) {
            color = "text-success";
            progressContainer.find('.progress-badge').html('Fuerte');
        }

        progressBar.css({ 'width': complexity + '%' });

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
    msg_title = (!msg_title) ? 'Éxito' : msg_title;
    msg_class = (!msg_class) ? 'growl-success' : 'glowl-' + msg_class;
    msg_icon = (!msg_icon) ? 'screen-ok' : msg_icon;

    var msg_text = (!msg_custom) ? '' : msg_custom;
    if (type == 'store') {
        msg_text = 'Registro almacenado con éxito';
    } else if (type == 'update') {
        msg_text = 'Registro actualizado con éxito';
    } else if (type == 'destroy') {
        msg_text = 'Registro eliminado con éxito';
    } else if (type === 'load') {
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
                success: function(data) {
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
