<div class="container font-small">
    <div class="row">
        <nav class="col-12 col-md-6 col-lg-4 mr-lg-auto" role="navigation">
            <ul class="nav justify-content-center">
                <li class="nav-item text-uppercase">
                    <a class="nav-link resalt-link" href="https://www.cenditel.gob.ve" target="_blank" data-toggle="tooltip"
                       title="{{ __('Acceso a la página principal de la Institución') }}">
                        CENDITEL
                    </a>
                </li>
                <li class="nav-item text-uppercase">
                    <a class="nav-link about_app resalt-link" href="#" data-toggle="tooltip"
                       title="{{ __('Información acerca de la aplicación') }}">
                        {{ __('Acerca de') }}
                    </a>
                </li>
                <li class="nav-item text-uppercase">
                    <a class="nav-link resalt-link" href="https://tibisay.cenditel.gob.ve/sistema-de-gestion"
                       target="_blank" data-toggle="tooltip" title="{{ __('Acceso al blog del proyecto') }}">
                        {{ __('Blog') }}
                    </a>
                </li>
                <li class="nav-item text-uppercase">
                    <a class="nav-link license_app resalt-link" href="#" data-toggle="tooltip"
                       title="{{ __('Licencia bajo la cual se distribuye la aplicación') }}">
                        {{ __('Licencia') }}
                    </a>
                </li>
            </ul>
        </nav>
        <div class="col-12 col-md-6 col-lg-5 text-center @guest text-light @endguest pt-2">
            &copy; <span class="currentYear"></span>, {{ __('Diseñado por') }}
            <a href="mailto:rvargas at cenditel.gob.ve" data-toggle="tooltip"
               title="{{ __('Envíanos tus sugerencias o comentarios') }}">
                Ing. Roldan Vargas
            </a>, {{ __('Desarrollado por') }}
            <a href="https://www.cenditel.gob.ve" target="_blank" data-toggle="tooltip"
               title="{{ __('Acceso a la página principal de la Institución') }}">
                CENDITEL
            </a>
            {{ __('nodo Mérida') }}.
        </div>
    </div>
</div>
