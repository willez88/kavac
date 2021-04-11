<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;
use DB;

/**
 * @class Parish
 * @brief Datos de Parroquias
 *
 * Gestiona el modelo de datos para las Parroquias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Parish extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name', 'code', 'municipality_id'];

    /**
     * Oculta los campos de fechas de creación, actualización y eliminación
     *
     * @var    array $hidden
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Listado de relaciones a cargar por defecto
     *
     * @var    array
     */
    protected $with = ['municipality'];

    /**
     * Método que obtiene el Municipio de una Parroquia
     *
     * @method  municipality
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return object Objeto con los registros relacionados al modelo Municipality
     */
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    /**
     * Scope para buscar y filtrar datos de Parroquias
     *
     * @method    scopeSearch
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @param  string         $search    Cadena de texto a buscar
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(DB::raw('upper(name)'), 'LIKE', '%'.$search.'%')
                     ->orWhere('code', 'LIKE', '%'.$search.'%')
                     ->orWhereHas('municipality', function ($qMun) use ($search) {
                         $qMun->where(DB::raw('upper(name)'), 'LIKE', '%'.$search.'%')
                              ->orWhere('code', 'LIKE', '%'.$search.'%')
                              ->orWhereHas('estate', function ($qEst) use ($search) {
                                  $qEst->where(DB::raw('upper(name)'), 'LIKE', '%'.$search.'%')
                                       ->orWhere('code', 'LIKE', '%'.$search.'%');
                              });
                     });
    }

    /**
     * Ordena los resultados de la consulta de acuerdo a la columna establecida
     *
     * @method   scopeOrderByColumn
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  \Illuminate\Database\Eloquent\Builder
     * @param  string       $column     Nombre de la columna por la cual ordenar los resultados
     * @param  string       $column     Método de ordenamiento, ascendente o descendente
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOrderByColumn($query, $column, $asc)
    {
        $method = ($asc) ? 'ASC' : 'DESC';

        if ($column === 'municipality.estate.name') {
            return $query->select('parishes.*')
                         ->join('municipalities', 'parishes.municipality_id', '=', 'municipalities.id')
                         ->join('estates', 'municipalities.estate_id', '=', 'estates.id')
                         ->orderBy('estates.name', $method);
        } elseif ($column === 'municipality.name') {
            return $query->select('parishes.*')
                         ->join('municipalities', 'parishes.municipality_id', '=', 'municipalities.id')
                         ->orderBy('municipalities.name', $method);
        }
        return $query->orderBy($column, $method);
    }
}
