@if (isset($logo_mini) && $logo_mini)
	<img src="{{ asset('images/logo-mini.png') }}" alt="Logotipo KAVAC" data-toggle="tooltip" 
		 title="Sistema de Gestión Administrativa (KAVAC)">
@endif
@if (isset($logo_name) && $logo_name)
	<img src="{{ asset('images/app-name-white.png') }}" alt="KAVAC" />
@endif