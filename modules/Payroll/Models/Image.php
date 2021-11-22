<?php
/** [descripción del namespace] */
namespace Modules\Payroll\Models;

use App\Models\Image as BaseImage;

/**
 * @class Image
 * @brief Modelo que extiende las funcionalidades del modelo base Image
 *
 * Gestiona funcionalidades extendidas del modelo base Image
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Image extends BaseImage
{
    /**
     * Método que obtiene la imagen asociada a muchos archivos de curso
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollCourseFiles()
    {
        return $this->hasMany(PayrollCourseFile::class);
    }

    /**
     * Método que obtiene la imagen asociada a muchos archivos de reconocimiento
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollAcknowledgmentFiles()
    {
        return $this->hasMany(PayrollAcknowledgmentFile::class);
    }
}
