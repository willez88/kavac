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
            <a href="{{ route('accounting.accounts.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Gestión del clasificador de cuentas patrimoniales">Cuentas Patrimoniales</a>
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
                <li><a href="{{ route('accounting.report.BalanceCheckUp') }}">Balance de Comprobación</a></li>
                <li><a href="{{ route('accounting.report.analyticalMajor') }}">Mayor Analítico</a></li>
                <li><a href="{{ route('accounting.report.diaryBook') }}">Libro Diario</a></li>
                <li><a href="{{ route('accounting.report.auxiliaryBook') }}">Libro Auxiliar</a></li>
                <li><a href="{{ route('accounting.report.balanceSheet') }}">Balance General</a></li>
                <li><a href="{{ route('accounting.report.stateOfResults') }}">Estado de Resultados</a></li>
            </ul>
        </li>
    </ul>
</li>