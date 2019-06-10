<?php
namespace App\Repositories;

use \Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Models\Image;

/**
 * @class UploadImageRepository
 * @brief Gestiona las acciones a ejecutar en la carga de imágenes al servidor
 * 
 * Gestiona las acciones que se deben realizar en la carga de imágenes al servidor
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class UploadImageRepository
{
	private $image_name;
	private $image_extension;
	private $image_stored;
	private $allowed_upload = [];
	private $min_sizes = ['width' => '480', 'height' => '480'];
	private $max_sizes = ['width' => '1280', 'height' => '900'];
	private $error_msg = '';

	public function __construct()
	{
		//
	}

	/**
	 * Instrucciones para verificar y subir una imagen a la ruta indicada en el servidor
	 *
	 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param  object|array|null  $file       Objeto con el archivo a subir
	 * @param  string  $store      Ruta en la que se va a almacenar el archivo
	 * @param  boolean $originalName Indica si el archivo a subir es con el nombre original del mismo
	 * @param  boolean $verifySize Indica si será verificado o no el tamaño de la imagen
	 * @return boolean             Retorna falso en caso de cualquier error, de lo contrario retorna verdadero
	 */
	public function uploadImage($file, $store, $originalName=false, $verifySize=false, $checkAllowed=false)
	{
		if (!$file->getError()) {
			$this->image_extension = strtolower($file->getClientOriginalExtension());
			$this->image_name = ($originalName)?$file->getClientOriginalName():uniqid('', true) . '.' . $this->image_extension;

			if (in_array($this->image_extension, $this->allowed_upload) || !$checkAllowed) {
				if ($verifySize == true && !$this->verifySize($file)) {
					$this->error_msg = 'La imagen debe tener al menos ' . $this->min_sizes['width'] . 'px X ' . 
					$this->min_sizes['height'] . 'px, y no debe ser mayor a ' . $this->max_sizes['width'] . 'px X ' . 
					$this->max_sizes['height'] . 'px.';
				}
				else {
					$upload = Storage::disk($store)->put($this->image_name, File::get($file));
					if ($upload) {
						$this->image_stored = Image::create([
							'file' => $this->image_name,
							'url' => 'storage/pictures/'. $this->image_name
						]);
						 
						return true;
					}
					else {
						$this->error_msg = 'Error al subir el archivo, verifique e intente de nuevo';
					}
				}
			}
			else {
				$this->error_msg = 'La extensión del archivo es inválida. Verifique e intente nuevamente';
			}
		}
		else {
			$this->error_msg = 'Error al procesar el archivo. Verifique que este correcto y sea del tamaño permitido e intente nuevamente';
		}
		session()->flash('message', ['type' => 'other', 'class' => 'warning', 'title' => 'Alerta!', 'msg' => $this->error_msg]);
		return false;
	}

	/**
	 * Obtiene el nombre de la image
	 *
	 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @return string Retorna el nombra de la imagen
	 */
	public function getImageName()
	{
		return $this->image_name;
	}

	/**
	 * Obtiene la extensión de la imagen
	 *
	 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @return string Retorna la extensión de la imagen
	 */
	public function getImageExtension()
	{
		return $this->image_extension;
	}

	/**
	 * Obtiene el mensaje de error a mostrar al usuario
	 *
	 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @return string Devuelve un mensaje con el error si existe, en caso contrario retorna una cadena vacia
	 */
	public function getErrorMessage()
	{
		return $this->error_msg;
	}

	/**
	 * Obtiene el objeto de la imagen guardada
	 *
	 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @return object Devuelve el objeto de la imagen guardada
	 */
	public function getImageStored()
	{
		return $this->image_stored;
	}

	/**
	 * Verifica la existencia de una imagen y la elimina del disco
	 *
	 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param  string $img   Contiene el nombre de la imagen a eliminar
	 * @param  string $store Contiene la ruta en la que se encuentra almacenada la imagen
	 */
	public function deleteImage($img, $store)
	{
		if (Storage::disk($store)->exists($img)) {
			Storage::disk($store)->delete($img);
		}
	}

	/**
	 * Verifica que el tamaño de la imagen corresponda con el mínimo y máximo permitido
	 *
	 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
	 * @param  object   $image Objeto que contiene la imagen a procesar
	 * @return boolean	Devuelve verdadero si el tamaño de la imagen corresponde con el permitido, 
	 *                  de lo contrario retorna falso
	 */
	public function verifySize($image) {
		$size = getimagesize($image);
		$min_width = $this->min_sizes['width'];
		$min_height = $this->min_sizes['height'];
		$max_width = $this->max_sizes['width'];
		$max_height = $this->max_sizes['height'];
		return ($size[0]>=$min_width && $size[1]>=$min_height && $size[0]<=$max_width && $size[1]<=$max_height);
	}
}
