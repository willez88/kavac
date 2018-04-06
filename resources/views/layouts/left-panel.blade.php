<div class="left-panel">
	<div class="media profile-left">
            <a class="float-left profile-thumb" href="profile.html">
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
            {{-- Acceso a la configuración de la aplicación --}}
            <li class="{!! ($current_url=='settings.index')?'active':'' !!}">
                <a href="{{ route('settings.index') }}" title="Configuración de la aplicación" data-toggle="tooltip" data-placement="right">
                    <i class="ion-settings"></i><span>Configuración</span>
                </a>
            </li>
            {{-- Gestión de beneficiarios --}}
            <li>
                <a href="#" title="Gestión de beneficiarios" data-toggle="tooltip" data-placement="right">
                    <i class="ion-ios-people-outline"></i><span>Beneficiarios</span>
                </a>
            </li>
            {{-- Gestión de proveedores --}}
            <li>
                <a href="#" title="Gestión de Proveedores" data-toggle="tooltip" data-placement="right">
                    <i class="ion-social-dropbox-outline"></i><span>Proveedores</span>
                </a>
            </li>
            {{-- Gestión de presupuesto --}}
            <li>
                <a href="#" title="Formulación y ejecución del presupuesto" data-toggle="tooltip" 
                   data-placement="right">
                    <i class="ion-arrow-graph-up-right"></i><span>Presupuesto</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="#">Configuración</a>
                    </li>
                    <li>
                        <a href="#">Plan de Cuentas</a>
                    </li>
                    <li>
                        <a href="#">Formulación</a>
                    </li>
                    <li>
                        <a href="#">Ejecución</a>
                    </li>
                    <li>
                        <a href="#">Reportes</a>
                        <ul class="submenu">
                            <li><a href="#">Mayor Análitico</a></li>
                            <li><a href="#">Consolidado</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            {{-- Gestión de compras --}}
            <li>
                <a href="#" title="Gestión de compras de bienes y servicios" data-toggle="tooltip" 
                   data-placement="right">
                    <i class="ion-ios-cart-outline"></i><span>Compras</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="#">Configuración</a>
                    </li>
                    <li>
                        <a href="#">Requisición</a>
                    </li>
                    <li>
                        <a href="#">Cotización</a>
                    </li>
                    <li>
                        <a href="#">Acta</a>
                    </li>
                    <li>
                        <a href="#">Orden de Compra / Servicio</a>
                    </li>
                    <li>
                        <a href="#">Reintegro</a>
                    </li>
                </ul>
            </li>
            {{-- Gestión de Almacén --}}
            <li>
                <a href="#" title="Gestión de artículos e inventario" data-toggle="tooltip" 
                   data-placement="right">
                    <i class="ion-ios-list-outline"></i><span>Almacén</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="#">Apertura / Cierre</a>
                    </li>
                    <li>
                        <a href="#">Solicitud</a>
                    </li>
                    <li>
                        <a href="#">Inventario</a>
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
            {{-- Gestión de bienes --}}
            <li>
                <a href="#" title="Gestión de bienes institucionales" data-toggle="tooltip" 
                   data-placement="right">
                    <i class="ion-ios-pricetags-outline"></i><span>Bienes</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="#">Clasificador</a>
                    </li>
                    <li>
                        <a href="#">Registro</a>
                    </li>
                    <li>
                        <a href="#">Desincorporación</a>
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
            {{-- Gestión de nómina --}}
            <li>
                <a href="#" title="Datos de personal y nómina" data-toggle="tooltip" data-placement="right">
                    <i class="ion-ios-folder-outline"></i><span>Nómina</span>
                </a>
                <ul class="submenu">
                    <li>
                        <a href="#">Configuración</a>
                    </li>
                    <li>
                        <a href="#">Expediente</a>
                    </li>
                    <li>
                        <a href="#">Registros de Nómina</a>
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