<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class Image
 * @brief Datos de Imágenes
 *
 * Gestiona el modelo de datos para las imágenes
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class Image extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['file', 'url', 'max_width', 'max_height', 'min_width', 'min_height'];

    /**
     * Método que obtiene los logos de las instituciones
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return object Objeto con los registros relacionados al modelo Institution
     */
    public function institutionLogos()
    {
        return $this->hasMany(Institution::class, 'logo_id');
    }

    /**
     * Método que obtiene los banners de las instituciones
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return object Objeto con los registros relacionados al modelo Institution
     */
    public function institutionBanners()
    {
        return $this->hasMany(Institution::class, 'banner_id');
    }

    /**
     * Método que obtiene el perfil de una imagen
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return object Objeto con el registro relacionado al modelo Profile
     */
    public function profile()
    {
        return $this->hasMany(Institution::class);
    }

    /**
     * Image morphs to models in imageable_type
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
