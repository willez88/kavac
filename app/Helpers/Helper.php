<?php

if (! function_exists('set_active_menu')) {
	/**
	 * Define la opción activa del menú según la URL actual
	 *
	 * @author	Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param array|string $compareUrls Nombre o lista de nombres de las URL a comparar
	 * @return Si la URL a comparar es igual a la actual retorna active de lo contrario retorna vacio
	 */
	function set_active_menu($compareUrls)
	{
		$currentUrl = Route::current()->getName();
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

if (! function_exists('display_submenu')) {
	/**
	 * Define si se expande o contrae las opciones de un submenÚ
	 *
	 * @author	Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param  string|array $submenu Nombre del submenu a mostrar u ocultar
	 * @return string          		 Retorna una cadena vacia para contraer las opciones del submenú, 
	 *                               de lo contrario retorna el css para mostrar el bloque de opciones
	 */
	function display_submenu($submenu)
	{
		if (is_array($submenu)) {
			foreach ($submenu as $sb) {
				if (strpos(Route::current()->getName(), $sb) !== false) {

					return 'display:block';
				}
			}
		}
		return (!is_array($submenu) && strpos(Route::current()->getName(), $submenu) !== false) ? 'display:block;' : '';
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
		$newCode = 1;

		$targetModel = $model::select($field)->where($field, 'like', "{$prefix}-%-{$year}")->withTrashed()
							 ->orderBy($field, 'desc')->first();

		$newCode += ($targetModel) ? (int)explode('-', $targetModel->$field)[1] : 0;

		if (strlen((string)$newCode) > $code_length) {
			return ["error" => "El nuevo código excede la longitud permitida"];
		}

		return "{$prefix}-{$newCode}-{$year}";
	}
}

if (!function_exists('template_choices')) {
	/**
	 * Construye un arreglo de elementos para usar en plantillas blade
	 *
	 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param  string 		$model   Nombre de la clase del modelo al cual generar el listado de opciones
	 * @param  string|array $fields  Campo(s) a utilizar para mostrar en el listado de opciones
	 * @param  array 		$filters Arreglo con los filtros a ser aplicados en la consulta
	 * @param  boolean      $vuejs   Indica si las opciones a mostrar son para una plantilla normal o para VueJS
	 * @return array          		 Arreglo con las opciones a mostrar
	 */
	function template_choices($model, $fields = 'name', $filters = [], $vuejs = false)
	{
		$records = $model::all();
        if ($filters) {
            foreach ($filters as $key => $value) {
                $records = $records->where($key, $value);
            }
        }

        /** Inicia la opción vacia por defecto */
        /*$options = ($vuejs) ? ((count($records) > 1) ? [['id' => '', 'text' => 'Seleccione...']] : []) 
        		   : ((count($records) > 1) ? ['' => 'Seleccione...'] : []);*/
        $options = ($vuejs) ? [['id' => '', 'text' => 'Seleccione...']] : ['' => 'Seleccione...'];

        foreach ($records as $rec) {
        	if (is_array($fields)) {
        		$text = '';
        		foreach ($fields as $field) {
        			$text .= ($field !== "-") ? $rec->$field : " {$field} ";
        		}
        	}
        	else {
        		$text = $rec->$fields;
        	}

        	/** Carga el listado según el tipo de plantilla en el cual se va a implementar (normal o con VueJS) */
        	($vuejs) ? array_push($options, ['id' => $rec->id, 'text' => $text]) : $options[$rec->id] = $text;

        }
        return $options;
	}
}