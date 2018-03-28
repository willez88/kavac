<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/now-ui-kit.css') }}" rel="stylesheet">
    <style>
        @guest
            .input-group-addon {
                border-radius: 30px 0 0 30px;
            }
            .login-page .card-login .input-group:last-child {
                margin-bottom: 20px;
            }
            .bootstrap-switch.bootstrap-switch-off .bootstrap-switch-label {
                background-color: rgba(255, 255, 255, 0.4);
            }
        @endguest
        .cursor-pointer {
            cursor:pointer;
        }
    </style>
</head>
<body class="@guest login-page sidebar-collapse @endguest">
        @guest
    <div class="page-header" filter-color="orange">
        <div class="page-header-image" style="background-image:url({{ asset('images/auth-bg.jpg') }})"></div>
        <div class="container">
            <div class="col-md-4 content-center">
                <div class="card card-login card-plain">
                    <!--<form class="form" method="" action="">
                        <div class="header header-primary text-center">
                            <div class="logo-container">
                                <img src="../assets/img/now-logo.png" alt="">
                            </div>
                        </div>
                        <div class="content">
                            <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons users_circle-08"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="First Name...">
                            </div>
                            <div class="input-group form-group-no-border input-lg">
                                <span class="input-group-addon">
                                    <i class="now-ui-icons text_caps-small"></i>
                                </span>
                                <input type="text" placeholder="Last Name..." class="form-control" />
                            </div>
                        </div>
                        <div class="footer text-center">
                            <a href="#pablo" class="btn btn-primary btn-round btn-lg btn-block">Get Started</a>
                        </div>
                    </form>-->
                    @yield('content')
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <nav>
                    <ul>
                        <li>
                            <a href="https://www.cenditel.gob.ve">
                                CENDITEL
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Acerca de
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Blog
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Licencia
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright">
                    &copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script>, Desarrollado por 
                    <a href="https://www.cenditel.gob.ve" target="_blank">CENDITEL</a> nodo Mérida.
                </div>
            </div>
        </footer>
    </div>
        @else

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
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('extra-js')
</body>
</html>
