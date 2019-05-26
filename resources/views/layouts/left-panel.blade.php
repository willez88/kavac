<div class="left-panel">
	<div class="media profile-left">
            @php
                $prf = auth()->user()->profile;
                $img_profile = ($prf && $prf->image_id) ? $prf->image->url : null;
            @endphp
            <a class="float-left profile-thumb" href="{{ url('users') . "/" . Auth::user()->id }}">
                <img class="img-circle img-profile-mini" 
                     src="{{ asset($img_profile ?? 'images/default-avatar.png') }}" 
                     alt="{{ auth()->user()->name }}">
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
            {{-- Acceso al panel de control del usuario --}}
			<li class="{!! set_active_menu('index') !!}">
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
                        @if (Route::current()->getName()=='settings.index' || Route::current()->getName()=='access.settings')
                            style="display:block;"
                        @endif>
                        <li class="{!! set_active_menu('settings.index') !!}">
                            <a href="{{ route('settings.index') }}" title="Configuración general de la aplicación" 
                               data-toggle="tooltip" data-placement="right">
                                General
                            </a>
                        </li>
                        <li class="{!! set_active_menu('access.settings') !!}">
                            <a href="{{ route('access.settings') }}" title="Gestión de usuarios, roles y permisos" 
                               data-toggle="tooltip" data-placement="right">
                                Acceso
                            </a>
                        </li>
                        <li class="{!! set_active_menu('module.list') !!}">
                            <a href="{{ route('module.list') }}" title="Gestión de módulos del sistema" 
                               data-toggle="tooltip" data-placement="right">
                                Módulos
                            </a>
                        </li>
                    </ul>
                </li>
            @endrole
            
            @if (count(App\Models\Institution::where('active', true)->get()) > 0)
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
                {{-- Menú de opciones del módulo de finanzas --}}
                @include('finance::layouts.menu-option')
                {{-- Menú de opciones del módulo de contabilidad --}}
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
                            <a href="#">Facturas</a>
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
            @endif
		</ul>
		{{-- <div class="jquery-accordion-menu-footer">Footer </div> --}}
	</div>
</div>