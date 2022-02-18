<?php
/** Traits de uso general */
namespace App\Traits;

use Illuminate\Support\Facades\Cache;

/**
 * Trait para la gestión de modelos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
trait ModelsTrait
{
    /**
     * Método que ejecuta eventos del modelo
     *
     * @author Ing. Roldan Vargas <roldandvg at gmail.com> | <rvargas at cenditel.gob.ve>
     *
     * @return void 
     */
    protected static function boot()
    {
        parent::boot();
        
        static::deleted(function ($model) {
            $modelClass = get_class($model);
            $deletedRecords = $modelClass::where('id', $model->id)->onlyTrashed()->orderBy('deleted_at', 'desc')->get();
            
            if (Cache::has('deleted_records')) {
                $deleted = Cache::get('deleted_records');
                $deletedRecords = $deleted->merge($deletedRecords);
                Cache::put('deleted_records', $deletedRecords);
            } else {
                Cache::rememberForever('deleted_records', function () use ($deletedRecords) {
                    return $deletedRecords;
                });
            }

        });

        static::restored(function ($model) {
            $modelClass = get_class($model);
            $restored = Cache::get('deleted_records');
            $restored = $restored->filter(function ($res) use ($model, $modelClass) {
                return ($modelClass === get_class($res) && $res->id !== $model->id) || $modelClass !== get_class($res);
            });
            Cache::put('deleted_records', $restored);
        });
    }
    /**
     * Método que escanea todos los modelos presentes en la aplicación
     *
     * @method  getModels
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return array                Retorna un arreglo con los módulos
     */
    public function getModels($dir = "")
    {
        $path = app_path() . "/Models";
        $modules_path = base_path() . '/modules';

        if (!empty($dir)) {
            $path .= '/' . $dir;
        }
        $out = [];
        $results = scandir($path);

        foreach ($results as $result) {
            if ($result === '.' or $result === '..' or $result === 'Session.php') {
                continue;
            }

            $filename = $result;

            if (is_dir($filename)) {
                //$out = array_merge($out, 'App\Models\\' . $this->getModels($filename));
                $out = array_merge($out, $this->getModels($filename));
            } else {
                $out[] = 'App\Models\\' . substr($filename, 0, -4);
            }
        }

        /** Escanea los directorios de módulos para obtener los correspondientes modelos */
        $results_modules = scandir($modules_path);
        foreach ($results_modules as $result_module) {
            if ($result_module === '.' or $result_module === '..') {
                continue;
            }

            $filename_module = $result_module;

            $r = scandir(base_path() . '/modules/' . $filename_module . '/Models');

            foreach ($r as $model) {
                if (in_array($model, ['.', '..', '.gitkeep', 'AssetClasification.php']) || strpos($model, '.php')<= 0) {
                    continue;
                }
                $filename_m = $model;

                if (is_dir($filename_m) || strpos($model, '.php') <=0) {
                    $out = array_merge(
                        $out,
                        //'Modules\\' . $filename_module . '\\Models\\' . $this->getModels($filename_m)
                        $this->getModels($filename_m)
                    );
                } else {
                    $out[] = 'Modules\\' . $filename_module . '\\Models\\' . substr($filename_m, 0, -4);
                }
            }
        }

        return $out;
    }

    /**
     * Identifica si un modelo esta establecido para una eliminación lógica
     *
     * @method  isModelSoftDelete
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  string  $model Nombre del modelo a evaluar
     *
     * @return boolean        Devuelve verdadero si el modelo esta establecido para una eliminación lógica,
     *                        de lo contrario devuelve falso
     */
    public function isModelSoftDelete($model)
    {
        return is_array(class_uses($model)) &&
               count(class_uses($model)) > 0 &&
               in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model));
    }

    /**
     * Establece datos en cache
     *
     * @author Ing. Roldan Vargas <roldandvg at gmail.com> | <rvargas at cenditel.gob.ve>
     *
     * @param  string $key  Clave del cache en el cual gestionar la información
     */
    public static function setCacheEvents($key)
    {
        static::saved(function ($model) use ($key) {
            $record = $model->where('id', $model->id)->orderBy('created_at', 'desc')->get();
            
            if (Cache::has($key)) {
                $cacheData = Cache::get($key);
                $record = $cacheData->merge($record);
                Cache::put($key, $record);
            } else {
                Cache::rememberForever($key, function () use ($record) {
                    return $record;
                });
            }
        });

        static::updated(function ($model) use ($key) {
            $record = $model->where('id', $model->id)->orderBy('updated_at', 'desc')->get();
            
            if (Cache::has($key)) {
                $cacheData = Cache::get($key);
                $record = $cacheData->filter(function($doc) use ($model) {
                    return $doc->id !== $model->id;
                })->merge($record);
                Cache::put($key, $record);
            } else {
                Cache::rememberForever($key, function () use ($record) {
                    return $record;
                });
            }
        });

        static::deleted(function ($model) use ($key) {
            if (Cache::has($key)) {
                $cacheData = Cache::get($key);
                $record = $cacheData->filter(function ($doc) use ($model) {
                    return $doc->id !== $model->id;
                });
                Cache::put($key, $record);
            }
        });

        static::restored(function ($model) use ($key) {
            $record = $model->where('id', $model->id)->orderBy('updated_at', 'desc')->get();
            
            if (Cache::has($key)) {
                $cacheData = Cache::get($key);
                $record = $cacheData->merge($record);
                Cache::put($key, $record);
            } else {
                Cache::rememberForever($key, function () use ($record) {
                    return $record;
                });
            }
        });
    }
}
