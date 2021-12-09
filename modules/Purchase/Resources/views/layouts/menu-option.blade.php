{{-- Gestión de compras --}}
<li>
    <a href="#" title="Gestión de compras de bienes y servicios" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-social-dropbox-outline"></i><span>Compras</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('purchase') !!}">
        <li class="{!! set_active_menu('purchase.settings.index') !!}">
            <a href="{{ route('purchase.settings.index') }}" data-toggle="tooltip" 
               data-placement="right" title="Configuración de compras">
                Configuración
            </a>
        </li>
        <li class="{!! set_active_menu([
            'purchase.suppliers.index', 'purchase.suppliers.create', 'purchase.suppliers.edit'
            ]) !!}">
            <a href="{{ route('purchase.suppliers.index') }}" 
               title="Gestión de Proveedores" data-toggle="tooltip" data-placement="right">
                Proveedores
            </a>
        </li>
        <li>
            <a href="{{ route('purchase.requirements.index') }}"
                title="Gestión de Requerimientos" data-toggle="tooltip" data-placement="right"
                >Requerimientos
            </a>
        </li>
        <li>
            <a href="{{ route('purchase.purchase_plans.index') }}"
                title="Gestión de plan de compra" data-toggle="tooltip" data-placement="right">
                Plan de compra
            </a>
        </li>
        <li>
            <a href="{{ route('purchase.quotation.index') }}"
                title="Gestión de cotizaciones" data-toggle="tooltip" data-placement="right">
                Cotización
            </a>
        </li>
        <li>
            <a href="#">Acta</a>
        </li>
        <li>
            <a href="{{ route('purchase.purchase_order.index') }}"
                title="Gestión de ordenes de compra" data-toggle="tooltip" data-placement="right">
                Orden de compra / servicio
            </a>
        </li>
        <li>
            <a href="#">Reintegro</a>
        </li>
    </ul>
</li>
