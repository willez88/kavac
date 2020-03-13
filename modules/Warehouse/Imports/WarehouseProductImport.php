<?php

namespace Modules\Warehouse\Imports;

use Modules\Warehouse\Models\WarehouseProduct;
use Maatwebsite\Excel\Concerns\ToModel;

class WarehouseProductImport extends \App\Imports\DataImport implements
    ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        /** @var array Datos de los productos a importar */
        $data = [
            'name'        => $row['name'],
            'description' => $row['description'],
            'measurement_unit' => $row['measurement_unit']
        ];

        if (!empty($row['id']) || !is_null($row['id'])) {
            return WarehouseProduct::updateOrCreate(
                ['id' => $row['id']],
                $data
            );
        }
        return new WarehouseProduct($data);
    }
}
