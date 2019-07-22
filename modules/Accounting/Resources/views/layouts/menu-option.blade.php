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
            <a href="{{ route('accounting.converter.index') }}">Convertidor de Cuentas</a>
        </li>
        <li>
            <a href="{{ route('accounting.seating.index') }}">Asientos Contables</a>
        </li>
        <li>
            <a href="">Reportes</a>
            <ul class="submenu">
                <li><a href="{{ route('accounting.report.accountingBooks') }}">Libros Contables</a></li>
                <li><a href="{{ route('accounting.report.financeStatements') }}">Estados Financieros</a></li>
            </ul>
        </li>
    </ul>
</li>