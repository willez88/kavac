<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KAVAC | Sistema de Gestión Administrativa') }}</title>

        {{-- Estilos de la aplicación --}}
        {!! Html::style('css/app.css') !!}
        {{-- Icofont --}}
        {!! Html::style('css/icofont.css') !!}
        {{-- Estilos de Plugins --}}
        {{-- Datatable --}}
        {!! Html::style('vendor/datatable/css/dataTables.bootstrap4.min.css') !!}
        {!! Html::style('vendor/datatable/responsive/css/responsive.bootstrap4.min.css') !!}
        {{-- Hoja de estilo para los mensajes de la aplicación (requerida) --}}
        {!! Html::style('vendor/jquery.gritter/css/jquery.gritter.css') !!}

        {{-- Sección para estilos extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-css')
    </head>
    <body class="@guest login-page sidebar-collapse @endguest">
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

        {{-- Ventana modal para mostrar mensaje de espera mientras cargan los datos --}}
        @include('layouts.loading-message')
        {{-- Scripts --}}
        {{-- Plugin Sliders --}}
        {!! Html::script('js/nouislider.min.js') !!}
        {{-- Scripts de la aplicación --}}
        {!! Html::script('js/app.js') !!}
        {{-- Plugin Bootbox --}}
        {!! Html::script('js/bootbox.min.js') !!}
        {{-- Plugin Datatable --}}
        {!! Html::script('vendor/datatable/js/jquery.dataTables.min.js') !!}
        {!! Html::script('vendor/datatable/js/dataTables.bootstrap4.min.js') !!}
        {!! Html::script('vendor/datatable/js/dataTables.responsive.min.js') !!}
        {!! Html::script('vendor/datatable/js/responsive.bootstrap4.min.js') !!}
        {{-- Plugin Gritter --}}
        {!! Html::script('vendor/jquery.gritter/js/jquery.gritter.min.js') !!}

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
                        time: ''
                    });
                @endif
            });
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
                            },
                            error: function error(jqxhr, textStatus, _error) {
                                var err = textStatus + ", " + _error;
                                bootbox.alert('Error interno del servidor al eliminar el registro.');
                                console.log('Error con la petición solicitada. Detalles: ' + err);
                            }
                        });
                    }
                });
            }
        </script>

        {{-- Sección para scripts extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-js')
    </body>
</html>
