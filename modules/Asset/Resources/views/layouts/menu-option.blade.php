{{-- Gestión de bienes --}}
<li>
    <a href="#" title="Gestión de bienes institucionales" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-ios-pricetags-outline"></i><span>Bienes</span>
    </a>
    <ul class="submenu"
        @if ($current_url=='asset.index')
            style="display:block;"
        @endif
        @if ($current_url=='asset.asignation.index')
            style="display:block;"
        @endif
        @if ($current_url=='asset.desincorporation.index')
            style="display:block;"
        @endif>
         <li class="{!! ($current_url=='asset.setting.index')?'active':'' !!}">
            <a href="{{ route('asset.setting.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Configuración de bienes">Configuración</a>
        </li>
        
        <li title="Gestión de registros de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.index')?'active':'' !!}'>
            <a href="{{ route('asset.index') }}">Registrar</a>
        </li>
        <li title="Gestión de asignaciones de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.asignation.index')?'active':'' !!}'>
            <a href="{{ route('asset.asignation.index') }}">Asignar</a>
        </li>
        <li title="Gestión de Desincorporaciones de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.disincorporation.index')?'active':'' !!}'>
            <a href="{{ route('asset.disincorporation.index') }}">Desincorporación</a>
        </li>
        
        <li title="Gestión de asignaciones de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.request.index')?'active':'' !!}'>
            <a href="{{ route('asset.request.index') }}">Solicitud</a>
        </li>
        <li>
            <a href="#">Reportes</a>
            <ul class="submenu">
                <li title="Reportes de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.report.index')?'active':'' !!}'>
                    <a href="{{ route('asset.report.index',1) }}">General</a>
                </li>
                <li title="Reportes de bienes institucionales" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.report.index')?'active':'' !!}'>
                    <a href="{{ route('asset.report.index',2) }}">Por Clasificación</a>
                </li>
            </ul>
        </li>
    </ul>
</li>