<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * City
 *
 * Datos de Ciudades
 *
 * Gestiona el modelo de datos para las Ciudades
 *
 * @property string  $name
 * @property integer $estate_id
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class City extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['name', 'estate_id'];

    /**
     * Método que obtiene el Estado de una Ciudad
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return object Objeto con los registros relacionados al modelo Estate
     */
    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    /**
     * City has many Institutions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function institutions()
    {
        return $this->hasMany(Institution::class);
    }
}
