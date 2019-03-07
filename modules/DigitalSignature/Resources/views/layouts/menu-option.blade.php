{{-- Gestión de firma electrónica --}}
<li>
    <a href="#" title="Gestión de firma electrónica" data-toggle="tooltip" data-placement="right">
        <i class="ion-ios-compose-outline"></i><span>Firma Electrónica</span>
    </a>
    <ul class="submenu" style="{!! (strpos(Route::current()->getName(), 'digitalsignature') !== false)?'display:block;':'' !!}">
    	@role('admin')
	        <li>
	            <a href="#">Configuración</a>
	        </li>
	    @endrole
    </ul>
</li>