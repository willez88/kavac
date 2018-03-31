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
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        {{-- <link href="{{ asset('css/now-ui-kit.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet"> --}}
        <link href="{{ asset('vendor/select2/css/select2.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('vendor/datatable/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/datatable/responsive/css/responsive.bootstrap4.min.css') }}">
    </head>
    <body class="@guest login-page sidebar-collapse @endguest">
        @guest
            <div class="page-header" filter-color="orange">
                <div class="page-header-image"></div>
                <div class="container">
                    <div class="col-md-4 content-center">
                        <div class="card card-login card-plain">
                            @yield('content')
                        </div>
                    </div>
                </div>
                <footer class="footer">
                    <div class="container">
                        <nav>
                            <ul>
                                <li>
                                    <a href="https://www.cenditel.gob.ve">CENDITEL</a>
                                </li>
                                <li>
                                    <a href="" class="about_app">Acerca de</a>
                                </li>
                                <li>
                                    <a href="#">Blog</a>
                                </li>
                                <li>
                                    <a href="" class="license_app">Licencia</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="copyright">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>, Desarrollado por 
                            <a href="https://www.cenditel.gob.ve" target="_blank">CENDITEL</a> nodo Mérida.
                        </div>
                    </div>
                </footer>
            </div>
        @else
            @include('layouts.navbar')
            <div class="content-wrapper">
                @include('layouts.left-panel')
                @include('layouts.content')
            </div>
        @endguest

        {{-- Scripts --}}
        <script src="{{ asset('js/nouislider.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/bootbox.min.js') }}"></script>
        <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('vendor/datatable/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('vendor/datatable/js/responsive.bootstrap4.min.js') }}"></script>
        @yield('extra-js')
    </body>
</html>
