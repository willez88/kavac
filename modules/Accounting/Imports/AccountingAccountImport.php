<?php

namespace Modules\Accounting\Imports;

use Modules\Accounting\Models\AccountingAccount;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AccountingAccountImport implements ToModel, WithHeadingRow, WithValidation
{
    use Importable;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $code = explode('.', $row['codigo']);
        if (count($code) == 7) {
            return AccountingAccount::updateOrCreate(
                [
                    'group'         => $code[0],
                    'subgroup'      => $code[1],
                    'item'          => $code[2],
                    'generic'       => $code[3],
                    'specific'      => $code[4],
                    'subspecific'   => $code[5],
                    'institutional' => $code[6],
                ],
                [
                    'denomination' => $row['denominacion'],
                    'status' => ($row['activa'] == 'SI')?true:false,
                ]
            );
        }
    }

    /**
     * Reglas de validación
     *
     * @method     rules
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     *
     * @return     Array           Devuelve un arreglo con las reglas de validación
     */
    public function rules(): array
    {
        return [
            '*.codigo'       => ['required'],
            '*.denominacion' => ['required'],
            '*.activa'       => ['required','max:2'],
        ];
    }

    /**
     * Mensajes de validación personalizados
     *
     * @method     customValidationMessages
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     *
     * @return     array                      Devuelve un arreglo con los mensajes de validación personalizados
     */
    public function customValidationMessages(): array
    {
        return [
            'codigo.required'       => 'Error en la fila :row. El campo :attribute es obligatorio',
            'denominacion.required' => 'Error en la fila :row. El campo :attribute es obligatorio',
            'activa.required'       => 'Error en la fila :row. El campo :attribute es obligatorio',
            'activa.max'            => 'Error en la fila :row. El campo :attribute debe ser de maximo 2 caracteres.',
        ];
    }
}
