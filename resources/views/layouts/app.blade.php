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
        <style>
            @guest
                .login-page .card-login .input-group:last-child {
                    margin-bottom: 20px;
                }
                .login-page .page-header .page-header-image {
                    background-image:url({{ asset('images/auth-bg.jpg') }});
                }
                .bootstrap-switch.bootstrap-switch-off .bootstrap-switch-label {
                    background-color: rgba(255, 255, 255, 0.4);
                }
            @endguest
            .input-group-addon {
                border-radius: 30px 0 0 30px;
            }
            .cursor-pointer {
                cursor:pointer;
            }
            .vertical-middle {
                margin:10px auto;
            }
        </style>
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
            <!--<nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse" aria-expanded="false">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <ul class="nav navbar-nav navbar-right">
                            @guest
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>-->

            

        <!-- Scripts -->
        <script src="{{ asset('js/nouislider.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/bootbox.min.js') }}"></script>
        <script src="{{ asset('vendor/select2/js/select2.full.min.js') }}"></script>
        <script src="{{ asset('vendor/datatable/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('vendor/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('vendor/datatable/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('vendor/datatable/js/responsive.bootstrap4.min.js') }}"></script>
        <script>
            $(document).ready(function() {
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
                        '</ul>'
                    );
                });

                $('.license_app').on('click', function(e) {
                    e.preventDefault();
                    bootbox.alert(
                        '<h6>LICENCIA | Copyleft <i class="fa fa-copyright"></i></h6>' + 
                        '<p>La aplicación, salvo aquellos paquetes de tercero con licenciamiento personalizado excluyentes de esta aplicación, se distribuye bajo los terminos de licenciamiento GPL v3.</p>' +
                        '<p>Esto quiere decir que eres libre de copiarla, estudiarla, modificarla y/o distribuirla.<p>'
                    );
                });
            });
        </script>
        @yield('extra-js')
    </body>
</html>
