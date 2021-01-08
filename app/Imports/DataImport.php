<?php
/** Gestión da importación de datos */
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Imports - Gestión la estructura de datos del sistema a importar
 *
 * @package  Imports
 *
 * @author   Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class DataImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
     * Colección de registros a importar
     *
     * @method    collection
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Collection    $collection    Objeto con los datos a importar
     *
     * @return    Collection    Devuelve una colección de objetos
     */
    public function collection(Collection $collection)
    {
        return $collection;
    }
}
