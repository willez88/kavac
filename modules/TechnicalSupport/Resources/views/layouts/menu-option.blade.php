{{-- Gestión de soporte técnico --}}
<li>
    <a href="javascript:void(0)" title="Gestión de soporte técnico" data-toggle="tooltip"
       data-placement="right">
        <i class="icofont icofont-fix-tools"></i><span>Soporte Técnico</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('technicalsupport') !!}">
        <li class="{!! set_active_menu('technicalsupport.setting.index') !!}"
            data-toggle="tooltip"
            data-placement="right"
            title="Configuración de soporte técnico">
            <a href="{{ route('technicalsupport.setting.index') }}">Configuración</a>
        </li>

        <li class="{!! set_active_menu('technicalsupport.requests.index') !!}"
            data-toggle="tooltip"
            data-placement="right"
            title="Gestión de las solicitudes a soporte técnico">
            <a href="{{ route('technicalsupport.requests.index') }}">Solicitudes</a>
        </li>
        <li class="{!! set_active_menu('technicalsupport.repairs.index') !!}"
            data-toggle="tooltip"
            data-placement="right"
            title="Gestión de reparaciones de avería de bienes institucionales">
            <a href="{{ route('technicalsupport.repairs.index') }}">Reparaciones</a>
        </li>
    </ul>
</li>
