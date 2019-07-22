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
            <a href="#">Requermientos</a>
        </li>
        <li>
            <a href="#">Cotización</a>
        </li>
        <li>
            <a href="#">Acta</a>
        </li>
        <li>
            <a href="#">Orden de Compra / Servicio</a>
        </li>
        <li>
            <a href="#">Reintegro</a>
        </li>
    </ul>
</li>