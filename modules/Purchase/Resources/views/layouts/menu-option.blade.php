{{-- Gestión de compras --}}
<li>
    <a href="#" title="Gestión de compras de bienes y servicios" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-social-dropbox-outline"></i><span>Compras</span>
    </a>
    <ul class="submenu" style="{!! (strpos($current_url, 'purchase') !== false)?'display:block;':'' !!}">
        <li>
            <a href="#">Configuración</a>
        </li>
        <li>
            <a href="#" title="Gestión de Proveedores" data-toggle="tooltip" data-placement="right">
                Proveedores
            </a>
        </li>
        <li>
            <a href="#">Requisición</a>
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