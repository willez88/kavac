<?php
namespace Modules\Payroll\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;        # Agregar Cabecera
use Maatwebsite\Excel\Concerns\ShouldAutoSize;      # AutoEspaciar Columnas
use Maatwebsite\Excel\Concerns\WithEvents;          # Registrar Evento
use Maatwebsite\Excel\Events\AfterSheet;            # Modificar Fuentes y Tamaño
use Maatwebsite\Excel\Concerns\WithCustomStartCell; # Indicar la celda en la que debe comenzar (solo FromCollection)
use Illuminate\Database\Eloquent\Collection;

use Modules\Payroll\Models\PayrollSalaryTabulatorScale;
use Modules\Payroll\Models\PayrollSalaryTabulator;

/**
 * @class PayrollSalaryTabulatorExport
 *
 * Clase que gestiona los objetos exportados del modelo de tabuladores salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollSalaryTabulatorExport extends \App\Exports\DataExport implements
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    WithCustomStartCell
{
    protected $payrollSalaryTabulatorId;

    public function __contruct($model = null)
    {
        $this->model = $model;
    }

    /**
     * Establece el identificador del tabulador salarial
     *
     * @param Integer $salaryTabulatorId Identificador único del tabuldor salarial
     */
    public function setSalaryTabulatorId(int $salaryTabulatorId)
    {
        $this->payrollSalaryTabulatorId = $salaryTabulatorId;
    }
    

    /**
     * Establece la celda en la que se debe comenzar a escribir el archivo a exportar
     *
     * @return string Celda de inicio de escritura
     */
    public function startCell(): string
    {
        return 'B5';
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $payrollSalaryTabulator = PayrollSalaryTabulator::where('id', $this->payrollSalaryTabulatorId)->first();
        $fields  = [];
        $records = [];
        if ($payrollSalaryTabulator) {
            $payrollSalaryTabulatorScales = PayrollSalaryTabulatorScale::where([
                'payroll_salary_tabulator_id' => $this->payrollSalaryTabulatorId
            ])->with([
                'payrollSalaryTabulator',
                'payrollHorizontalScale',
                'payrollVerticalScale'
            ])->get();
            foreach ($payrollSalaryTabulatorScales as $payrollSalaryTabulatorScale) {
                if (($payrollSalaryTabulator->payroll_horizontal_salary_scale_id > 0)
                && ($payrollSalaryTabulator->payroll_vertical_salary_scale_id > 0)) {
                    $horizontalScale = $payrollSalaryTabulatorScale->payrollHorizontalScale;
                    $verticalScale = $payrollSalaryTabulatorScale->payrollVerticalScale;
                    $fields[$horizontalScale->code . '-' . $verticalScale->code] = $payrollSalaryTabulatorScale->value;
                } elseif ($payrollSalaryTabulator->payroll_horizontal_salary_scale_id > 0) {
                    $horizontalScale = $payrollSalaryTabulatorScale->payrollHorizontalScale;
                    $fields[$horizontalScale->code] = $payrollSalaryTabulatorScale->value;
                } elseif ($payrollSalaryTabulator->payroll_vertical_salary_scale_id > 0) {
                    $verticalScale = $payrollSalaryTabulatorScale->payrollVerticalScale;
                    $fields[$verticalScale->code] = $payrollSalaryTabulatorScale->value;
                }
            }

            if (($payrollSalaryTabulator->payroll_horizontal_salary_scale_id > 0)
                && ($payrollSalaryTabulator->payroll_vertical_salary_scale_id > 0)) {
                $payrollHorizontalSalaryScale = $payrollSalaryTabulator->payrollHorizontalSalaryScale;
                $payrollVerticalSalaryScale = $payrollSalaryTabulator->payrollVerticalSalaryScale;

                foreach ($payrollVerticalSalaryScale->payrollScales as $payrollVerticalScale) {
                    array_push($records, $payrollVerticalScale->code);
                    foreach ($payrollHorizontalSalaryScale->payrollScales as $payrollHorizontalScale) {
                        array_push(
                            $records,
                            $fields[$payrollHorizontalScale->code . '-' . $payrollVerticalScale->code]
                        );
                    }
                }
                $records = array_chunk($records, count($payrollHorizontalSalaryScale->payrollScales) + 1);
            } elseif ($payrollSalaryTabulator->payroll_horizontal_salary_scale_id > 0) {
                $payrollHorizontalSalaryScale = $payrollSalaryTabulator->payrollHorizontalSalaryScale;
                array_push($records, 'Incidencia');
                foreach ($payrollHorizontalSalaryScale->payrollScales as $payrollHorizontalScale) {
                    array_push($records, $fields[$payrollHorizontalScale->code]);
                }
                $records = array_chunk($records, count($payrollHorizontalSalaryScale->payrollScales) + 1);
            } elseif ($payrollSalaryTabulator->payroll_vertical_salary_scale_id > 0) {
                $payrollVerticalSalaryScale = $payrollSalaryTabulator->payrollVerticalSalaryScale;
                foreach ($payrollVerticalSalaryScale->payrollScales as $payrollVerticalScale) {
                    array_push($records, $payrollVerticalScale->code);
                    array_push($records, $fields[$payrollVerticalScale->code]);
                }
                $records = array_chunk($records, 2);
            }
            return new Collection($records);
        }
    }

    /**
     * Establece la cabecera del archivo exportado
     *
     * @return array Arreglo que contiene la estructura de cabecera del archivo exportado
     */
    public function headings(): array
    {
        $payrollSalaryTabulator = PayrollSalaryTabulator::where('id', $this->payrollSalaryTabulatorId)->first();
        $fields = [];
        if ($payrollSalaryTabulator) {
            if ($payrollSalaryTabulator->payroll_horizontal_salary_scale_id > 0) {
                array_push($fields, 'Código');
                $payrollHorizontalSalaryScale = $payrollSalaryTabulator->payrollHorizontalSalaryScale;
                foreach ($payrollHorizontalSalaryScale->payrollScales as $payrollScale) {
                    array_push($fields, $payrollScale->code);
                }
            } elseif ($payrollSalaryTabulator->payroll_vertical_salary_scale_id > 0) {
                array_push($fields, 'Código');
                array_push($fields, 'Incidencia');
            }
            return $fields;
        } else {
            return [];
        }
    }

    public function registerEvents(): array
    {
        $payrollSalaryTabulator = PayrollSalaryTabulator::where('id', $this->payrollSalaryTabulatorId)
            ->with(['institution' => function ($query) {
                $query->with('banner')->get();
            }])->first();
        $payrollSalaryTabulator_banner = $payrollSalaryTabulator->institution->banner->file ?? '';
        return [
            AfterSheet::class => function (AfterSheet $event) use ($payrollSalaryTabulator_banner) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('institution_banner');
                $drawing->setDescription('Banner Institucional');
                $drawing->setPath(storage_path() . '/pictures/' . $payrollSalaryTabulator_banner);
                $drawing->setCoordinates('B1');
                $drawing->setWorksheet($event->sheet->getDelegate());
            },
        ];
    }
}
