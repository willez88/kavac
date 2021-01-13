<?php
/** Reglas de validación personalizadas */
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * @class AgeToWork
 * @brief Reglas de validación para la edad requerida para trabajar
 *
 * Gestiona las reglas de validación para validar la edad de un trabajar
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AgeToWork implements Rule
{
    /**
     * Define la edad laboral permitida
     *
     * @var    integer $age
     */
    protected $age;

    /**
     * Recibe por parámetro la edad laboral permitida
     *
     * @method  __construct
     *
     * @param integer   $age    Edad de la persona
     *
     * @return void
     */
    public function __construct($age)
    {
        $this->age = $age;
    }

    /**
     * Determina si la regla de validación es correcta
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
        return age($value) >= $this->age;
    }

    /**
     * Obtiene el mensaje de error de validación
     *
     * @method  message
     *
     * @return string
     */
    public function message()
    {
        if ($this->age == 0) {
            return __(
                'Todavía no ha configurado una edad laboral permitida en el panel de configuración de talento humano'
            );
        } else {
            return 'El campo :attribute debe ser mayor o igual a '.$this->age;
        }
    }
}
