@if (isset($logo_mini) && $logo_mini)
	<img src="{{ asset('images/logo-mini.png') }}" alt="{{ __('Logotipo :app', ['app' => config('app.name')]) }}"
         data-toggle="tooltip" title="{{ __('Sistema de Gestión Administrativa (:name)', ['app' => config('app.name')]) }}">
@endif
@if (isset($logo_name) && $logo_name)
	<img src="{{ asset('images/app-name-white.png') }}" alt="{{ __('Logotipo :app', ['app' => config('app.name')]) }}" />
@endif
