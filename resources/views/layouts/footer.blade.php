<div class="container">
    <nav>
        <ul>
            <li>
                <a href="https://www.cenditel.gob.ve" target="_blank" class="resalt-link" data-toggle="tooltip"
                   title="{{ __('Acceso a la página principal de la Institución') }}">
                    CENDITEL
                </a>
            </li>
            <li>
                <a href="#" class="about_app resalt-link" data-toggle="tooltip"
                   title="{{ __('Información acerca de la aplicación') }}">
                    {{ __('Acerca de') }}
                </a>
            </li>
            <li>
                <a href="#" target="_blank" class="resalt-link" data-toggle="tooltip"
                   title="{{ __('Acceso al blog del proyecto') }}">
                    {{ __('Blog') }}
                </a>
            </li>
            <li>
                <a href="#" class="license_app resalt-link" data-toggle="tooltip"
                   title="{{ __('Licencia bajo la cual se distribuye la aplicación') }}">
                    {{ __('Licencia') }}
                </a>
            </li>
        </ul>
    </nav>
    <div class="copyright">
        &copy;
        <script>
            document.write(new Date().getFullYear());
        </script>, {{ __('Diseñado por') }}
        <a href="mailto:rvargas@cenditel.gob.ve" data-toggle="tooltip"
           title="{{ __('Envíanos tus sugerencias o comentarios') }}">
            Ing. Roldan Vargas
        </a>, {{ __('Desarrollado por') }}
        <a href="https://www.cenditel.gob.ve" target="_blank" data-toggle="tooltip"
           title="{{ __('Acceso a la página principal de la Institución') }}">CENDITEL</a> {{ __('nodo Mérida') }}.
    </div>
</div>
