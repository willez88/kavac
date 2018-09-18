{{-- Gestión de bienes --}}
<li>
    <a href="#" title="Gestión de bienes institucionales" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-ios-pricetags-outline"></i><span>Bienes</span>
    </a>
    <ul class="submenu"
        @if ($current_url=='asset.clasification.index')
            style="display:block;"
        @endif
        @if ($current_url=='asset.assets.index')
            style="display:block;"
        @endif
        @if ($current_url=='asset.asignation.index')
            style="display:block;"
        @endif
        @if ($current_url=='asset.requests.index')
            style="display:block;"
        @endif>
        <li class='{!! ($current_url=='asset.clasification.index')?'active':'' !!}'>
            <a href="{{ route('asset.clasification.index') }}">Clasificador</a>
        </li>

        <li title="Registrar nuevo bien institucional" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.assets.index')?'active':'' !!}'>
            <a href="{{ route('asset.index') }}">Registrar</a>
        </li>

        <li title="Asignar bien institucional" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.asignation.index')?'active':'' !!}'>
            <a href="{{ route('asset.asignation.index') }}">Asignar</a>
        </li>

        <li title="Solicitudes de Equipos institucional" data-toggle="tooltip"
            data-placement="right"
            class='{!! ($current_url=='asset.requests.index')?'active':'' !!}'>
            <a href="{{ route('asset.requests.index') }}">Solicitudes</a>
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