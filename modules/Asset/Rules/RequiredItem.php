<?php

namespace Modules\Asset\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @class RequiredItem
 * @brief Reglas de validación para los campos requeridos en el registro
 *
 * Gestiona las reglas de validación de campos requeridos en el registro
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class RequiredItem implements Rule
{
    /** Boolean Define si el campo es requerido */
    protected $required;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($required = true)
    {
        $this->required = $required;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value = '')
    {
        if ($this->required == true) {
            return ($value != '');
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo :attribute es obligatorio.';
    }
}
