<?php

namespace Modules\Payroll\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Payroll\Models\PayrollPermissionPolicy;

class PayrollPermissionPolicyDaysRange implements Rule
{
    /**
         * Rango minimo para solicitar permiso
         * @var   integer   $day_min
         */
        protected $day_min;

        /**
         * Rango máximo
         * @var    integer    $day_max
         */
        protected $day_max;

        /**
         *
         *
         * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
         *
         * @param     integer    $day_min
         * @param     integer    $day_max
         *
         * @return    void
         */
    public function __construct($day_min, $day_max)
    {
        $this->day_min = $day_min;
        $this->day_max = $day_max;
    }

    /**
     * Determina si pasa la regla de validación
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->day_min < $this->day_max) {
            return true;
        } else {
             return false;
        }
    }

    /**
     * Obtiene el mensaje de error de validación
     *
     * @return string
     */
    public function message()
    {
        return 'El rango no es valido, el mínimo debe de ser menor que el máximo.';
    }
}
