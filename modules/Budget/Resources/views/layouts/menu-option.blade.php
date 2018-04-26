{{-- Gestión de presupuesto --}}
<li>
    <a href="#" title="Formulación y ejecución del presupuesto" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-arrow-graph-up-right"></i><span>Presupuesto</span>
    </a>
    <ul class="submenu">
        <li>
            <a href="#">Configuración</a>
        </li>
        <li>
            <a href="{{ route('budget.accounts.index') }}">Plan de Cuentas</a>
        </li>
        <li>
            <a href="#">Formulación</a>
        </li>
        <li>
            <a href="#">Ejecución</a>
        </li>
        <li>
            <a href="#">Reportes</a>
            <ul class="submenu">
                <li><a href="#">Mayor Análitico</a></li>
                <li><a href="#">Consolidado</a></li>
            </ul>
        </li>
    </ul>
</li>