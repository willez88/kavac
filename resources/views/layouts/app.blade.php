<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>KAVAC | Sistema de Gestión Administrativa</title>

        {{-- Estilos de la aplicación --}}
        {!! Html::style('css/app.css') !!}
        {{-- Icofont --}}
        {!! Html::style('css/icofont.css') !!}
        {{-- Estilos de Plugins --}}
        {{-- Datatable --}}
        {!! Html::style('vendor/datatable/css/dataTables.bootstrap4.min.css') !!}
        {!! Html::style('vendor/datatable/css/jquery.dataTables.min.css') !!}
        {!! Html::style('vendor/datatable/css/select.dataTables.min.css') !!}
        {!! Html::style('vendor/datatable/css/buttons.dataTables.min.css') !!}
        {!! Html::style('vendor/datatable/responsive/css/responsive.bootstrap4.min.css') !!}
        {{-- Hoja de estilo para los mensajes de la aplicación (requerida) --}}
        {!! Html::style('vendor/jquery.gritter/css/jquery.gritter.css') !!}

        <script>
            window.access = true;
            window.log_url = '{{ route('logs.front-end') }}';
        </script>

        {{-- Sección para estilos extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-css')
    </head>
    <body class="@guest login-page sidebar-collapse @endguest">
        {{-- Ventana modal para mostrar mensaje de espera mientras cargan los datos --}}
        @include('layouts.loading-message')

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

        {{-- Scripts --}}
        {{-- Plugin Sliders --}}
        {!! Html::script('js/nouislider.min.js') !!}
        {{-- Scripts de la aplicación --}}
        {!! Html::script('js/generic-classes.js') !!}
        {!! Html::script('js/app.js') !!}
        {{-- Plugin Bootbox --}}
        {!! Html::script('js/bootbox.min.js') !!}
        {{-- Plugin Datatable --}}
        {!! Html::script('vendor/datatable/js/jquery.dataTables.min.js') !!}
        {!! Html::script('vendor/datatable/js/dataTables.select.min.js') !!}
        {!! Html::script('vendor/datatable/js/dataTables.buttons.min.js') !!}
        {!! Html::script('vendor/datatable/js/dataTables.bootstrap4.min.js') !!}
        {!! Html::script('vendor/datatable/js/dataTables.responsive.min.js') !!}
        {!! Html::script('vendor/datatable/js/responsive.bootstrap4.min.js') !!}
        {{-- Plugin Gritter --}}
        {!! Html::script('vendor/jquery.gritter/js/jquery.gritter.min.js') !!}
        {{-- Botón de ir al inicio de la página cuando se excede de un alto preestablecido --}}
        @include('buttons.to-top')
        
        <script>
            $(document).ready(function() {
                @if (session('message'))
                    {{-- Mensajes de la aplicación --}}
                    var msg_title = '', msg_text = '', msg_class = '', msg_icon = '';
                    msg_title = 'Éxito';
                    msg_icon = 'screen-ok';
                    msg_class = 'growl-success';
                    @if (session('message')['type'] == 'store')
                        msg_text = 'Registro almacenado con éxito';
                    @elseif (session('message')['type'] == 'update')
                        msg_text = 'Registro actualizado con éxito';
                    @elseif (session('message')['type'] == 'destroy')
                        msg_text = 'Registro eliminado con éxito';
                    @elseif (session('message')['type'] == 'restore')
                        msg_text = 'Registro restaurado con éxito';
                    @elseif (session('message')['type'] == 'deny')
                        msg_title = 'Acceso Denegado';
                        msg_icon = 'screen-error';
                        msg_class = 'growl-danger';
                        msg_text = 'Usted no tiene acceso a la petición solicitada';
                        @if (session('message')['msg'])
                            msg_text = '{!! session('message')['msg'] !!}';
                        @endif
                    @elseif (session('message')['type'] == 'other')
                        msg_icon = 'screen-info';
                        @if (isset(session('message')['title']))
                            msg_title = '{!! session('message')['title'] !!}';
                        @endif
                        @if (isset(session('message')['icon']))
                            msg_icon = '{!! session('message')['icon'] !!}';
                        @endif
                        @if (isset(session('message')['class']))
                            msg_class = '{!! session('message')['class'] !!}';
                        @endif
                        msg_text = "{{ session('message')['text'] }}";
                    @endif
                    $.gritter.add({
                        title: msg_title,
                        text: msg_text,
                        class_name: msg_class,
                        image: "{{ asset('images') }}/" + msg_icon + ".png",
                        sticky: false,
                        time: 1500
                    });
                @endif

                @role('admin')
                    @if (App\Models\Institution::all()->isEmpty())
                        $.gritter.add({
                            title: 'Alerta!',
                            text: "Para comenzar a utilizar la aplicación debe configurar una Institución",
                            class_name: 'growl-danger',
                            image: "{{ asset('images/screen-error.png') }}",
                            sticky: false,
                            time: 2500
                        });
                    @endif
                @endrole
            });

            /*
             * Función que permite eliminar registros mediante ajax
             * 
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             * @param {string} url URL del controlador que realiza la acción de eliminación
             * @return Un mensaje al usuario solicitando confirmación de la eliminación del registro
             */
            function delete_record(url) {
                bootbox.confirm('Esta seguro de querer eliminar este registro?', function (result) {
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
                                        title: 'Alerta!',
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
                                bootbox.alert('Error interno del servidor al eliminar el registro.');
                                logs('app', 160, `Error con la petición solicitada. Detalles: ${err}`);
                            }
                        });
                    }
                });
            }

            /**
             * Actualiza información de un select a partir de otro
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             * @param  {integer} parent_id      Identificador del select padre que ejecuta la acción
             * @param  {object}  target_element Objeto que se cargara con la información
             * @param  {string}  target_model   Modelo en el cual se va a realizar la consulta
             * @param  {string}  module_name    Nombre del módulo que ejecuta la acción
             */
            function updateSelect(parent_id, target_element, target_model, module_name) {
                var module_name = (typeof(module_name) !== "undefined")?'/' + module_name:'';
                
                target_element.select2({
                    ajax: {
                        url: '/get-select-data/' + parent_id + '/' + target_model + module_name,
                        dataType: 'json',
                        type: "GET",
                        data: function (params) {
                            return {
                                q: params.term // search term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data
                            };
                        },
                        cache: true,
                        /*processResults: function(data) {
                            return {
                                results: data.items
                            }
                        }*/
                    }
                });
            }

            /**
             * Permite restaurar registros eliminados del sistema
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             * @param  {string} url URL que recibe la petición y ejecuta la acción
             */
            function undelete_record(url) {
                bootbox.confirm('Esta seguro de querer restaurar este registro?', function (result) {
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
                                bootbox.alert('Error interno del servidor al restaurar el registro.');
                                logs('app', 234, `Error con la petición solicitada. Detalles: ${err}`, 'undelete_record');
                            }
                        });
                    }
                });
            }

            @role('admin')
                /**
                 * Muestra información relacionada a un usuario
                 *
                 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
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
                        logs('app', 272, error, 'view_user_info');
                    });
                };
            @endrole

            /**
             * Registro de eventos del sistema
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             * @param  {string}  v  Vista
             * @param  {integer} l  Línea
             * @param  {string}  lg Mensaje
             * @param  {string}  f  Función. Opcional
             */
            var logs = function(v, l, lg, f) {
                var f = (typeof(f) !== "undefined") ? f : false;
                var p = {
                    v: v,
                    l: l,
                    lg: lg
                };
                if (f) {
                    p.f = f;
                }
                axios.post(window.log_url, p).catch(error => {
                    log('app', 297, error);
                });
            }
        </script>

        {{-- Sección para scripts extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-js')
    </body>
</html>
