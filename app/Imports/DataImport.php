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
 * @author   Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
class DataImport implements ToCollection, WithHeadingRow
{
    use Importable;

    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return $collection;
    }
}
