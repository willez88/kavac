<div class="main-panel">
	<div class="content-header-map">
        <div class="media">
            <div class="pageicon float-left">
                @section('maproute-icon')
                    <i class="ion-ios-speedometer"></i>
                @show
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{ route('index') }}">
                            @section('maproute-icon-mini')
                                <i class="ion-ios-speedometer"></i>
                            @show
                        </a>
                    </li>
                    <li>@yield('maproute-actual', 'Panel de Control')</li>
                </ul>
                <h4>@yield('maproute-title', 'Panel de Control')</h4>
            </div>
        </div>
    </div>
    <div class="app-content" id="app">
    	@yield('content')
    </div>
    <footer class="footer footer-default">
        @include('layouts.footer')
    </footer>
</div>