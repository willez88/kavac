@if (isset($logo_nav) && $logo_nav)
    <img src="{{ asset('images/logo-white.png') }}" alt="{{ __('Logotipo :app', ['app' => config('app.name')]) }}"
         data-toggle="tooltip" title="{{ __(':app Sistema de Gestión Organizacional', ['app' => config('app.name')]) }}"/>
@endif
@if (isset($logo_mini) && $logo_mini)
	<img src="{{ asset('images/logo-mini.png') }}" alt="{{ __('Logotipo :app', ['app' => config('app.name')]) }}"
         data-toggle="tooltip" title="{{ __(':app Sistema de Gestión Organizacional', ['app' => config('app.name')]) }}">
@endif
@if (isset($logo_name) && $logo_name)
	<img src="{{ asset('images/app-name-white.png') }}" alt="{{ __(':app', ['app' => config('app.name')]) }}" />
@endif
@if (isset($logo_app) && $logo_app)
    <img src="{{ asset('images/app-logo-white.png') }}" alt="{{ __('Logotipo :app', ['app' => config('app.name')]) }}"
         data-toggle="tooltip" title="{{ __(':app Sistema de Gestión Organizacional', ['app' => config('app.name')]) }}">
@endif
