{{-- Gestión de Almacén --}}
@php
    $paramMultiWarehouse = App\Models\Parameter::where([
            'active' => true, 'required_by' => 'warehouse',
            'p_key' => 'multi_warehouse', 'p_value' => 'true'
        ])->first();
@endphp
<li>
    <a href="javascript:void(0)" title="Gestión de artículos e inventario"
       data-toggle="tooltip" data-placement="right">
        <i class="ion-ios-list-outline"></i><span>Almacén</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('warehouse') !!}">
        @role(['admin','warehouse'])
            <li class="{!! set_active_menu('warehouse.setting.index') !!}"
                data-toggle="tooltip" data-placement="right" 
                title="Configuración de almacén">            
                <a href="{{ route('warehouse.setting.index') }}">
                    Configuración
                </a>
            </li>
        @endrole
        <li class="{!! set_active_menu(
                [
                    'warehouse.reception.index',
                    'warehouse.reception.create',
                    'warehouse.reception.edit'
                ]) !!}"
            data-toggle="tooltip" data-placement="right"
            title="Gestión de las recepciones o ingresos de artículos al almacén">
            <a  href="{{ route('warehouse.reception.index') }}">
                Recepciones de almacén
            </a>
        </li>
        <li class="{!! set_active_menu(
                [
                    'warehouse.request.index',
                    'warehouse.request.create',
                    'warehouse.request.edit'
                ]) !!}"
            data-toggle="tooltip" data-placement="right" 
            title="Gestión de las solicitudes artículos al almacén">
            <a href="{{ route('warehouse.request.index') }}">
                Solicitudes de Almacén
            </a>
        </li>
        @if(!is_null($paramMultiWarehouse)&&($paramMultiWarehouse->p_value == true))
            <li class="{!! set_active_menu(
                    [
                        'warehouse.movement.index',
                        'warehouse.movement.create',
                        'warehouse.movement.edit'
                    ]) !!}"
                data-toggle="tooltip" data-placement="right"
                title="Gestión de los movimientos de artículos entre almacenes">
                <a  href="/warehouse/movements">
                    Movimientos de almacén
                </a>
            </li>
        @endif
        <li>
            <a href="javascript:void(0)"
               data-toggle="tooltip" data-placement="right"
               title="Gestiona la generación de reportes del módulo de almacén">
                    Reportes
            </a>
            <ul class="submenu" style="{!! display_submenu('report') !!}">
                <li title="Reporte de inventario de productos de almacén"
                    data-toggle="tooltip" data-placement="right"
                    class='{!! set_active_menu('warehouse.report.inventory-products') !!}'>
                    <a href="{{ route('warehouse.report.inventory-products') }}">Inventario de productos</a>
                </li>
                <li title="Reporte de inventario de productos de almacén"
                    data-toggle="tooltip" data-placement="right"
                    class='{!! set_active_menu('warehouse.report.request-products') !!}'>
                    <a href="{{ route('warehouse.report.request-products') }}">Solicitudes de productos</a>
                </li>
                <li title="Reporte de stocks mínimo y máximo de almacén"
                    data-toggle="tooltip" data-placement="right"
                    class='{!! set_active_menu('warehouse.report.stocks') !!}'>
                    <a href="{{ route('warehouse.report.stocks') }}">Stocks mínimo y máximo</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
