{{-- Gestión de bienes --}}
<li>
    <a href="#" title="Gestión de bienes institucionales" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-ios-pricetags-outline"></i><span>Bienes</span>
    </a>
    <ul class="submenu"
        @if (Route::current()->getName()=='asset.index')
            style="display:block;"
        @endif
        @if (Route::current()->getName()=='asset.asignation.index')
            style="display:block;"
        @endif
        @if (Route::current()->getName()=='asset.desincorporation.index')
            style="display:block;"
        @endif>
         <li class="{!! set_active_menu('asset.setting.index') !!}">
            <a href="{{ route('asset.setting.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Configuración de bienes">Configuración</a>
        </li>
        
        <li title="Gestión de registros de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu('asset.index') !!}'>
            <a href="{{ route('asset.index') }}">Registros</a>
        </li>
        <li title="Gestión de asignaciones de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu('asset.asignation.index') !!}'>
            <a href="{{ route('asset.asignation.index') }}">Asignaciones</a>
        </li>
        <li title="Gestión de Desincorporaciones de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu('asset.desincorporation.index') !!}'>
            <a href="{{ route('asset.disincorporation.index') }}">Desincorporaciones</a>
        </li>
        
        <li title="Gestión de solicitudes de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu('asset.request.index') !!}'>
            <a href="{{ route('asset.request.index') }}">Solicitudes</a>
        </li>
        <li>
            <a href="#">Reportes</a>
            <ul class="submenu">
                <li title="Reportes Generales de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu('asset.report.create') !!}'>
                    <a href="{{ route('asset.report.create',1) }}">General</a>
                </li>
                <li title="Reportes por clasificación de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu('asset.report.create') !!}'>
                    <a href="{{ route('asset.report.create',2) }}">Por Clasificación</a>
                </li>
            </ul>
        </li>
    </ul>
</li>