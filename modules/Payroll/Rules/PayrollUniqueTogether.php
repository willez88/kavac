<?php

namespace Modules\Payroll\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rule as BaseRule;
use Modules\Payroll\Models\PayrollProfessionalInformation;
use Illuminate\Support\Facades\DB;

/**
 * @class PayrollUniqueTogether
 * @brief Reglas de validación para dos campos únicos en una tabla
 *
 * Gestiona las reglas de validación para dos campos únicos de una tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollUniqueTogether implements Rule
{
    /** Integer Define el identificador de información profesional del trabajador */
    protected $payroll_professional_information_id;

    /**
     * Crea una nueva instancia
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @param Integer $payroll_professional_information_id  Identificador de la información profesional del trabajador
     * @return void
     */
    public function __construct($payroll_professional_information_id)
    {
        $this->payroll_professional_information_id = $payroll_professional_information_id;
    }

    /**
     * Determina si la regla de validación es correcta
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {

        return false;
    }

    /**
     * Obtiene el mensaje de error de validación
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
