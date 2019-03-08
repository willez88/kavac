{{-- Gestión de nómina --}}
<li>
    <a href="#" title="Datos de personal y nómina" data-toggle="tooltip" data-placement="right">
        <i class="ion-ios-folder-outline"></i><span>Nómina</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('payroll') !!}">
        <li class="{!! set_active_menu('payroll.settings.index') !!}">
            <a href="{{ route('payroll.settings.index') }}" data-toggle="tooltip" data-placement="right"
                title="Configuración de nómina">Configuración</a>
        </li>
        <li class="{!! set_active_menu('staff.index') !!}">
            <a href="{{ route('staffs.index') }}" data-toggle="tooltip" data-placement="right"
                title="Expediente del personal">Expediente</a>
        </li>
        <li>
            <a href="#">Registros de Nómina</a>
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
