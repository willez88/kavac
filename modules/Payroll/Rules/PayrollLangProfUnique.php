<?php

namespace Modules\Payroll\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\Payroll\Models\PayrollProfessional;
use Illuminate\Support\Facades\DB;

/**
 * @class PayrollLangProfUnique
 * @brief Validación para dupla de campos únicos en tabla intermedia idioma y dato profesional
 *
 * Gestiona las reglas de validación para dupla de campos únicos de una tabla
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollLangProfUnique implements Rule
{
    /**
     *  Identificador único del dato pofesional
     *  @var integer $payroll_prof_id
     */
    protected $payroll_prof_id;

    /**
     *  Identificador único del idioma
     *  @var integer $payroll_lang_id
     */
    protected $payroll_lang_id;

    /**
     * Crea una nueva instancia
     *
     * @method __construct
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @param Integer $payroll_prof_id  Identificador del dato profesional
     * @param Integer $payroll_lang_id  Identificador del idioma
     *
     * @return void
     */
    public function __construct($payroll_prof_id, $payroll_lang_id)
    {
        $this->payroll_prof_id = $payroll_prof_id;
        $this->payroll_lang_id = $payroll_lang_id;
    }

    /**
     * Determina si la regla de validación es correcta
     *
     * @param  string  $attribute Nombre del atributo
     * @param  mixed   $value     Valor del atributo a evaluar
     *
     * @return bool    Devuelve verdadero si la regla se cumple, de lo contrario falso
     */
    public function passes($attribute, $value)
    {
        $payrollProfessional = PayrollProfessional::where('id', $this->payroll_prof_id)
            ->with('payrollLanguages')->first();
        $payrolLangProf = $payrollProfessional->payrollLanguages()
            ->where('payroll_prof_id', $this->payroll_prof_id)->where('payroll_lang_id', $value)->count();
        return $payrolLangProf > 0 ? false : true;
    }

    /**
     * Obtiene el mensaje de error de validación
     *
     * @return string
     */
    public function message()
    {
        return 'Los datos profesionales no pueden tener idiomas repetidos.';
    }
}
