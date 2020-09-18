{{-- Gestión de firma electrónica --}}
<li>
    <a href="#" title="Gestión de firma electrónica" data-toggle="tooltip" data-placement="right">
        <i class="icofont icofont-ui-password"></i><span>Firma Electrónica</span>
    </a>
    <ul class="submenu" style="{!! display_submenu('digitalsignature') !!}">
    	@role('admin')
	        <li>
	            <a href="{{ route('digitalsignature') }}">Configuración</a>
	        </li>
	    @endrole
    </ul>
</li>