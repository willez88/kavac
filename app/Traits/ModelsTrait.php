<?php
namespace App\Traits;

/**
 * Trait para la gestión de modelos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
trait ModelsTrait
{
    /**
     * Método que escanea todos los modelos presentes en la aplicación
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  string  $model Nombre del modelo a evaluar
     * @return boolean        Devuelve verdadero si el modelo esta establecido para una eliminación lógica,
     *                        de lo contrario devuelve falso
     */
    public function isModelSoftDelete($model)
    {
        return is_array(class_uses($model)) &&
               count(class_uses($model)) > 0 &&
               in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model));
    }
}
