<?php
/** Modelos de talento humano de base de datos */
namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollCourseFile
 * @brief Datos de archivos de curso
 *
 * Gestiona el modelo archivos de curso
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollCourseFile extends Model implements Auditable
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
    protected $fillable = ['name', 'payroll_course_id', 'image_id'];

    /**
     * Método que obtiene el curso asociado a un archivo de curso
     *
     * @author  William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollCourse()
    {
        return $this->belongsTo(PayrollCourse::class);
    }

    /**
     * Método que obtiene la imagen asociada a un archivo de curso
     *
     * @author  William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }

    /**
     * Obtiene todos los documentos asociados al curso
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }
}
