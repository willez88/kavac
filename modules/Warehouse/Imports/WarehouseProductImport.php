<?php

namespace Modules\Warehouse\Imports;

use Modules\Warehouse\Models\WarehouseProduct;
use App\Models\MeasurementUnit;
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
        if (empty($row['measurement_unit_id']) || is_null($row['measurement_unit_id'])) {
            /** @var array Datos de la unidad de medida a la cual asociar la información del producto */
            $dataMeasurementUnit = [
                'name'        => $row['measurement_unit'],
                'acronym'     => $row['measurement_unit_acronym'],
                'description' => $row['measurement_unit_description']
            ];
            /** @var object Crea la nueva unidad de medida a ser asociado el producto */
            $measurementUnit = MeasurementUnit::create($dataMeasurementUnit);
        } else {
            /** @var object Contiene los datos de la unidad de medida asociada al producto */
            $measurementUnit = MeasurementUnit::find($row['measurement_unit_id']);
        }

        /** @var array Datos de los productos a importar */
        $data = [
            'name'                => $row['name'],
            'description'         => $row['description'],
            'measurement_unit_id' => $measurementUnit->id
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
