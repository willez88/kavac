<div class="left-panel">
	<div class="media profile-left">
        @php
            $prf = auth()->user()->profile;
            $img_profile = ($prf && $prf->image_id) ? $prf->image->url : null;
        @endphp
        <a class="float-left profile-thumb" href="{{ url('users') . "/" . Auth::user()->id }}">
            <img class="img-circle img-profile-mini" src="{{ asset($img_profile ?? 'images/default-avatar.png') }}"
                 alt="{{ auth()->user()->name }}">
        </a>
        <div class="media-body">
            <h4 class="media-heading">{{ Auth::user()->name }}</h4>
            <small class="text-muted">{{-- Cargo --}}</small>
        </div>
    </div>
    @if (Auth::user()->hasVerifiedEmail())
        <h5 class="navigation-panel-title text-center">{{ __('MENU') }}</h5>
        <div id="jquery-accordion-menu" class="jquery-accordion-menu white">
            {{-- <div class="jquery-accordion-menu-header">Header </div> --}}
            <ul>
                {{-- Acceso al panel de control del usuario --}}
                <li class="{!! set_active_menu('index') !!}">
                    <a href="{{ route('index') }}" title="{{ __('Panel de control del usuario') }}"
                       data-toggle="tooltip" data-placement="right">
                        <i class="ion-ios-speedometer-outline"></i><span>{{ __('Panel de control') }}</span>
                    </a>
                </li>
                @role('admin')
                    {{-- Acceso a la configuración de la aplicación --}}
                    <li>
                        <a href="javascript:void(0)" title="{{ __('Gestión de configuración') }}"
                           data-toggle="tooltip" data-placement="right">
                            <i class="ion-settings"></i><span>{{ __('Configuración') }}</span>
                        </a>
                        @php
                            $submenu = '';
                            if (in_array(Route::current()->getName(), ['settings.index', 'access.settings'])) {
                                $submenu = 'style="display:block"';
                            }
                        @endphp
                        <ul class="submenu" {!! $submenu !!}>
                            <li class="{!! set_active_menu('settings.index') !!}">
                                <a href="{{ route('settings.index') }}" data-toggle="tooltip" data-placement="right"
                                   title="{{ __('Configuración general de la aplicación') }}">
                                    {{ __('General') }}
                                </a>
                            </li>
                            <li class="{!! set_active_menu('access.settings') !!}">
                                <a href="" title="{{ __('Gestión de usuarios, roles y permisos') }}"
                                   data-toggle="tooltip" data-placement="right">
                                    {{ __('Acceso') }}
                                </a>
                                <ul class="submenu">
                                    <li class="{!! set_active_menu('access.settings') !!}" data-toggle="tooltip"
                                        title="{{ __('Gestión de roles y permisos del sistema') }}"
                                        data-placement="right">
                                        <a href="{{ route('access.settings') }}">
                                            {{ __('Roles') }} / {{ __('Permisos') }}
                                        </a>
                                    </li>
                                    <li class="{!! set_active_menu('access.settings.users') !!}" data-toggle="tooltip"
                                        title="{{ __('Gestión de usuarios del sistema') }}" data-placement="right">
                                        <a href="{{ route('access.settings.users') }}">{{ __('Usuarios') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{!! set_active_menu('module.list') !!}">
                                <a href="{{ route('module.list') }}" title="{{ __('Gestión de módulos del sistema') }}"
                                   data-toggle="tooltip" data-placement="right">
                                    {{ __('Módulos') }}
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
                    @foreach (\Module::collections(1) as $module)
                        {{-- Menú de opciones de módulos instalados y habilitados --}}
                        @includeIf(strtolower($module->getName()) . '::layouts.menu-option')
                    @endforeach

                    <li>
                        <a href="javascript:void(0)" title="{{ __('Gestión de cuentas por pagar') }}"
                           data-toggle="tooltip" data-placement="right">
                            <i class="ion-ios-paper-outline"></i><span>{{ __('Cuentas Por Pagar') }}</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="javascript:void(0)">{{ __('Ordenes de Pago') }}</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">{{ __('Reportes') }}</a>
                                <ul class="submenu">
                                    <li><a href="javascript:void(0)">{{ __('Reporte 1') }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __('Reporte 2') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    {{-- Gestión de cuentas por cobrar --}}
                    <li>
                        <a href="javascript:void(0)" title="{{ __('Gestión de cuentas por cobrar') }}"
                           data-toggle="tooltip" data-placement="right">
                            <i class="ion-ios-paper-outline"></i><span>{{ __('Cuentas Por Cobrar') }}</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="javascript:void(0)">{{ __('Configuración') }}</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">{{ __('Clientes') }}</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">{{ __('Facturas') }}</a>
                            </li>
                            <li>
                                <a href="javascript:void(0)">{{ __('Reportes') }}</a>
                                <ul class="submenu">
                                    <li><a href="javascript:void(0)">{{ __('Reporte 1') }}</a></li>
                                    <li><a href="javascript:void(0)">{{ __('Reporte 2') }}</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    {{-- Cierre de ejercicio económico --}}
                    <li>
                        <a href="javascript:void()" title="{{ __('Cierre de ejercicio actual') }}"
                           data-toggle="tooltip" data-placement="right">
                            <i class="ion-lock-combination"></i><span>{{ __('Cierre de Ejercicio') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
            {{-- <div class="jquery-accordion-menu-footer">Footer </div> --}}
        </div>
    @endif
</div>
