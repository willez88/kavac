{{-- Gestión de Almacén --}}
@php
    $paramMultiWarehouse = App\Models\Parameter::where([
            'active' => true, 'required_by' => 'warehouse',
            'p_key' => 'multi_warehouse', 'p_value' => 'true'
        ])->first();
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

        <li class="{!! set_active_menu(['warehouse.reception.index','warehouse.reception.create','warehouse.reception.edit']) !!}" data-toggle="tooltip" data-placement="right"
                title="Gestión de las Recepciones o Ingresos de artículos al Almacén">

            <a  href="{{ route('warehouse.reception.index') }}">
                Recepciones de Almacén</a>
        </li>

        <li class="{!! set_active_menu(['warehouse.request.index','warehouse.request.create','warehouse.request.edit']) !!}" data-toggle="tooltip" data-placement="right" 
               title="Solicitudes de almacén">
            
            <a href="{{ route('warehouse.request.index') }}">
                Solicitudes de Almacén</a>
        </li>

        @if(!is_null($paramMultiWarehouse)&&($paramMultiWarehouse->p_value == true))
        <li class="{!! set_active_menu(['warehouse.movement.index','warehouse.movement.create','warehouse.movement.edit']) !!}" data-toggle="tooltip" data-placement="right"
                title="Gestión de los Movimientos de artículos entre Almacenes">

            <a  href="/warehouse/movements">
                Movimientos de Almacén
            </a>
        </li>
        @endif
        <li data-toggle="tooltip" data-placement="right"
                        title="Gestiona la generación de reportes del inventario de almacenes (por producto, por almacén.)">
            <a href="#">Reportes</a>
            <ul class="submenu" style="{!! display_submenu('report') !!}">
                <li title="Reporte de Inventario de Productos de Almacén" data-toggle="tooltip"
            data-placement="right"
            class='{!! set_active_menu('warehouse.report.create') !!}'>
                    <a href="{{ route('warehouse.report.create') }}">Inventario de Productos</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
