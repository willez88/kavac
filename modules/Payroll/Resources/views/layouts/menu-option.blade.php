{{-- Gestión de nómina --}}
<li>
    <a href="javascript:void(0)" title="Datos de personal y nómina"
       data-toggle="tooltip" data-placement="right">
        <i class="ion-ios-folder-outline"></i><span>Talento Humano</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('payroll') !!}">
        <li class="{!! set_active_menu(['payroll.settings.index']) !!}">
            <a href="{{ route('payroll.settings.index') }}" data-toggle="tooltip" data-placement="right"
                title="Configuración de nómina">Configuración</a>
        </li>
        <li class="{!! set_active_menu(['payroll.salary-adjustments.create']) !!}">
            <a href="{{ route('payroll.salary-adjustments.create') }}"
               data-toggle="tooltip" data-placement="right"
               title="Gestiona las actualizaciones de tablas salariales, de acuerdo a un aumento oficial de salarios.">
                Ajustes en Tablas Salariales
            </a>
        </li>
        <li>
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
                title="Expediente del personal">Expediente</a>
            <ul class="submenu" style="{!! display_submenu([
                    'staffs', 'socioeconomics', 'professionals',
                    'employment-informations'
                ]) !!}">
                <li class="{!! set_active_menu(['payroll.staffs.index', 'payroll.staffs.create', 'payroll.staffs.edit']) !!}">
                    <a href="{{ route('payroll.staffs.index') }}">Datos Personales</a>
                </li>
                <li class="{!! set_active_menu(['payroll.professionals.index']) !!}">
                    <a href="{{ route('payroll.professionals.index') }}">Datos Profesionales</a>
                </li>
                <li class="{!! set_active_menu(['payroll.socioeconomics.index']) !!}">
                    <a href="{{ route('payroll.socioeconomics.index') }}">Datos Socioeconómicos</a>
                </li>
                <li class="{!! set_active_menu(['payroll.employment-informations.index']) !!}">
                    <a href="{{ route('payroll.employment-informations.index') }}">Datos Laborales</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('payroll.registers.index') }}" data-toggle="tooltip"
               data-placement="right" title="Gestión de registros de la relación de pago de la nómina.">
                Registros de Nómina
            </a>
        </li>
        <li>
            <a href="javascript:void(0)">Reportes</a>
            <ul class="submenu">
                <li><a href="#">Reporte 1</a></li>
                <li><a href="#">Reporte 2</a></li>
            </ul>
        </li>
    </ul>
</li>
