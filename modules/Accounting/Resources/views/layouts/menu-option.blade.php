{{-- Gestión de contabilidad --}}
<li>
    <a href="#" title="Gestión de asientos contables" data-toggle="tooltip" data-placement="right">
        <i class="ion-social-buffer-outline"></i><span>Contabilidad</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('accounting') !!}">
        <li>
            <a href="{{ route('accounting.settings.index') }}">
                <i></i>Configuración
            </a>
        </li>
        <li>
            <a href="{{ route('accounting.converter.index') }}">Convertidor de cuentas</a>
        </li>
        <li>
            <a href="{{ route('accounting.entries.index') }}">Asientos contables</a>
        </li>
        <li>
            <a href="javascript:void(0)">Reportes</a>
            <ul class="submenu">
                <li><a href="{{ route('accounting.report.accountingBooks') }}" data-toggle="tooltip" data-placement="right">Libros contables</a></li>
                <li><a href="{{ route('accounting.report.financeStatements') }}" data-toggle="tooltip" data-placement="right">Estados financieros</a></li>
            </ul>
        </li>
        <li>
            <a href="{{ route('accounting.dashboard.test') }}">Panel de control</a>
        </li>
    </ul>
</li>
