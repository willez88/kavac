{{-- Gestión de nómina --}}
<li>
    <a href="#" title="Datos de personal y nómina" data-toggle="tooltip" data-placement="right">
        <i class="ion-ios-folder-outline"></i><span>Nómina</span>
    </a>
    <ul class="submenu" @if ($current_url=='payroll.index') style="display:block;" @endif>
        <li class="{!! ($current_url=='payroll.settings.index')?'active':'' !!}">
            <a href="{{ route('payroll.settings.index') }}" data-toggle="tooltip" data-placement="right"
                title="Configuración de nómina">Configuración</a>
        </li>
        <li>
            <a href="#">Expediente</a>
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
