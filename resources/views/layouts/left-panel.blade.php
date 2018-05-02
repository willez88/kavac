<div class="left-panel">
	<div class="media profile-left">
            <a class="float-left profile-thumb" href="{{ url('users') . "/" . Auth::user()->id }}">
                <img class="img-circle" src="{{ asset('images/default-avatar.png') }}" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading">{{ Auth::user()->name }}</h4>
                <small class="text-muted">{{-- Cargo --}}</small>
            </div>
        </div>
    <h5 class="navigation-panel-title text-center">MENU</h5>
    <div id="jquery-accordion-menu" class="jquery-accordion-menu white">
		{{-- <div class="jquery-accordion-menu-header">Header </div> --}}
		<ul>
            @php
                $current_url = Route::current()->getName();
            @endphp
            {{-- Acceso al panel de control del usuario --}}
			<li class="{!! ($current_url=='index')?'active':'' !!}">
                <a href="{{ route('index') }}" title="Panel de control del usuario" 
                   data-toggle="tooltip" data-placement="right">
                    <i class="ion-ios-speedometer-outline"></i><span>Panel de control</span>
                </a>
            </li>
            @role('admin')
                {{-- Acceso a la configuración de la aplicación --}}
                <li>
                    <a href="#" title="Gestión de configuración" data-toggle="tooltip" data-placement="right">
                        <i class="ion-settings"></i><span>Configuración</span>
                    </a>
                    <ul class="submenu" 
                        @if ($current_url=='settings.index' || $current_url=='access.settings')
                            style="display:block;"
                        @endif>
                        <li class="{!! ($current_url=='settings.index')?'active':'' !!}">
                            <a href="{{ route('settings.index') }}" title="Configuración general de la aplicación" 
                               data-toggle="tooltip" data-placement="right">
                                General
                            </a>
                        </li>
                        <li class="{!! ($current_url=='access.settings')?'active':'' !!}">
                            <a href="{{ route('access.settings') }}" title="Gestión de usuarios, roles y permisos" 
                               data-toggle="tooltip" data-placement="right">
                                Acceso
                            </a>
                        </li>
                    </ul>
                </li>
            @endrole
            {{-- Gestión de beneficiarios --}}
            {{-- <li>
                <a href="#" title="Gestión de beneficiarios" data-toggle="tooltip" data-placement="right">
                    <i class="ion-ios-people-outline"></i><span>Beneficiarios</span>
                </a>
            </li> --}}
            {{-- Menú de opciones del módulo de firma digital --}}
            @include('digitalsignature::layouts.menu-option')
            {{-- Menú de opciones del módulo de nómina --}}
            @include('payroll::layouts.menu-option')
            {{-- Menú de opciones del módulo de presupuesto --}}
            @include('budget::layouts.menu-option')
            {{-- Menú de opciones del módulo de compras --}}
            @include('purchase::layouts.menu-option')
            {{-- Menú de opciones del módulo de almacén --}}
            @include('warehouse::layouts.menu-option')
            {{-- Menú de opciones del módulo de bienes --}}
            @include('asset::layouts.menu-option')
            {{-- Gestión de finanzas --}}
            <li>
                <a href="#" title="Gestión de bancos y finanzas" data-toggle="tooltip" data-placement="right">
                    <i class="ion-ios-calculator-outline"></i><span>Finanzas</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="#">Banco</a>
                    </li>
                    <li>
                        <a href="#">Emisión de Cheques</a>
                    </li>
                    <li>
                        <a href="#">Reportes</a>
                        <ul class="submenu">
                            <li><a href="#">Reporte 1</a></li>
                            <li><a href="#">Reporte 2</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            @include('accounting::layouts.menu-option')
            {{-- Gestión de cuentas por pagar --}}
            <li>
                <a href="#" title="Gestión de cuentas por pagar" data-toggle="tooltip" data-placement="right">
                    <i class="ion-ios-paper-outline"></i><span>Cuentas Por Pagar</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="#">Impuestos</a>
                    </li>
                    <li>
                        <a href="#">Deducciones</a>
                    </li>
                    <li>
                        <a href="#">Ordenes de Pago</a>
                    </li>
                    <li>
                        <a href="#">Reportes</a>
                        <ul class="submenu">
                            <li><a href="#">Reporte 1</a></li>
                            <li><a href="#">Reporte 2</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- Gestión de cuentas por cobrar --}}
            <li>
                <a href="#" title="Gestión de cuentas por cobrar" data-toggle="tooltip" data-placement="right">
                    <i class="ion-ios-paper-outline"></i><span>Cuentas Por Cobrar</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="#">Configuración</a>
                    </li>
                    <li>
                        <a href="#">Clientes</a>
                    </li>
                    <li>
                        <a href="#">Pacturas</a>
                    </li>
                    <li>
                        <a href="#">Reportes</a>
                        <ul class="submenu">
                            <li><a href="#">Reporte 1</a></li>
                            <li><a href="#">Reporte 2</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- Cierre de ejercicio económico --}}
            <li>
                <a href="#" title="Cierre de ejercicio actual" data-toggle="tooltip" data-placement="right">
                    <i class="ion-lock-combination"></i><span>Cierre de Ejercicio</span>
                </a>
            </li>
		</ul>
		{{-- <div class="jquery-accordion-menu-footer">Footer </div> --}}
	</div>
</div>