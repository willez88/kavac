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
                    'employments'
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
                <li class="{!! set_active_menu(['payroll.employments.index']) !!}">
                    <a href="{{ route('payroll.employments.index') }}">Datos Laborales</a>
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
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
                title="Gestiona las solicitudes de vacaciones, prestaciones y constancias.">Solicitudes</a>
            <ul class="submenu" style="{!! display_submenu(['vacation-requests', 'benefits-requests', 'permission-requests']) !!}">
                <li class="{!! set_active_menu(['payroll.vacation-requests.index']) !!}">
                    <a href="{{ route('payroll.vacation-requests.index') }}">Solicitud de vacaciones</a>
                </li>
                <li class="{!! set_active_menu(['payroll.benefits-requests.index']) !!}">
                    <a href="{{ route('payroll.benefits-requests.index') }}">Solicitud de prestaciones</a>
                </li>
                <li class="{!! set_active_menu(['payroll.permission-requests.index']) !!}">
                    <a href="{{ route('payroll.permission-requests.index') }}">Solicitud de permisos</a>
                </li>
            </ul>

        <li>
            <a href="javascript:void(0)" data-toggle="tooltip" data-placement="right"
                title="Gestiona la generación de reportes de resumen de disfrute de vacaciones, estatus de vacaciones, cálculo del bono vacacional e histórico de pago de bono vacacional.">Reportes</a>
            <ul class="submenu" style="{!! display_submenu('reports') !!}">
                <li title="Reporte del resumen de disfrute de vacaciones"
                    data-toggle="tooltip" data-placement="right"
                    class="{!! set_active_menu('payroll.reports.vacation-enjoyment-summaries') !!}">
                    <a href="{{ route('payroll.reports.vacation-enjoyment-summaries') }}">
                        Disfrute de vacaciones
                    </a>
                </li>
                <li title="Reporte del estatus de vacaciones"
                    data-toggle="tooltip" data-placement="right"
                    class="{!! set_active_menu('payroll.reports.vacation-status') !!}">
                    <a href="{{ route('payroll.reports.vacation-status') }}">
                        Estatus de vacaciones
                    </a>
                </li>
                 <li title="Reporte del status del empleado"
                    data-toggle="tooltip" data-placement="right"
                    class="{!! set_active_menu('payroll.reports.employment-status') !!}">
                    <a href="{{ route('payroll.reports.employment-status') }}">
                         Reporte detallado de trabajadores
                    </a>
                </li>
                <li title="Reporte del cálculo de bono vacacional"
                    data-toggle="tooltip" data-placement="right"
                    class="{!! set_active_menu('payroll.reports.vacation-status') !!}">
                    <a href="{{ route('payroll.reports.vacation-bonus-calculations') }}">
                        Cálculo de bono vacacional
                    </a>
                </li>
                <li><a href="#">Pago de bono vacacional</a></li>
                <!--
                <li title="Reporte de acumulado de prestaciones sociales"
                    data-toggle="tooltip" data-placement="right"
                    class="{!! set_active_menu('payroll.reports.benefits.benefit-advances') !!}">
                    <a href="{{ route('payroll.reports.benefits.benefit-advances') }}">
                        Acumulado de prestaciones sociales
                    </a>
                </li> -->

            </ul>

        </li>
    </ul>
</li>
