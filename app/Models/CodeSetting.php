<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class CodeSetting extends Model
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
    	'module', 'model', 'table', 'field', 'active', 'format_prefix', 'format_digits', 'format_year', 'description'
    ];

    /**
     * Método que permite dividir el formato del código
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  string $code Formato del código a configurar
     * @return array       Arreglo con las partes que conforman el código
     */
    public static function divideCode($code) {
    	
    	return list($prefix, $digits, $sufix) = explode('-', $code);

    }

    /**
     * Método que permite obtener el prócimo valor a registrar del código
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @param  string $table  Nombre de la tabla
     * @param  string $field  Nombre del campo
     * @param  string $model  Ruta del Modelo
     * @param  string $module Nombre del módulo
     * @return string         Nuevo código a insertar
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
}
