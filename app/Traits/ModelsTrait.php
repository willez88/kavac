<?php
namespace App\Traits;

trait ModelsTrait
{
	/**
	 * Método que escanea todos los modelos presentes en la aplicación
	 *
	 * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @return array                Retorna un arreglo con los módulos
	 */
	function getModels() {
		$path = app_path() . "/Models";
		$modules_path = base_path() . '/modules';

		$out = [];
		$results = scandir($path);

		foreach ($results as $result) {

			if ($result === '.' or $result === '..' or $result === 'Session.php') {
				continue;
			}

			$filename = $result;

			if (is_dir($filename)) {
				$out = array_merge($out, 'App\Models\\' . getModels($filename));
			}
			else {
				$out[] = 'App\Models\\' . substr($filename,0,-4);
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
				if ($model === '.' or $model === '..' or $model === '.gitkeep' or $model === 'AssetClasification.php') {
					continue;
				}
				$filename_m = $model;
				if (is_dir($filename_m)) {
					$out = array_merge($out, 'Modules\\' . $filename_module . '\\Models\\' . getModels($filename_m));
				}
				else {
					$out[] = 'Modules\\' . $filename_module . '\\Models\\' . substr($filename_m,0,-4);
				}
			}
		}
		
		return $out;
	}

	/**
	 * Identifica si un modelo esta establecido para una eliminación lógica
	 *
	 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param  string  $model Nombre del modelo a evaluar
	 * @return boolean        Devuelve verdadero si el modelo esta establecido para una eliminación lógica, 
	 *                        de lo contrario devuelve falso
	 */
	public function isModelSoftDelete($model)
	{
		return in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($model));
	}

	/**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return array Listado de registros para ser implementados en plantillas
     */
    public static function template_choices($field = 'name')
    {
        $options = [];
        foreach (self::all() as $reg) {
            $options[$reg->id] = $reg->$field;
        }
        return $options;
    }
}