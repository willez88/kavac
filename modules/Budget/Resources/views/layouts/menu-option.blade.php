{{-- Gestión de presupuesto --}}
<li>
    <a href="#" title="Formulación y ejecución del presupuesto" data-toggle="tooltip" 
       data-placement="right">
        <i class="ion-arrow-graph-up-right"></i><span>Presupuesto</span>
    </a>
    <ul class="submenu" style="{!! (strpos($current_url, 'budget') !== false)?'display:block;':'' !!}">
        <li class="{!! set_active_menu($current_url, 'budget.settings.index') !!}">
            <a href="{{ route('budget.settings.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Configuración de presupuesto">Configuración</a>
        </li>
        <li class="{!! set_active_menu($current_url, ['budget.accounts.index', 'budget.accounts.create', 'budget.accounts.edit']) !!}">
            <a href="{{ route('budget.accounts.index') }}" data-toggle="tooltip" data-placement="right" 
               title="Gestión del clasificador de cuentas presupuestarias">
                Clasificador Presupuestario
            </a>
        </li>
        <li class="">
            <a href="#" data-toggle="tooltip" data-placement="right" 
               title="Gestión en la formulación de presupesto">
                Formulación
            </a>
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