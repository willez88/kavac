<?php
/**
 * Exports - Gestión la estructura de datos del sistema a exportar
 *
 * @package  Exports
 * @author   Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataExport implements FromCollection, WithHeadingRow
{
	use Exportable;

	protected $model;

	public function __contruct($model = null)
	{
		$this->model = $model;
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
    }
}
