<?php
/** [descripción del namespace] */
namespace Modules\Asset\Rules\Setting;

use Illuminate\Contracts\Validation\Rule;
use Modules\Asset\Models\AssetSubcategory;

/**
 * @class AssetSubcategoryUnique
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author  Yennifer Ramirez <yramirez@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AssetSubcategoryUnique implements Rule
{
    /**
     * Identificador unico de la Categoría
     * @var    string    $asset_category_id
     */
    protected $asset_category_id;

    /**
     * Código de la Subcategoria
     * @var    string    $code
     */
    protected $code;

    /**
     * Crea una nueva instancia de la regla
     *
     * @method __construct
     *
     * @return void     [descripción de los datos devueltos]
     */
    public function __construct($asset_category_id, $code)
    {
        $this->asset_category_id = $asset_category_id;
        $this->code  = $code;
    }

    /**
     * Determina si pasa la regla de validación.
     *
     * @method passes
     *
     * @param  string  $attribute   Nombre del atributo
     * @param  mixed   $value       Valor del atributo a evaluar
     *
     * @return bool    Devuelve verdadero si la regla se cumple de lo contrario devuelve falso
     */
    public function passes($attribute, $value)
    {
        $assetSubcategories = AssetSubcategory::where('asset_category_id', $this->asset_category_id)
                         ->where('code', $this->code)
                         ->where('id', '<>', $value)
                         ->get();
        return count($assetSubcategories) > 0
                ? false
                : true;
    }

    /**
     * Obtiene el mensaje de validación.
     *
     * @method message
     *
     * @return string    Devuelve una cadena de texto con el mensaje de error si la validación no es exitosa
     */
    public function message()
    {
        return 'La dupla categoría general y código de la subcategoría ya se encuentra registrada';
    }
}
