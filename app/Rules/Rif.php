<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @class Rif
 * @brief Reglas de validación para los registros de identificación fiscal (RIF)
 * 
 * Gestiona las reglas de validación para los registros de identificación fiscal
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Rif implements Rule
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
        return validate_rif($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El número de RIF es incorrecto o no existe.';
    }
}
