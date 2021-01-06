<?php

/** Repositorios del sistema */
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
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UploadImageRepository
{
    /** @var string Nombre del archivo de imagen a guardar */
    private $image_name;
    /** @var string Extensión del archivo que define el tipo de imagen */
    private $image_extension;
    /** @var string Ruta en donde se guarda el archivo */
    private $image_stored;
    /** @var array Listado de archivos permitidos de acuerdo a su extensión */
    private $allowed_upload = [];
    /** @var array Define las dimensiones mínimas, por defecto, de la imagen */
    private $min_sizes = ['width' => '480', 'height' => '480'];
    /** @var array Define las dimensiones máximas, por defecto, de la imagen */
    private $max_sizes = ['width' => '1280', 'height' => '900'];
    /** @var string Establece el mensaje de error que se haya generado en alguno de los procesos */
    private $error_msg = '';

    public function __construct()
    {
        //
    }

    /**
     * Instrucciones para verificar y subir una imagen a la ruta indicada en el servidor
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  object|array|null  $file       Objeto con el archivo a subir
     * @param  string  $store      Ruta en la que se va a almacenar el archivo
     * @param  string  $model        Modelo con el que se relaciona
     * @param  integer $model_id     Id del modelo con el que se relaciona
     * @param  boolean $originalName Indica si el archivo a subir es con el nombre original del mismo
     * @param  boolean $verifySize Indica si será verificado o no el tamaño de la imagen
     * @return boolean             Retorna falso en caso de cualquier error, de lo contrario retorna verdadero
     */
    public function uploadImage(
        $file,
        $store,
        $model = null,
        $model_id = null,
        $originalName = false,
        $verifySize = false,
        $checkAllowed = false
    ) {
        if (!$file->getError()) {
            $this->image_extension = strtolower($file->getClientOriginalExtension());
            $this->image_name = ($originalName)?$file->getClientOriginalName():uniqid('', true) .
                                '.' . $this->image_extension;

            if (in_array($this->image_extension, $this->allowed_upload) || !$checkAllowed) {
                if ($verifySize == true && !$this->verifySize($file)) {
                    $this->error_msg = __(
                        'La imagen debe tener al menos :minwidth px X :minheight , ' .
                        'y no debe ser mayor a :maxwidth px X :maxheight px',
                        [
                            'minwidth' => $this->min_sizes['width'],
                            'minheight' => $this->min_sizes['height'],
                            'maxwidth' => $this->max_sizes['width'],
                            'maxheight' => $this->max_sizes['height']
                        ]
                    );
                } else {
                    /** @var object Objeto con información del archivo guardado */
                    $upload = Storage::disk($store)->put($this->image_name, File::get($file));
                    if ($upload) {
                        $this->image_stored = Image::create([
                            'file' => $this->image_name,
                            'url' => 'storage/pictures/'. $this->image_name,
                            'imageable_type' => $model,
                            'imageable_id' => $model_id
                        ]);

                        return true;
                    } else {
                        $this->error_msg = __('Error al subir el archivo, verifique e intente de nuevo');
                    }
                }
            } else {
                $this->error_msg = __('La extensión del archivo es inválida. Verifique e intente nuevamente');
            }
        } else {
            if (!check_max_upload_size($file)) {
                $this->error_msg = _('El archivo supera el tamaño máximo permitido');
            } else {
                $this->error_msg = __(
                    'Error al procesar el archivo. Verifique que este correcto y ' .
                    'sea del tamaño permitido e intente nuevamente'
                );
            }
        }
        session()->flash('message', [
            'type' => 'other', 'class' => 'warning', 'title' => __('Alerta!'), 'msg' => $this->error_msg
        ]);
        return false;
    }

    /**
     * Obtiene el nombre de la image
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return string Retorna el nombra de la imagen
     */
    public function getImageName()
    {
        return $this->image_name;
    }

    /**
     * Obtiene la extensión de la imagen
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return string Retorna la extensión de la imagen
     */
    public function getImageExtension()
    {
        return $this->image_extension;
    }

    /**
     * Obtiene el mensaje de error a mostrar al usuario
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return string Devuelve un mensaje con el error si existe, en caso contrario retorna una cadena vacia
     */
    public function getErrorMessage()
    {
        return $this->error_msg;
    }

    /**
     * Obtiene el objeto de la imagen guardada
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return object Devuelve el objeto de la imagen guardada
     */
    public function getImageStored()
    {
        return $this->image_stored;
    }

    /**
     * Verifica la existencia de una imagen y la elimina del disco
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
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
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  object   $file  Objeto que contiene el archivo a procesar
     * @param  boolean  $image Define si la comprobación corresponde a las dimensiones de una imagen, de lo contrario
     *                         verifica el tamaño de un archivo
     * @return boolean  Devuelve verdadero si el tamaño del archivo corresponde con el permitido,
     *                  de lo contrario retorna falso
     */
    public function verifySize($file, $image = true)
    {
        if ($image) {
            $size = getimagesize($file);
            $min_width = $this->min_sizes['width'];
            $min_height = $this->min_sizes['height'];
            $max_width = $this->max_sizes['width'];
            $max_height = $this->max_sizes['height'];
            return ($size[0]>=$min_width && $size[1]>=$min_height && $size[0]<=$max_width && $size[1]<=$max_height);
        }

        return false;
    }
}
