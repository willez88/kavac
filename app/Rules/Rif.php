<?php
/** Reglas de validación personalizadas */
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @class Rif
 * @brief Reglas de validación para los registros de identificación fiscal (RIF)
 *
 * Gestiona las reglas de validación para los registros de identificación fiscal
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Rif implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @method  __construct
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
     * @method  passes
     *
     * @param  string  $attribute
     * @param  mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return validate_rif($value);
    }

    /**
     * Get the validation error message.
     *
     * @method  message
     *
     * @return string
     */
    public function message()
    {
        return __('El número de RIF es incorrecto o no existe.');
    }
}
