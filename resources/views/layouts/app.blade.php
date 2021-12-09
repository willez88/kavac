<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} | {{ __('Sistema de Gestión Administrativa') }}</title>
        <link rel="shortcut icon" href="{{ asset('images/favicon.png', Request::secure()) }}">
        {{-- Estilos de la aplicación --}}
        {!! Html::style('css/app.css', ['media' => 'screen'], Request::secure()) !!}
        {{-- Icofont --}}
        {!! Html::style('css/icofont.css', [], Request::secure()) !!}
        {{-- Estilos de Plugins --}}
        {{-- Datatable --}}
        {!! Html::style(
            'vendor/datatable/css/dataTables.bootstrap4.min.css', ['media' => 'screen'], Request::secure()
        ) !!}
        {!! Html::style('vendor/datatable/css/jquery.dataTables.min.css', ['media' => 'screen'], Request::secure()) !!}
        {!! Html::style('vendor/datatable/css/select.dataTables.min.css', ['media' => 'screen'], Request::secure()) !!}
        {!! Html::style(
            'vendor/datatable/css/buttons.dataTables.min.css', ['media' => 'screen'], Request::secure()
        ) !!}
        {!! Html::style(
            'vendor/datatable/responsive/css/responsive.bootstrap4.min.css', ['media' => 'screen'], Request::secure()
        ) !!}
        {{-- Hoja de estilo para los mensajes de la aplicación (requerida) --}}
        {!! Html::style('vendor/jquery.gritter/css/jquery.gritter.css', ['media' => 'screen'], Request::secure()) !!}

        @yield('modules-css')
        <script>
            window.Laravel = {!! json_encode([
                'csrfToken' => csrf_token(),
            ]) !!}
            /** @type {boolean} Define si la condición de acceso */
            window.access = true;
            /** @type {string} Define la URI para el registro de eventos del sistema */
            window.log_url = '{{ route('logs.front-end') }}';
            /** @type {boolean} Define si el usuario se encuentra o no autenticado en el sistema */
            window.auth = {!! (auth()->check()) ? 'true' : 'false' !!};
            /** @type {boolean} Define si la aplicación se encuentra o no en módo de desarrollo */
            window.debug = {!! (config('app.debug')) ? 'true' : 'false' !!};
            /** @type {string} Define la URI de la aplicación */
            window.app_url = `{{ env('APP_URL') }}`;
            /** @type {String} Define el idioma actual de la aplicación */
            window.currentLocale = '{{ app()->getLocale() }}';
            @auth
                /** @type {Boolean} Establece si la pantalla de bloqueo está o no activa */
                window.screen_locked = {!! (auth()->user()->lock_screen) ? 'true' : 'false' !!}
                /** @type {array} Lista de módulos instalados y habilitados */
                window.modules = [];
                @if (Module::allEnabled())
                    @foreach (Module::allEnabled() as $moduleEnabled)
                        window.modules.push('{!! $moduleEnabled->getName() !!}');
                    @endforeach
                @endif
            @endauth
        </script>

        {{-- Sección para estilos extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-css')
    </head>
    <body>
        @auth
            {{-- Ventana modal para mostrar mensaje de espera mientras cargan los datos --}}
            @include('layouts.loading-message')
        @endauth

        @section('custom-page')
            @guest
                <div class="login-container">
                    <div class="login-overlay"></div>
                    <div class="d-flex flex-column justify-content-center login-form">
                        <div id="app" class="align-self-center col-12">
                            @yield('content')
                        </div>
                    </div>
                    <footer class="align-self-end">
                        @include('layouts.footer')
                    </footer>
                </div>
            @else
                <div id="app">
                    @include('layouts.navbar')
                    <div class="content-wrapper">
                        @include('layouts.left-panel')
                        @include('layouts.content')
                    </div>
                </div>
            @endguest
        @show

        @yield('modals')
        {{-- Scripts --}}
        {{-- Plugin Sliders --}}
        {{-- {!! Html::script('js/nouislider.min.js', [], Request::secure()) !!} --}}
        {{-- Scripts de la aplicación --}}
        <script src="{{ asset('js/app.js', Request::secure()) }}"></script>
        <script src="{{ asset('js/generic-classes.js', Request::secure()) }}"></script>
        <script src="{{ asset('js/shared-components.js', Request::secure()) }}"></script>
        @yield('modules-js')

        {{-- Plugin Bootbox --}}
        <script src="{{ asset('js/bootbox.min.js', Request::secure()) }}" defer></script>
        {{-- Plugin Datatable --}}
        <script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js', Request::secure()) }}" defer></script>
        <script src="{{ asset('vendor/datatable/js/dataTables.select.min.js', Request::secure()) }}" defer></script>
        <script src="{{ asset('vendor/datatable/js/dataTables.buttons.min.js', Request::secure()) }}" defer></script>
        <script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js', Request::secure()) }}" defer></script>
        <script src="{{ asset('vendor/datatable/js/dataTables.responsive.min.js', Request::secure()) }}" defer></script>
        <script src="{{ asset('vendor/datatable/js/responsive.bootstrap4.min.js', Request::secure()) }}" defer></script>
        {{-- Plugin Gritter --}}
        <script src="{{ asset('vendor/jquery.gritter/js/jquery.gritter.min.js', Request::secure()) }}" defer></script>
        {{-- Scripts comúnes --}}
        <script src="{{ asset('js/common.js', Request::secure()) }}" defer></script>

        @auth
            {{-- Botón de ir al inicio de la página cuando se excede de un alto preestablecido --}}
            @include('buttons.to-top')
            {{-- Ventanas modales de uso general --}}
            @include('layouts.modals')
        @endauth
        {{-- Mensaje de espera al cargar procesos del sistema --}}
        @include('layouts.messages')
        <script>
            /** @type {Object} Gestiona los eventos del touchstart */
            $.event.special.touchstart = {
                setup: function( _, ns, handle ) {
                    this.addEventListener("touchstart", handle, {passive: !ns.includes("noPreventDefault")});
                }
            };
            /** @type {Object} Gestiona los eventos del touchmove */
            $.event.special.touchmove = {
                setup: function( _, ns, handle ) {
                    this.addEventListener('touchmove', handle, { passive: !ns.includes('noPreventDefault')});
                }
            };
        </script>
        @auth
            <script>
                $(document).ready(function() {
                    $('#form-lockscreen').on('submit', function() {
                        unlockScreen();
                        return false;
                    });

                    /** Coloca el año actual en el pie de página */
                    $('.currentYear').text(new Date().getFullYear());



                    /** Restringe el rango de fechas del campo tipo date al año de ejercicio económico */
                    /*$("input[type=date]").attr({
                        min: `${window.execution_year}-01-01`,
                        max: `${window.execution_year}-12-31`
                    });*/

                    /** Previene el uso de carácteres no permitidos en campos numéricos */
                    $(".numeric").on('input keypress keyup blur', function(event) {
                        $(this).val($(this).val().replace(/[^\d].+/, ""));
                        if ((event.which < 48 || event.which > 57)) {
                            event.preventDefault();
                        }
                    });
                    /** Previene el uso de carácteres no permitidos en campos de monedas */
                    $(".currency, input[type=number]").on('input keypress keyup blur', function(event) {
                        $(this).val($(this).val().replace(/[^0-9\.]?$/g, ""));
                        //$(this).val($(this).val().replace(/^\d*\.?(?:\d{1,2})?$/g, ""));
                        if ((event.which === 46 && $(this).val().indexOf('.') != -1) || (event.which < 48 || event.which > 57)) {
                            event.preventDefault();
                        }
                    });

                    $('#form-codes').on('submit', function() {
                        if (typeof(Inputmask) !== "undefined" && typeof(Inputmask) === "function") {
                            Inputmask().mask(document.querySelectorAll("input"));
                            $('*[placeholder$="XXX-00000000-YYYY"]').each(function() {
                                Inputmask({placeholder: '', regex: "^[A-Z]{1,3}$-[0]{4,8}-^([Y]{2}|[Y]{4})$"}).mask(this);
                            });
                        }
                    });

                    if (typeof(Inputmask) !== "undefined" && typeof(Inputmask) === "function") {
                        Inputmask().mask(document.querySelectorAll("input"));
                        $('*[placeholder$="XXX-00000000-YYYY"]').each(function() {
                            Inputmask({
                                regex: "^[A-Z]{1,3}$-[0]{4,8}-^([Y]{2}|[Y]{4})$",
                                clearMaskOnLostFocus: true
                            }).mask(this);
                        });
                    }

                    /** oculta el mensaje de carga al renderizar por completo el DOM de la página */
                    $('.preloader').fadeOut(1000);
                });

                /** Establece el tema por defecto, para elementos select2, a bootstrap 4 */
                $.fn.select2.defaults.set( "theme", "bootstrap" );

                /*
                 * Función que permite eliminar registros mediante ajax
                 *
                 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 * @param {string} url URL del controlador que realiza la acción de eliminación
                 * @return Un mensaje al usuario solicitando confirmación de la eliminación del registro
                 */
                function delete_record(url) {
                    bootbox.confirm('{{ __('Esta seguro de querer eliminar este registro?') }}', function (result) {
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
                                success: function success(data) {
                                    if (data.result) {
                                        location.reload();
                                    }
                                    else {
                                        $.gritter.add({
                                            title: '{{ __('Alerta!') }}',
                                            text: data.message,
                                            class_name: 'growl-danger',
                                            image: "{{ asset('images/screen-error.png') }}",
                                            sticky: false,
                                            time: 2500
                                        });
                                    }
                                },
                                error: function error(jqxhr, textStatus, _error) {
                                    var err = textStatus + ", " + _error;
                                    if (window.debug) {
                                        console.log(`Error con la petición solicitada. Detalles: ${err}`);
                                    }
                                }
                            });
                        }
                    });
                }

                /**
                 * Muestra una ventana de confirmación para salir del sistema
                 *
                 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 */
                function logout() {
                    bootbox.confirm('{{ __('¿Está seguro de que desea salir de la aplicación?') }}', function(result) {
                        if (result) {
                            document.getElementById('logout-form').submit();
                        }
                    });
                }

                /**
                 * Actualiza información de un select a partir de otro
                 *
                 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 * @param  {object}  parent_element Objeto con los datos del elemento que genera la acción
                 * @param  {object}  target_element Objeto que se cargara con la información
                 * @param  {string}  target_model   Modelo en el cual se va a realizar la consulta
                 * @param  {string}  module_name    Nombre del módulo que ejecuta la acción
                 */
                function updateSelect(parent_element, target_element, target_model, module_name) {
                    var module_name = (typeof(module_name) !== "undefined")?'/' + module_name:'';
                    var parent_id = parent_element.val();
                    var parent_name = parent_element.attr('id');

                    target_element.empty().append('<option value="">{{ __('Seleccione...') }}</option>');

                    if (parent_id) {
                        axios.get(
                            `/get-select-data/${parent_name}/${parent_id}/${target_model}${module_name}`
                        ).then(response => {
                            if (response.data.result) {
                                target_element.attr('disabled', false);
                                $.each(response.data.records, function(index, record) {
                                    target_element.append(
                                        `<option value="${record['id']}">${record['name']}</option>`
                                    );
                                });
                            }
                        }).catch(error => {
                            logs('app', 244, error, 'updateSelect');
                        })
                    }
                    else {
                        target_element.attr('disabled', true);
                    }
                }

                /**
                 * Permite restaurar registros eliminados del sistema
                 *
                 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 * @param  {string} url URL que recibe la petición y ejecuta la acción
                 */
                function undelete_record(url) {
                    bootbox.confirm('{{ __('Esta seguro de querer restaurar este registro?') }}', function (result) {
                        if (result) {
                            /** Ajax config csrf token */
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            /** Ajax undelete record */
                            $.ajax({
                                type: 'GET',
                                cache: false,
                                dataType: 'JSON',
                                url: url,
                                data: {},
                                success: function success(data) {
                                    if (data.result) {
                                        location.reload();
                                    }
                                },
                                error: function error(jqxhr, textStatus, _error) {
                                    var err = textStatus + ", " + _error;
                                    if (window.debug) {
                                        console.log(`Error con la petición solicitada. Detalles: ${err}`);
                                    }
                                }
                            });
                        }
                    });
                }

                @role('admin')
                    /**
                     * Muestra información relacionada a un usuario
                     *
                     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                     * @param  {integer} id Identificador del usuario del cual se desea obtener información
                     */
                    var view_user_info = function(id) {
                        axios.get('/user-info/' + id).then(response => {
                            let user = response.data.user;
                            let roles = [], permissions = [];
                            if (typeof(user.roles) !== "undefined") {
                                $.each(user.roles, function() {
                                    roles.push(this.name);
                                });
                            }
                            if (typeof(user.permissions) !== "undefined") {
                                $.each(user.permissions, function() {
                                    permissions.push(this.name);
                                });
                            }

                            const userDetail = new User(user.name, user.username, user.email, roles, permissions);

                            bootbox.alert(userDetail.showInfo());
                        }).catch(error => {
                            logs('app', 315, error, 'view_user_info');
                        });
                    };
                @endrole

                /**
                 * Establece la información del usuario a notificar
                 *
                 * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 */
                var setUserModalNotify = function(id) {
                    $('#modalSendNotification').find('#user').val(id);
                };

                /**
                 * Establece la información del usuario a enviar mensaje
                 *
                 * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 */
                var setUserModalMessage = function(id) {
                    $('#modalSendMessage').find('#user').val(id);
                }

                /**
                 * Establece los datos de un usuario
                 *
                 * @author    Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 *
                 * @param     {String}    id       Identificador del usuario
                 */
                var setUser = function(id) {
                    window.userId = id;
                }

                /**
                 * Registro de eventos del sistema
                 *
                 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 * @param  {string}  v  Vista
                 * @param  {integer} l  Línea
                 * @param  {string}  lg Mensaje
                 * @param  {string}  f  Función. Opcional
                 */
                var logs = function(v, l, e, f) {
                    var f = (typeof(f) !== "undefined") ? f : false;
                    var err = e.toJSON();
                    var p = {
                        view: v,
                        line: l,
                        code: e.response.status,
                        type: e.response.statusText,
                        message: err.message,
                        url: e.response.config.url,
                        method: e.response.config.method,
                        func: null
                    };
                    if (f) {
                        p.func = f;
                    }

                    if (window.debug) {
                        console.error("{{ __('Se ha generado un error con la siguiente información') }}:", p);
                        console.trace();
                    }
                    else {
                        axios.post(window.log_url, {
                            view: p.view,
                            line: p.line,
                            code: p.code,
                            type: p.type,
                            message: p.message,
                            url: p.url,
                            method: p.method,
                            func: p.func
                        });
                    }
                }

                /**
                 * Desbloquea la pantalla de la aplicación bloqueada por inactividad
                 *
                 * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
                 *
                 * @return     {boolean}     Devuelve falso si se ejecutan las instrucciones para desbloquear la pantalla
                 */
                var unlockScreen = async function() {
                    let username = $('.modal-lockscreen').find('#username');
                    let password = $('.modal-lockscreen').find('#password');
                    if (username.val() && password.val()) {
                        /** @type {Object} Datos con el */
                        let response = await axios.post('{{ route('unlockscreen') }}', {
                            username: username.val(),
                            password: password.val()
                        });


                        if (response.data.result) {
                            let new_csrf = response.data.new_csrf;
                            /** @type {Boolean} actualiza el estatus del bloqueo de pantalla */
                            window.screen_locked = false;
                            /** @type {String} Actualiza el token csrf de la página */
                            document.querySelector('meta[name="csrf-token"]').setAttribute('content', new_csrf);
                            //update any _token fields
                            /** Actualiza el token csrf de todos los formularios presentes en la página */
                            document.querySelectorAll('input[name="_token"]').forEach(function(csrf_field) {
                                csrf_field.setAttribute('value', new_csrf);
                            });
                            /** @type {Object} Actualiza el token csrf global */
                            window.Laravel = {
                                "csrfToken": new_csrf
                            };

                            /** Remueve la clase modalBlur usada para distorcionar el fondo de la pantalla de bloqueo */
                            $(document.body).removeClass('modalBlur');
                            /** Oculta la pantalla de bloqueo */
                            $(".modal-lockscreen").modal('hide');

                            app.lockscreen.time = 0;
                            app.lockscreen.lock = false;
                            clearTimeout(app._data.lockscreen.timer_timeout);
                            app.lockScreen();

                            return false;
                        }
                    }

                    $.gritter.add({
                        title: '{{ __('Alerta!') }}',
                        text: 'No ha indicado una contraseña correcta',
                        class_name: 'growl-danger',
                        image: "{{ asset('images/screen-error.png') }}",
                        sticky: false,
                        time: 2500
                    });
                }

                function fullScreen(elem) {
                    var elem = (typeof(elem) !== "undefined") ? elem : document.documentElement;
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.mozRequestFullScreen) { /* Firefox */
                        elem.mozRequestFullScreen();
                    } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) { /* IE/Edge */
                        elem.msRequestFullscreen();
                    }
                }
            </script>
        @endauth

        {{-- Sección para scripts extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-js')

        {{-- Sección que permite renderizar los componentes de VueJS --}}
        <script>
            /** @type {object} Constante que crea el elemento Vue */
            var app = new Vue({
                el: '#app',
            });
        </script>
    </body>
</html>
