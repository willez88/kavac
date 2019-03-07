{{-- Gestión de presupuesto --}}
<li>
    <a href="#" title="Formulación y ejecución del presupuesto" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-arrow-graph-up-right"></i><span>Presupuesto</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('budget') !!}">
        <li class="{!! set_active_menu('budget.settings.index') !!}">
            <a href="{{ route('budget.settings.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Configuración de presupuesto">Configuración</a>
        </li>
        <li class="{!! set_active_menu(['budget.accounts.index', 'budget.accounts.create', 'budget.accounts.edit']) !!}">
            <a href="{{ route('budget.accounts.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Gestión del clasificador de cuentas presupuestarias">
                Clasificador Presupuestario
            </a>
        </li>
        <li class="">
            <a href="{{ route('budget.subspecific-formulations.index') }}" data-toggle="tooltip" 
               data-placement="right" title="Gestión para la formulación de presupesto">
                Formulación
            </a>
        </li>
        <li>
            <a href="#" title="Gestiona las modificaciones presupuestarias (créditos adicionales, reducciones, traspasos, etc.)" data-toggle="tooltip" data-placement="right">Modificaciones</a>
            <ul class="submenu">
                <li><a href="{{ route('budget.aditional-credits.index') }}">Cŕeditos Adicionales</a></li>
                <li><a href="#">Reducciones</a></li>
                <li><a href="#">Traspasos</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Ejecución</a>
            <ul class="submenu">
                <li><a href="#">Compromisos</a></li>
            </ul>
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