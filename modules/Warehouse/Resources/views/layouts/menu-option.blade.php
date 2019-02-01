{{-- Gestión de Almacén --}}
<li>
    <a href="#" title="Gestión de artículos e inventario" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-ios-list-outline"></i><span>Almacén</span>
    </a>
    <ul class="submenu" style="{!! (strpos($current_url, 'warehouse') !== false)?'display:block;':'' !!}">
        <li class="{!! set_active_menu($current_url, 'warehouse.setting.index') !!}">
            <a href="{{ route('warehouse.setting.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Configuración de almacén">Configuración</a>
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