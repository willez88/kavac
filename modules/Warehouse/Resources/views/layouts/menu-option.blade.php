{{-- Gestión de Almacén --}}
@php
    $setting = App\Models\Setting::where('active',true)->first();
@endphp
<li>
    <a href="#" title="Gestión de artículos e inventario" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-ios-list-outline"></i><span>Almacén</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('warehouse') !!}">
        
        <li class="{!! set_active_menu('warehouse.setting.index') !!}" data-toggle="tooltip" data-placement="right" 
            title="Configuración de almacén">            
            <a href="{{ route('warehouse.setting.index') }}">Configuración</a>
        </li>

        <li class="{!! set_active_menu(['warehouse.request.index','warehouse.request.create','warehouse.request.edit']) !!}" data-toggle="tooltip" data-placement="right" 
               title="Solicitudes de almacén">
            
            <a href="{{ route('warehouse.request.index') }}">
                Solicitudes de Almacén</a>
        </li>

        <li class="{!! set_active_menu(['warehouse.reception.index','warehouse.reception.create','warehouse.reception.edit']) !!}" data-toggle="tooltip" data-placement="right"
                title="Gestión de las Recepciones o Ingresos de artículos al Almacén">

            <a  href="{{ route('warehouse.reception.index') }}">
                Recepciones de Almacén</a>
        </li>

        @if(($setting)&&($setting->multi_warehouse))
        <li class="{!! set_active_menu(['warehouse.movement.index','warehouse.movement.create','warehouse.movement.edit']) !!}" data-toggle="tooltip" data-placement="right"
                title="Gestión de los Movimientos de artículos entre Almacenes">

            <a  href="/warehouse/movements">
                Movimientos de Almacén
            </a>
        </li>
        @endif
        <li>
            <a href="#">Reportes</a>
            <ul class="submenu">
                <li><a href="#">Reporte 1</a></li>
                <li><a href="#">Reporte 2</a></li>
            </ul>
        </li>
    </ul>
</li>