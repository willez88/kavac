<div class="main-panel">
	<div class="content-header-map">
        <div class="media">
            <div class="pageicon float-left">
                <i class="fa fa-home"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                    <li>Dashboard</li>
                </ul>
                <h4>Dashboard</h4>
            </div>
        </div>
    </div>
    <div class="app-content">
    	@yield('content')
    </div>
    <footer class="footer footer-default">
        @include('layouts.footer')
    </footer>
</div>