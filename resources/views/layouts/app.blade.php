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
        {{-- Estilos de Plugins --}}
        {{-- Select2 --}}
        {!! Html::style('vendor/select2/css/select2.min.css') !!}
        {{-- Datatable --}}
        {!! Html::style('vendor/datatable/css/dataTables.bootstrap4.min.css') !!}
        {!! Html::style('vendor/datatable/responsive/css/responsive.bootstrap4.min.css') !!}

        {{-- Sección para estilos extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-css')
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

        {{-- Scripts --}}
        {{-- Plugin Sliders --}}
        {!! Html::script('js/nouislider.min.js') !!}
        {{-- Scripts de la aplicación --}}
        {!! Html::script('js/app.js') !!}
        {{-- Plugin Bootbox --}}
        {!! Html::script('js/bootbox.min.js') !!}
        {{-- Plugin Select2 --}}
        {!! Html::script('vendor/select2/js/select2.full.min.js') !!}
        {{-- Plugin Datatable --}}
        {!! Html::script('vendor/datatable/js/jquery.dataTables.min.js') !!}
        {!! Html::script('vendor/datatable/js/dataTables.bootstrap4.min.js') !!}
        {!! Html::script('vendor/datatable/js/dataTables.responsive.min.js') !!}
        {!! Html::script('vendor/datatable/js/responsive.bootstrap4.min.js') !!}

        {{-- Sección para scripts extras dispuestos por las plantillas según requerimientos particulares --}}
        @yield('extra-js')
    </body>
</html>
