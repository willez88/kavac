<?php

if (! function_exists('set_active_menu')) {
	/**
	 * Define la opción activa del menú según la URL actual
	 *
	 * @author	Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param string $currentUrl  URL actual
	 * @param array|string $compareUrls Nombre o lista de nombres de las URL a comparar
	 * @return Si la URL a comparar es igual a la actual retorna active de lo contrario retorna vacio
	 */
	function set_active_menu($currentUrl, $compareUrls)
	{
		if (is_array($compareUrls)) {
			$active = '';
            foreach ($compareUrls as $url) {
                if ($currentUrl == $url) {
                    return 'active';
                }
            }
            return $active;
		}

		return ($currentUrl == $compareUrls) ? 'active' : '';
	}
}