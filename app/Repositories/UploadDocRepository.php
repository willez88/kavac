<?php
namespace App\Repositories;

use \Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Facades\Session;

class UploadDocRepository
{
	private $doc_name;
	private $doc_extension;
	private $doc_stored;
	private $allowed_upload = [];
	private $error_msg = '';

	public function __construct()
	{
		//
	}

	/**
	 * Instrucciones para verificar y subir un documento a la ruta indicada en el servidor
	 * @param  object  $file 		 Objeto con el archivo a subir
	 * @param  string  $store        Ruta en la que se va a almacenar el archivo
	 * @param  boolean $sign         Indica si el archivo a subir será firmado digitalmente
	 * @param  boolean $originalName Indica si el archivo a subir es con el nombre original del mismo
	 * @param  boolean $checkAllowed Indica si se va a verificar el tipo de archivo permitido para subir
	 * @return boolean               Retorna falso en caso de cualquier error, de lo contrario retorna verdadero
	 */
	public function uploadDoc($file, $store, $sign=false, $originalName=false, $checkAllowed=false)
	{
		if (!$file->getError()) {
			$this->doc_extension = strtolower($file->getClientOriginalExtension());
			$this->doc_name = ($originalName)?
							  $file->getClientOriginalName():
							  uniqid('', true) . '.' . $this->doc_extension;

			if (in_array($this->doc_extension, $this->allowed_upload) || !$checkAllowed) {
				if ($sign) {
					// Procedimiento para la firma electrónica antes de subirlo al servidor
				}
				
				$upload = Storage::disk($store)->put($this->doc_name, \File::get($file));
				if ($upload) {
					// Procedimiento para guardar el documento en la tabla respectiva, incluyendo al documento mismo que DEBE ser almacenado en la base de datos
					 
					return true;
				}
				else {
					$this->error_msg = 'Error al subir el archivo, verifique e intente de nuevo';
				}
			}
			else {
				$this->error_msg = 'La extensión del archivo es inválida. ' . 
								   'Verifique e intente nuevamente';
			}
		}
		else {
			$this->error_msg = 'Error al procesar el archivo. ' . 
							   'Verifique que este correcto e intente nuevamente';
		}
		Session::flash('message', [
			'type' => 'other', 'class' => 'warning', 'title' => 'Alerta!', 
			'msg' => $this->error_msg
		]);
		return false;
	}

	/**
	 * Obtiene el nombre del documento
	 * @return string Retorna el nombre del documento
	 */
	public function getDocName()
	{
		return $this->doc_name;
	}

	/**
	 * Obtiene la extensión del documento
	 * @return string Retorna la extensión del documento
	 */
	public function getDocExtension()
	{
		return $this->doc_extension;
	}

	/**
	 * Obtiene el mensaje de error a mostrar al usuario
	 * @return string Devuelve un mensaje con el error si existe, en caso contrario retorna una cadena vacia
	 */
	public function getErrorMessage()
	{
		return $this->error_msg;
	}

	/**
	 * Obtiene el objeto del documento guardado
	 * @return object Devuelve el objeto del documento guardado
	 */
	public function getDocStored()
	{
		return $this->doc_stored;
	}

	/**
	 * Verifica la existencia de un documento y lo elimina del disco
	 * @param  string $doc   Contiene el nombre del documento a eliminar
	 * @param  string $store Contiene la ruta en la que se encuentra almacenado el documento
	 */
	public function deleteDoc($doc, $store)
	{
		if (Storage::disk($store)->exists($doc)) {
			Storage::disk($store)->delete($doc);
		}
	}
}