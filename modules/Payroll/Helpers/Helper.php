<?php

if (! function_exists('age')) {
	/**
	 * Calcula la edad de una persona en años
	 *
	 * @author	William Páez <wpaez@cenditel.gob.ve>
	 * @param  date   $birthdate Fecha de nacimiento del trabajador
	 * @return Devuelve la edad representada en años, -1 en caso de introducir una fecha superior a la actual
	 */
	function age($birthdate)
	{
		$today = new DateTime();
		$birthdate = new DateTime($birthdate);
		if($today > $birthdate) {
			$years = $today->diff($birthdate);
			return $years->y;
		}
		else {
			return -1;
		}
	}
}
