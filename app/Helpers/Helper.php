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

if (! function_exists('generate_registration_code')) {
	/**
	 * Genera códigos a implementar en los diferentes registros del sistema
	 *
	 * @author	Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param  string  $prefix      Prefijo que identifica el código
	 * @param  integer $code_length Longitud máxima permitida para el código a generar
	 * @param  integer $year        Sufijo que identifica el año del cual se va a generar el código
	 * @param  string  $model       Namespace y nombre del modelo en donde se aplicará el nuevo código
	 * @param  string  $field       Nombre del campo del código a generar
	 * @return string               Retorna una cadena con el nuevo código
	 */
	function generate_registration_code($prefix, $code_length, $year, $model, $field)
	{
		$code = '';
		$currentCode = 0;
		$newCode = 1;

		$targetModel = $model::select($field)->where($field, 'like', "{$prefix}-%-{$year}")->withTrashed()
							 ->orderBy($field, 'desc')->first();

		if ($targetModel) {
			$currentCode = (int)explode('-', $targetModel->$field)[1];
		}

		$newCode += $currentCode;

		if (strlen((string)$newCode) > $code_length) {
			return ["error" => "El nuevo código excede la longitud permitida"];
		}

		$code = "{$prefix}-{$newCode}-{$year}";

		return $code;
	}
}