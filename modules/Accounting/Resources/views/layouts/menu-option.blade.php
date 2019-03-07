{{-- Gestión de contabilidad --}}
<li>
    <a href="#" title="Gestión de asientos contables" data-toggle="tooltip" data-placement="right">
        <i class="ion-social-buffer-outline"></i><span>Contabilidad</span>
    </a>
    <ul class="submenu" style="{!! (strpos(Route::current()->getName(), 'accounting') !== false)?'display:block;':'' !!}">
        <li>
            <a href="#">
                <i></i>Configuración
            </a>
        </li>
        <li>
            <a href="#">Cuentas Patrimoniales</a>
        </li>
        <li>
            <a href="#">Convertidor de Cuentas</a>
        </li>
        <li>
            <a href="#">Asientos Contables</a>
        </li>
        <li>
            <a href="#">Reportes</a>
            <ul class="submenu">
                <li><a href="#">Balance de Comprobación</a></li>
                <li><a href="#">Mayor Analítico</a></li>
                <li><a href="#">Libro Diario</a></li>
                <li><a href="#">Libro Auxiliar</a></li>
                <li><a href="#">Balance General</a></li>
                <li><a href="#">Estado de Resultados</a></li>
            </ul>
        </li>
    </ul>
</li>