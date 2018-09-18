<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;

/**
 * @class ServiceController
 * @brief Controlador de Servicios del Módulo de Bienes
 * 
 * Clase que gestiona los registros utilizados en los elemnetos del tipo select2
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class ServiceController extends Controller
{
    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct() {
        $this->data[0] = [
            'id' => 0,
            'text' => 'Seleccione...'
        ];
    }

    /**
     * Obtiene todos los Tipos de Bienes registrados
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return [json] JSON con los datos de los Tipos de Bienes registrados
     */
    public function GetTypes()
    {
        foreach (AssetType::all() as $type) {
            $this->data[] = [
                'id' => $type->id,
                'text' => $type->name
            ];
        }

        return response()->json($this->data);
        
    }
    /**
     * Obtiene todos las Categorias registradas al tipo de Bien seleccionado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return [json] JSON con los datos de las categorías registradas
     */
    public function GetCategories($type_id)
    {
        foreach (AssetCategory::where('asset_type_id', $type_id)->get() as $category) {
            $this->data[] = [
                'id' => $category->id,
                'text' => $category->name
            ];
        }

        return response()->json($this->data);
        
    }
    
    /**
     * Obtiene las subcategorías de la categoría general seleccionada
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  [integer] $category_id Identificador de la categoría general
     * @return [json]    JSON con los datos de las subcategorías asociadas a la categoría seleccionada
     */
    public function GetSubcategories($category_id)
    {
        foreach (AssetSubcategory::where('asset_category_id', $category_id)->get() as $subcategory) {
            $this->data[] = [
                'id' => $subcategory->id,
                'text' => $subcategory->name
            ];
        }

        return response()->json($this->data);
    }
    /**
     * Obtiene todos los Tipos de Bienes Registrados
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function vueListTypes()
    {
        return response()->json(['records' => AssetType::all()], 200);
    }
}
