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
        <li class="{!! set_active_menu([
            'budget.subspecific-formulations.index', 'budget.subspecific-formulations.create', 'budget.subspecific-formulations.edit'
        ]) !!}">
            <a href="{{ route('budget.subspecific-formulations.index') }}" data-toggle="tooltip"
               data-placement="right" title="Gestión para la formulación de presupesto">
                Formulación
            </a>
        </li>
        <li class="{!! set_active_menu([
            'budget.aditional-credits.index', 'budget.aditional-credits.create', 'budget.aditional-credits.edit',
            'budget.reductions.index', 'budget.reductions.create', 'budget.reductions.edit',
            'budget.transfers.index', 'budget.transfers.create', 'budget.transfers.edit',
            'budget.modifications.index', 'budget.modifications.create', 'budget.modifications.edit'
        ]) !!}">
            <a href="{{ route('budget.modifications.index') }}" data-toggle="tooltip"
               title="Gestiona las modificaciones presupuestarias (créditos adicionales, reducciones, traspasos, etc.)">
                Modificaciones
            </a>
        </li>
        <li class="{!! set_active_menu([
            'budget.compromises.index', 'budget.compromises.create', 'budget.compromises.edit'
        ]) !!}">
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
               title="Gestión sobre la ejecución de presupuesto">
                Ejecución
            </a>
            @php
                $submenuCompromises = '';
                if (
                    in_array(
                        Route::current()->getName(), [
                            'budget.compromises.index', 'budget.compromises.create', 'budget.compromises.edit'
                        ]
                    )
                ) {
                    $submenuCompromises = 'style="display:block"';
                }
            @endphp
            <ul class="submenu" {!! $submenuCompromises !!}>
                <li class="{!! set_active_menu([
                    'budget.compromises.index', 'budget.compromises.create', 'budget.compromises.edit'
                ]) !!}">
                    <a href="{{ route('budget.compromises.index') }}" data-toggle="tooltip" data-placement="right"
                       title="Gestiona los compromisos presupuestarios">
                        Compromisos
                    </a>
                </li>
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
