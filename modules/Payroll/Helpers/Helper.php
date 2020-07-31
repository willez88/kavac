<?php

if (! function_exists('age')) {
    /**
     * Calcula la edad de una persona en años
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @param  date   $birthdate Fecha de nacimiento del trabajador
     * @return Devuelve la edad representada en años, -1 en caso de introducir una fecha superior a la actual
     */
    function age($birthdate)
    {
        $today = new DateTime();
        $birthdate = new DateTime($birthdate);
        if ($today > $birthdate) {
            $years = $today->diff($birthdate);
            return $years->y;
        } else {
            return -1;
        }
    }
}

if (! function_exists('multiexplode')) {
    /**
     * Divide una cadena de acuerdo a sus delimitadores y construye un arreglo con las subcadenas resultantes
     *
     * @method    multiexplode
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     {array}     $delimiters    Arreglo con los delimitadores de la cadena
     * @param     {string}    $string        Cadena de texto a ser procesada
     *
     * @return    {array}                    Arreglo con las subcadenas generadas
     */
    function multiexplode ($delimiters, $string)
    {
        $ready  = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    };
}
