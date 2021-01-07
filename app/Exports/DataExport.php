<?php

/** Gestiona la exportación de datos */
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * @class DataExport
 * @brief Permite la exportación de datos
 *
 * Permite la exportación de datos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class DataExport implements FromCollection, WithHeadingRow
{
    use Exportable;

    /**
     * Nombre del modelo al cual se va a realizar la exportación de datos
     *
     * @var    string   $model  Nombre del modelo
     */
    protected $model;

    /**
     * Método constructor de la clase
     *
     * @method    __contruct(object $model)
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     object|null   $model    Objeto con información del modelo para el cual se van a exportar los datos
     */
    public function __contruct($model = null)
    {
        $this->model = $model;
    }
}
