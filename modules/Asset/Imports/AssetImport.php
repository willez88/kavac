<?php

namespace Modules\Asset\Imports;

use Modules\Asset\Models\Asset;

use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetSpecificCategory;
use Modules\Asset\Models\AssetCondition;
use Modules\Asset\Models\AssetAcquisitionType;
use Modules\Asset\Models\AssetStatus;
use Modules\Asset\Models\AssetUseFunction;
use App\Models\Currency;
use App\Models\Institution;
use App\Models\Parish;
use Maatwebsite\Excel\Concerns\ToModel;

class AssetImport extends \App\Imports\DataImport implements
    ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        /** @var array Datos del tipo de bien al cual asociar la información del bien */
        $dataAssetType = [
            'name' => $row['asset_type']
        ];

        if (empty($row['asset_type_id']) || is_null($row['asset_type_id'])) {
            /** @var object Crea el nuevo tipo de bien a ser asociado al bien */
            $assetType = Category::create($dataCategory);
        } else {
            /** @var object Contiene los datos del tipo de bien asociado al bien */
            $assetType = AssetType::find($row['asset_type_id']);
        }

        /** @var array Datos de la categoría al cual asociar la información del bien */
        $dataAssetCategory = [
            'name'          => $row['asset_category'],
            'asset_type_id' => $assetType->id
        ];

        if (empty($row['asset_category_id']) || is_null($row['asset_category_id'])) {
            /** @var object Crea la nueva categoría a ser asociada al bien */
            $assetCategory = Category::create($dataAssetCategory);
        } else {
            /** @var object Contiene los datos de la categoría asociada al bien */
            $assetCategory = AssetCategory::find($row['asset_category_id']);
        }

        /** @var array Datos de la sub-categoría al cual asociar la información del bien */
        $dataAssetSubcategory = [
            'name'              => $row['asset_subcategory'],
            'asset_category_id' => $assetCategory->id
        ];

        if (empty($row['asset_subcategory_id']) || is_null($row['asset_subcategory_id'])) {
            /** @var object Crea la nueva sub-categoría a ser asociada al bien */
            $assetSubcategory = Subcategory::create($dataAssetSubcategory);
        } else {
            /** @var object Contiene los datos de la subcategoría asociada al bien */
            $assetSubcategory = AssetSubcategory::find($row['asset_subcategory_id']);
        }

        /** @var array Datos de la categoría específica al cual asociar la información del bien */
        $dataAssetSpecificCategory = [
            'name'              => $row['asset_specific_category'],
            'asset_subcategory_id' => $assetSubcategory->id
        ];

        if (empty($row['asset_specific_category_id']) || is_null($row['asset_specific_category_id'])) {
            /** @var object Crea la nueva categoría específica a ser asociada al bien */
            $assetSpecificCategory = AssetSpecificCategory::create($dataAssetSpecificCategory);
        } else {
            /** @var object Contiene los datos de la categoría específica asociada al bien */
            $assetSpecificCategory = AssetSpecificCategory::find($row['asset_specific_category_id']);
        }

        /** @var array Datos de la condición física al cual asociar la información del bien */
        $dataAssetCondition = [
            'name' => $row['asset_condition']
        ];

        if (empty($row['asset_condition_id']) || is_null($row['asset_condition_id'])) {
            /** @var object Crea la nueva condición física a ser asociada al bien */
            $assetCondition = AssetCondition::create($dataAssetCondition);
        } else {
            /** @var object Contiene los datos de la condición física asociada al bien */
            $assetCondition = AssetCondition::find($row['asset_condition_id']);
        }

        /** @var array Datos del tipo de adquisición al cual asociar la información del bien */
        $dataAssetAcquisitionType = [
            'name' => $row['asset_acquisition_type']
        ];

        if (empty($row['asset_acquisition_type_id']) || is_null($row['asset_acquisition_type_id'])) {
            /** @var object Crea el nuevo tipo de adquisición a ser asociada al bien */
            $assetAcquisitionType = AssetAcquisitionType::create($dataAssetAcquisitionType);
        } else {
            /** @var object Contiene los datos del tipo de adquisición asociado al bien */
            $assetAcquisitionType = AssetAcquisitionType::find($row['asset_acquisition_type_id']);
        }

        /** @var array Datos del estatus de uso al cual asociar la información del bien */
        $dataAssetStatus = [
            'name' => $row['asset_status']
        ];

        if (empty($row['asset_status_id']) || is_null($row['asset_status_id'])) {
            /** @var object Crea el nuevo estatus de uso a ser asociada al bien */
            $assetStatus = AssetStatus::create($dataAssetStatus);
        } else {
            /** @var object Contiene los datos del estatus de uso asociado al bien */
            $assetStatus = AssetStatus::find($row['asset_status_id']);
        }

        /** @var array Datos de la moneda al cual asociar la información del bien */
        $dataCurrency = [
            'name' => $row['currency']
        ];

        if (empty($row['currency_id']) || is_null($row['currency_id'])) {
            /** @var object Crea la nueva moneda a ser asociada al bien */
            $currency = Currency::create($dataCurrency);
        } else {
            /** @var object Contiene los datos de la moneda asociada al bien */
            $currency = Currency::find($row['currency_id']);
        }

        if (!(empty($row['institution_id']) || is_null($row['institution_id']))) {
            /** @var object Contiene los datos de la moneda asociada al bien */
            $institution = Institution::find($row['institution_id']);
        }

        /** @var array Datos de la función de uso al cual asociar la información del bien */
        $dataUseFunction = [
            'name' => $row['asset_use_function']
        ];

        if (empty($row['asset_use_function_id']) || is_null($row['asset_use_function_id'])) {
            /** @var object Crea la nueva función de uso a ser asociada al bien */
            $assetUseFunction = AssetUseFunction::create($dataUseFunction);
        } else {
            /** @var object Contiene los datos de la función de uso asociada al bien */
            $assetUseFunction = AssetUseFunction::find($row['asset_use_function_id']);
        }

        /** @var array Datos de la parroquia al cual asociar la información del bien */
        $dataParish = [
            'name' => $row['parish']
        ];

        if (empty($row['parish_id']) || is_null($row['parish_id'])) {
            /** @var object Crea la nueva parroquia a ser asociada al bien */
            $parish = Parish::create($dataParish);
        } else {
            /** @var object Contiene los datos de la parroquia asociada al bien */
            $parish = Parish::find($row['parish_id']);
        }


        /** @var array Datos de los bienes a importar */
        $data = [
            'asset_type_id'              => $assetType->id,
            'asset_category_id'          => $assetCategory->id,
            'asset_subcategory_id'       => $assetSubcategory->id,
            'asset_specific_category_id' => $assetSpecificCategory->id,
            'specifications'             => $row['specifications'],
            'asset_condition_id'         => $assetCondition->id,
            'asset_acquisition_type_id'  => $assetAcquisitionType->id,
            'acquisition_date'           => $row['acquisition_date'],
            'asset_status_id'            => $assetStatus->id,
            'serial'                     => $row['serial'],
            'marca'                      => $row['marca'],
            'model'                      => $row['model'],
            'value'                      => $row['value'],
            'currency_id'                => $currency->id,
            'institution_id'             => $institution->id,
            'asset_use_function_id'      => $assetUseFunction->id,
            'parish_id'                  => $parish->id,
            'address'                    => $row['address']
        ];

        if (!empty($row['id']) || !is_null($row['id'])) {
            return Asset::updateOrCreate(
                ['id' => $row['id']],
                $data
            );
        }
        return new Asset($data);
    }
}
