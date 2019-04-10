{{-- Gestión de bienes --}}
<li>
    <a href="#" title="Gestión de bienes institucionales" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-ios-pricetags-outline"></i><span>Bienes</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('asset') !!}">

         <li class="{!! set_active_menu('asset.setting.index') !!}">
            <a href="{{ route('asset.setting.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Configuración de bienes">Configuración</a>
        </li>
        
        <li title="Gestión de registros de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu(['asset.index', 'asset.create', 'asset.edit']) !!}'>
            <a href="{{ route('asset.index') }}">Registros</a>
        </li>
       
        <li title="Gestión de asignaciones de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu(['asset.asignation.index','asset.asignation.create','asset.asignation.edit']) !!}'>
            <a href="{{ route('asset.asignation.index') }}">Asignaciones</a>
        </li>
        
        <li title="Gestión de Desincorporaciones de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu(['asset.desincorporation.index','asset.desincorporation.create','asset.desincorporation.edit']) !!}'>
            <a href="{{ route('asset.disincorporation.index') }}">Desincorporaciones</a>
        </li>
        
        <li title="Gestión de solicitudes de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu(['asset.request.index','asset.request.create','asset.request.edit']) !!}'>
            <a href="{{ route('asset.request.index') }}">Solicitudes</a>
        </li>
        <li data-toggle="tooltip" data-placement="right"
                        title="Gestiona la generación de reportes de bienes institucionales (general, por clasificación, etc.)">
            <a href="#">Reportes</a>
            
            <ul class="submenu" style="{!! display_submenu('report') !!}">
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