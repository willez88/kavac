<?php

namespace Modules\Asset\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @class DateExtension
 * @brief Reglas de validación para las prorrogas de entrega de equipos
 *
 * Gestiona las reglas de validación de las fechas de prorroga de entrega de equipos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class DateExtension implements Rule
{
    /** Integer Define el numero de dias adicionales permitidos para la entrega */
    protected $days;

    /** Date Define la fecha de entrega original */
    protected $date;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($date, $days = '0')
    {
        $this->days = $days;
        $this->date = date('d-m-Y',strtotime($date));
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
        $days_extension = '+ '.$this->days. ' days';
        return ((date('d-m-Y',strtotime($this->date.$days_extension)) >= date('d-m-Y', strtotime($value)))&&( date('d-m-Y', strtotime($value)) >= date('d-m-Y',strtotime($this->date))));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo :attribute excede el plazo permitido. Maximo: '. $this->days . ' dias adicionales';
    }
}
