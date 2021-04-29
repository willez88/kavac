{{-- Gestión de comercialización --}}
<li>
    <a href="#" title="Gestión de comercialización" data-toggle="tooltip" data-placement="right">
        <i class="ion ion-briefcase"></i><span>Comercialización</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('sale') !!}">
         <li class="{!! set_active_menu('sale.settings.index') !!}">
            <a href="/sale/settings" data-toggle="tooltip" data-placement="right" 
               title="Configuración de Comercialización">Configuración</a>
        </li>
        <li class="{!! set_active_menu('sale.services.index') !!}">
            <a href="/sale/services" data-toggle="tooltip" data-placement="right" 
               title="Solicitud de servicios">Solicitud de servicios</a>
        </li>
        <li class="{!! set_active_menu('sale.bill.index') !!}">
            <a href="/sale/bills" data-toggle="tooltip" data-placement="right" 
               title="Facturas">Facturas</a>
        </li>
        <li class="{!! set_active_menu('sale.reception.index') !!}">
            <a href="/sale/receptions" data-toggle="tooltip" data-placement="right"
               title="Recepciones de almacén">Recepciones de almacén</a>
        </li>
        <li>
            <a href="javascript:void(0)"
               data-toggle="tooltip" data-placement="right"
               title="Gestiona la generación de reportes del módulo de comercialización">
                    Reportes
            </a>
            <ul class="submenu" style="{!! display_submenu('report') !!}">
                <li title="Reporte de inventario de productos de almacén"
                    data-toggle="tooltip" data-placement="right">
                    <a href="/sale/reports/inventory-products">Inventario de productos</a>
                </li>
                <li title="Reporte de pedidos"
                    data-toggle="tooltip" data-placement="right">
                    <a href="/sale/reports/orders">Pedidos</a>
                </li>
            </ul>
        </li>
    </ul>
</li>
