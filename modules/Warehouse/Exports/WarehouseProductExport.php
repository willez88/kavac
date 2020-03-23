<?php

namespace Modules\Warehouse\Exports;

use Modules\Warehouse\Models\WarehouseProduct;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class WarehouseProductExport extends \App\Exports\DataExport implements
    WithHeadings,
    ShouldAutoSize,
    WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return WarehouseProduct::all();
    }

    /**
     * Establece las cabeceras de los datos en el archivo a exportar
     *
     * @method    headings
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    array    Arreglo con las cabeceras de los datos a exportar
     */
    public function headings(): array
    {
        return [
            'id',
            'name',
            'description',
            'measurement_unit'
        ];
    }

    /**
     * Establece las columnas que van a ser exportadas
     *
     * @method    map
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     object    $warehouseProduct    Objeto con las propiedades del modelo a exportar
     *
     * @return    array     Arreglo con los campos estrictamente a ser exportados
     */
    public function map($warehouseProduct): array
    {
        return [
            $warehouseProduct->id,
            $warehouseProduct->name,
            $warehouseProduct->description,
            $warehouseProduct->measurementUnit->name
        ];
    }
}
