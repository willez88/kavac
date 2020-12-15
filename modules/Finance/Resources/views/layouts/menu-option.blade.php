{{-- Gestión de finanzas --}}
<li>
    <a href="#" title="Gestión de bancos y finanzas" data-toggle="tooltip" data-placement="right">
        <i class="ion-ios-calculator-outline"></i><span>Finanzas</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('finance') !!}">
        <li class="{!! set_active_menu('finance.setting.index') !!}">
            <a href="{{ route('finance.setting.index') }}">Configuración</a>
        </li>
        <li>
            <a href="#">Movimientos bancarios</a>
        </li>
        <li>
            <a href="#">Cuentas por Pagar</a>
        </li>
        <li>
            <a href="#">Emisión de Cheques</a>
        </li>
        <!--<li>
            <a href="#">Reportes</a>
            <ul class="submenu">
                <li><a href="#">Voucher</a></li>
                <li><a href="#"></a></li>
            </ul>
        </li>-->
    </ul>
</li>
