<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class Istitution
 * @brief Datos de Instituciones
 * 
 * Gestiona el modelo de datos para las Instituciones
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Institution extends Model
{
    use SoftDeletes;
    use RevisionableTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     * @var boolean $revisionCreationsEnabled
     */
    protected $revisionCreationsEnabled = true;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = [
    	'onapre_code', 'rif', 'acronym', 'name', 'business_name', 'start_operations_date', 'legal_base',
    	'legal_form', 'main_activity', 'mission', 'vision', 'legal_address', 'web', 'composition_assets',
    	'postal_code', 'active', 'default', 'retention_agent', 'institution_sector_id', 
        'institution_type_id', 'municipality_id', 'city_id', 'logo_id', 'banner_id'
    ];

    /**
     * Método que obtiene el logotipo de la Institución
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con el registro relacionado al modelo Image
     */
    public function logo()
    {
        return $this->belongsTo(Image::class, 'logo_id');
    }

    /**
     * Método que obtiene el banner de la Institución
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con el registro relacionado al modelo Image
     */
    public function banner()
    {
        return $this->belongsTo(Image::class, 'banner_id');
    }

    /**
     * Método que obtiene el sector de la Institución
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con el registro relacionado al modelo InstitutionSector
     */
    public function sector()
    {
        return $this->belongsTo(InstitutionSector::class);
    }

    /**
     * Método que obtiene el tipo de la Institución
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con el registro relacionado al modelo InstitutionType
     */
    public function type()
    {
        return $this->belongsTo(InstitutionType::class);
    }
}
