{{-- Gestión de presupuesto --}}
<li>
    <a href="#" title="{{ __('Formulación y ejecución del presupuesto') }}" data-toggle="tooltip"
       data-placement="right">
        <i class="ion-arrow-graph-up-right"></i><span>{{ __('Presupuesto') }}</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('budget') !!}">
        <li class="{!! set_active_menu('budget.settings.index') !!}">
            <a href="{{ route('budget.settings.index') }}" data-toggle="tooltip" data-placement="right"
               title="{{ __('Configuración de presupuesto') }}">{{ __('Configuración') }}</a>
        </li>
        <li class="{!! set_active_menu(['budget.accounts.index', 'budget.accounts.create', 'budget.accounts.edit']) !!}">
            <a href="{{ route('budget.accounts.index') }}" data-toggle="tooltip" data-placement="right"
               title="{{ __('Gestión del clasificador de cuentas presupuestarias') }}">
                {{ __('Clasificador Presupuestario') }}
            </a>
        </li>
        <li class="{!! set_active_menu([
            'budget.subspecific-formulations.index', 'budget.subspecific-formulations.create',
            'budget.subspecific-formulations.edit'
        ]) !!}">
            <a href="{{ route('budget.subspecific-formulations.index') }}" data-toggle="tooltip"
               data-placement="right" title="{{ __('Gestión para la formulación de presupesto') }}">
                {{ __('Formulación') }}
            </a>
        </li>
        <li class="{!! set_active_menu([
            'budget.aditional-credits.index', 'budget.aditional-credits.create', 'budget.aditional-credits.edit',
            'budget.reductions.index', 'budget.reductions.create', 'budget.reductions.edit',
            'budget.transfers.index', 'budget.transfers.create', 'budget.transfers.edit',
            'budget.modifications.index', 'budget.modifications.create', 'budget.modifications.edit'
        ]) !!}">
            <a href="{{ route('budget.modifications.index') }}" data-toggle="tooltip"
               title="{{ __('Gestiona las modificaciones presupuestarias (créditos adicionales, reducciones, traspasos, etc.)') }}">
                {{ __('Modificaciones') }}
            </a>
        </li>
        <li class="{!! set_active_menu([
            'budget.compromises.index', 'budget.compromises.create', 'budget.compromises.edit'
        ]) !!}">
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
               title="{{ __('Gestión sobre la ejecución de presupuesto') }}">
                {{ __('Ejecución') }}
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
                       title="{{ __('Gestiona los compromisos presupuestarios') }}">
                        {{ __('Compromisos') }}
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="javascript:void(0)">{{ __('Reportes') }}</a>
            <ul class="submenu">
                <li><a href="javascript:void(0)">{{ __('Mayor Análitico') }}</a></li>
                <li><a href="javascript:void(0)">{{ __('Consolidado') }}</a></li>
            </ul>
        </li>
    </ul>
</li>
