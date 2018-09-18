<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Asset\Models\Asset;
use Modules\Asset\Models\Type;
use Modules\Asset\Models\Category;
use Modules\Asset\Models\Subcategory;
use Modules\Asset\Models\SpecificCategory;


class ServiceController extends Controller
{
	/** @var array Lista de elementos a mostrar */
	protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author  
     */
	public function __construct() {
		$this->data[0] = [
    		'id' => 0,
    		'text' => 'Seleccione...'
    	];
	}

    /**
	 * Obtiene todos las Categorias registradas
     *
     * @author  
	 * @return [json] JSON con los datos de las categorías registradas
	 */
    public function GetCategories()
    {
    	foreach (Category::all() as $categories) {
    		$this->data[] = [
    			'id' => $categories->id,
    			'text' => $categories->name
    		];
    	}

    	return response()->json($this->data);
        
    }
    
    /**
     * Obtiene las subcategorías de la categoría general seleccionada
     *
     * @author 
     * @param  [integer] $category_id Identificador de la categoría general
     * @return [json] 	 JSON con los datos de las subcategorías asociadas a la categoría seleccionada
     */
    public function GetSubcategories($category_id)
    {
    	foreach (Subcategory::where('category_id', $category_id)->get() as $subcategories) {
    		$this->data[] = [
    			'id' => $subcategories->id,
    			'text' => $subcategories->name
    		];
    	}

    	return response()->json($this->data);
    }
}
