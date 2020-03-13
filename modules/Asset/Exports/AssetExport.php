<?php

namespace Modules\Asset\Exports;

use Modules\Asset\Models\Asset;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class AssetExport extends \App\Exports\DataExport implements
    WithHeadings,
    ShouldAutoSize,
    WithMapping
{

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Asset::all();
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
            'asset_type_id',
            'asset_type',
            'asset_category_id',
            'asset_category',
            'asset_subcategory_id',
            'asset_subcategory',
            'asset_specific_category_id',
            'asset_specific_category',
            'asset_condition_id',
            'asset_condition',
            'asset_acquisition_type_id',
            'asset_acquisition_type',
            'acquisition_year',
            'asset_status_id',
            'asset_status',
            'serial',
            'marca',
            'model',
            'inventory_serial',
            'value',
            'asset_use_function_id',
            'asset_use_function',
            'specifications',
            'address',
            'parish_id',
            'parish',
            'currency_id',
            'currency',
            'institution_id',
            'institution'
        ];
    }

    /**
     * Establece las columnas que van a ser exportadas
     *
     * @method    map
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     object    $asset    Objeto con las propiedades del modelo a exportar
     *
     * @return    array     Arreglo con los campos estrictamente a ser exportados
     */
    public function map($asset): array
    {
        return [
            $asset->id,
            $asset->assetType->id,
            $asset->assetType->name,
            $asset->assetCategory->id,
            $asset->assetCategory->name,
            $asset->assetSubcategory->id,
            $asset->assetSubcategory->name,
            $asset->assetSpecificCategory->id,
            $asset->assetSpecificCategory->name,
            $asset->assetCondition->id,
            $asset->assetCondition->name,
            $asset->assetAcquisitionType->id,
            $asset->assetAcquisitionType->name,
            $asset->acquisition_year,
            $asset->assetStatus->id,
            $asset->assetStatus->name,
            $asset->serial,
            $asset->marca,
            $asset->model,
            $asset->inventory_serial,
            $asset->value,
            $asset->assetUseFunction->id,
            $asset->assetUseFunction->name,
            $asset->specifications,
            $asset->address,
            $asset->parish->id,
            $asset->parish->name,
            $asset->currency->id,
            $asset->currency->name,
            $asset->institution->id,
            $asset->institution->name
        ];
    }
}
