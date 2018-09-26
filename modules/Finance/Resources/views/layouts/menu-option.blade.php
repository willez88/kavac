{{-- Gestión de finanzas --}}
<li>
    <a href="#" title="Gestión de bancos y finanzas" data-toggle="tooltip" data-placement="right">
        <i class="ion-ios-calculator-outline"></i><span>Finanzas</span>
    </a>
    <ul class="submenu" style="{!! (strpos($current_url, 'finance') !== false)?'display:block;':'' !!}">
        <li>
            <a href="#">Banco</a>
        </li>
        <li>
            <a href="#">Emisión de Cheques</a>
        </li>
        <li>
            <a href="#">Reportes</a>
            <ul class="submenu">
                <li><a href="#">Reporte 1</a></li>
                <li><a href="#">Reporte 2</a></li>
            </ul>
        </li>
    </ul>
</li>