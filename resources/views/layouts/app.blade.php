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
        {!! Html::style('css/app.css', [], Request::secure()) !!}
        {{-- Icofont --}}
        {!! Html::style('css/icofont.css', [], Request::secure()) !!}
        {{-- Estilos de Plugins --}}
        {{-- Datatable --}}
        {!! Html::style(
            'vendor/datatable/css/dataTables.bootstrap4.min.css', [], Request::secure()
        ) !!}
        {!! Html::style('vendor/datatable/css/jquery.dataTables.min.css', [], Request::secure()) !!}
        {!! Html::style('vendor/datatable/css/select.dataTables.min.css', [], Request::secure()) !!}
        {!! Html::style(
            'vendor/datatable/css/buttons.dataTables.min.css', [], Request::secure()
        ) !!}
        {!! Html::style(
            'vendor/datatable/responsive/css/responsive.bootstrap4.min.css', [], Request::secure()
        ) !!}
        {{-- Hoja de estilo para los mensajes de la aplicación (requerida) --}}
        {!! Html::style('vendor/jquery.gritter/css/jquery.gritter.css', [], Request::secure()) !!}

        @yield('modules-css')
        <script>
            /** @type {boolean} Define si la condición de acceso */
            window.access = true;
            /** @type {string} Define la URI para el registro de eventos del sistema */
            window.log_url = '{{ route('logs.front-end') }}';
            /** @type {boolean} Define si el usuario se encuentra o no autenticado en el sistema */
            window.auth = {!! (auth()->check()) ? 'true' : 'false' !!};
            /** @type {boolean} Define si la aplicación se encuentra o no en módo de desarrollo */
            window.debug = {!! (config('app.debug')) ? 'true' : 'false' !!};
            /** @type {string} Define la URI de la aplicación */
            window.app_url = `${location.protocol}//${location.host}`;
            @auth
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
    <body class="@guest login-page sidebar-collapse @endguest">
        @auth
            {{-- Ventana modal para mostrar mensaje de espera mientras cargan los datos --}}
            @include('layouts.loading-message')
        @endauth

        @section('custom-page')
            @guest
                <div class="page-header" filter-color="orange">
                    <div class="page-header-image"></div>
                    <div class="container">
                        <div class="col-md-4 content-center">
                            <div class="card card-login card-plain" id="app">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    <footer class="footer">
                        @include('layouts.footer')
                    </footer>
                </div>
            @else
                @include('layouts.navbar')
                <div class="content-wrapper">
                    @include('layouts.left-panel')
                    @include('layouts.content')
                </div>
            @endguest
        @show

        @yield('modals')
        {{-- Scripts --}}
        {{-- Plugin Sliders --}}
        {!! Html::script('js/nouislider.min.js', [], Request::secure()) !!}
        {{-- Scripts de la aplicación --}}
        {!! Html::script('js/generic-classes.js', [], Request::secure()) !!}
        {!! Html::script('js/app.js', [], Request::secure()) !!}
        {!! Html::script('js/shared-components.js', [], Request::secure()) !!}
        @yield('modules-js')

        {{-- Plugin Bootbox --}}
        {!! Html::script('js/bootbox.min.js', [], Request::secure()) !!}
        {{-- Plugin Datatable --}}
        {!! Html::script('vendor/datatable/js/jquery.dataTables.min.js', [], Request::secure()) !!}
        {!! Html::script('vendor/datatable/js/dataTables.select.min.js', [], Request::secure()) !!}
        {!! Html::script('vendor/datatable/js/dataTables.buttons.min.js', [], Request::secure()) !!}
        {!! Html::script(
            'vendor/datatable/js/dataTables.bootstrap4.min.js', [], Request::secure()
        ) !!}
        {!! Html::script(
            'vendor/datatable/js/dataTables.responsive.min.js', [], Request::secure()
        ) !!}
        {!! Html::script(
            'vendor/datatable/js/responsive.bootstrap4.min.js', [], Request::secure()
        ) !!}
        {{-- Plugin Gritter --}}
        {!! Html::script(
            'vendor/jquery.gritter/js/jquery.gritter.min.js', [], Request::secure()
        ) !!}
        {{-- Scripts comúnes --}}
        {!! Html::script('js/common.js', [], Request::secure()) !!}

        {{-- Botón de ir al inicio de la página cuando se excede de un alto preestablecido --}}
        @include('buttons.to-top')

        @include('layouts.messages')
        <script>
            $(document).ready(function() {
                if ($('.ckeditor').length && typeof(CkEditor) !== 'undefined') {
                    $('.ckeditor').each(function() {
                        CkEditor.create(document.querySelector('.ckeditor'), {
                            toolbar: [
                                'heading', '|',
                                'bold', 'italic', 'blockQuote', 'link',
                                'numberedList', 'bulletedList', '|',
                                'insertTable', 'tableColumn', 'tableRow', 'mergeTableCells', '|',
                                'undo', 'redo'
                            ],
                            language: '{{ app()->getLocale() }}',
                        }).then(editor => {
                            window.editor = editor;
                            // Descomentar para entornos de desarrollo
                            //console.log(Array.from( window.editor.ui.componentFactory.names() ));
                        }).catch(error => {
                            logs('app', 143, error);
                        });

                    });
                }

                /** Previene el uso de carácteres no permitidos en campos numéricos */
                $(".numeric").on('input keypress keyup blur', function(event) {
                    $(this).val($(this).val().replace(/[^\d].+/, ""));
                    if ((event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });
                /** Previene el uso de carácteres no permitidos en campos de monedas */
                $(".currency").on('input keypress keyup blur', function(event) {
                    $(this).val($(this).val().replace(/[^0-9\.]/g, ""));
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });

                /** oculta el mensaje de carga al renderizar por completo el DOM de la página */
                $('.preloader').fadeOut(1000);
            });
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

            /*try {
                throw new HandleJSError('app', {
                    'message': 'prueba'
                });
            } catch(e) {
                console.log(e);
                console.log(e.fileName)
                console.warn("error");
                console.log(e.lineNumber)
                console.log(e.name);
                console.log(e.view);
                console.log(e.message);
                console.log(e.stack.split("\n"));
                console.log(e.date);
            }*/
        </script>

        {{-- Sección para scripts extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-js')
        {{-- Sección que permite renderizar los componentes de VueJS --}}
        <script defer>
            /** @type {object} Constante que crea el elemento Vue */
            var app = new Vue({
                el: '#app',
            });

            if ($("#app-nav").length) {
                var appNav = new Vue({
                    el: '#app-nav',
                });
            }
        </script>
        <script>
            Echo.channel('home').listen('NewMessage', (e) => {
                console.log("entro");
                console.log(e.message);
            });
        </script>
    </body>
</html>
