<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class CodeSetting
 * @brief Datos para la configuración de códigos de registro
 *
 * Gestiona el modelo de datos para las configuraciones de códigos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CodeSetting extends Model implements Auditable
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
    protected $fillable = [
        'module', 'model', 'table', 'field', 'active', 'format_prefix', 'format_digits',
        'format_year', 'description', 'type'
    ];

    /**
     * Método que permite obtener el formato configurado para el código
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return string Retorna el formato del código configurado
     */
    public function getFormatCodeAttribute()
    {
        return "{$this->format_prefix}-{$this->format_digits}-{$this->format_year}";
    }

    /**
     * Método que permite dividir el formato del código
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string $code Formato del código a configurar
     * @return array       Arreglo con las partes que conforman el código
     */
    public static function divideCode($code)
    {
        return list($prefix, $digits, $sufix) = explode('-', $code);
    }

    /**
     * Método que permite obtener el prócimo valor a registrar del código
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string $table  Nombre de la tabla
     * @param  string $field  Nombre del campo
     * @param  string $model  Ruta del Modelo
     * @param  string $module Nombre del módulo
     * @return int|string         Nuevo código a insertar
     */
    public static function codeNextValue($table, $field, $model, $formulation_year, $module = null)
    {
        $configCode = self::where('model', $model)->where('table', $table)->where('active', true)->first();
        $model = app($model);

        $code = $nextCode = 1;

        if ($configCode && $model->whereNotNull($field)->get()) {
            // Agregar validación para el año de ejecución presupuestaria
            $lastCode = $model->whereYear('created_at', date('Y'))->orderBy('created_at', 'desc')->first();

            if ($lastCode) {
                list($prefix, $digits, $sufix) = explode('-', $lastCode);
                $nextCode += (integer)$digits;
                $code = $prefix . "-" . $nextCode . "-" . $sufix;
            }
        }

        return $code;
    }

    /**
     * Método Scope para obtener configuraciones de un modelo
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  object $query Objeto con la collección de la consulta realizada
     * @param  string $model Nombre del modelo del cual obtener la configuración
     * @param  string $type  Tipo de configuración a obtener
     * @return object        Objeto con la consulta requerida
     */
    public function scopeGetSetting($query, $model, $type)
    {
        return $query->where("model", $model)->where('type', $type)->first();
    }
}
