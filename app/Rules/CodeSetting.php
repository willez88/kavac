<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @class CodeSetting
 * @brief Reglas de validación para la configuración de códigos
 * 
 * Gestiona las reglas de validación para la configuración de códigos de registro
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class CodeSetting implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($value !== null) {
            if (!substr_count($value, "-") == 2) {
                return false;
            }
            list($prefix, $digits, $sufix) = explode('-', $value);
            
            return strlen($prefix) >= 1 && strlen($prefix) <= 3 && is_numeric($digits) && (int)$digits === 0 && strlen($digits) >= 4 && strlen($digits) <= 8 && (strlen($sufix) === 2 || strlen($sufix) === 4) && (strtoupper($sufix) === "YY" || strtoupper($sufix) === "YYYY");
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El formato del campo :attribute es incorrecto';
    }
}
