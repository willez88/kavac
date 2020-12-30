<?php

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
    function multiexplode($delimiters, $string)
    {
        $ready  = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return $launch;
    }
}

if (! function_exists('max_length')) {
    /**
     * Devuelve el valor de la cadena mas larga contenida en un arreglo
     *
     * @method    max_length
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     {array}     $records    Arreglo con los elementos a comparar
     *
     * @return    {array}                 Arreglo con las subcadenas generadas
     */
    function max_length($records)
    {
        $current = '';
        foreach ($records as $record) {
            if ($current != '') {
                if (strlen($record) > strlen($current)) {
                    $current = $record;
                }
            } else {
                $current = $record;
            }
        }
        return $current;
    }
}

if (! function_exists('str_eval')) {
    /**
     * Evalua una expresión contenida en una cadena
     *
     * @method    str_eval
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     {array}     $string    Cadena que contiene la expresión a evaluar
     *
     * @return    {array}
     */
    function str_eval($string)
    {
        $conditionPos = strpos($string, "if");
        if (is_bool($conditionPos)) {
            return eval("return $string;");
        } elseif ($conditionPos >= 0) {
            $string = substr($string, $conditionPos+2, strlen($string)-1);
            $statementPos = strpos($string, "{");
            if ($statementPos >= 0) {
                $statement = substr($string, $statementPos+1, strlen($string)-$statementPos-2);
                $condition = substr($string, 0, $statementPos);
                if (eval("return $condition;")) {
                    return str_eval($statement);
                } else {
                    return 0;
                }
            }
        }
    }
}
