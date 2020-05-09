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
        <li>
            <a href="#">Facturas</a>
        </li>
        <li>
            <a href="#">Reportes</a>
        </li>
    </ul>
</li>
