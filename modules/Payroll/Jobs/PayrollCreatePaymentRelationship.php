<?php

namespace Modules\Payroll\Jobs;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Payroll\Models\Payroll;
use Modules\Payroll\Models\Parameter;
use Modules\Payroll\Models\Institution;
use Modules\Payroll\Models\PayrollStaff;
use Modules\Payroll\Models\PayrollConcept;
use Modules\Payroll\Models\PayrollStaffPayroll;
use Modules\Payroll\Models\PayrollSalaryTabulatorScale;

use Modules\Payroll\Repositories\PayrollAssociatedParametersRepository;

class PayrollCreatePaymentRelationship implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Objeto que contiene la información asociada a la solicitud
     *
     * @var    Object    $data
     */
    protected $data;

    /**
     * Variable que contiene el tiempo de espera para la ejecución del trabajo,
     * si no se quiere limite de tiempo, se define en 0
     *
     * @var Integer $timeout
     */
    public $timeout = 0;

    /**
     * Crea una nueva instancia del trabajo
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Ejecuta el trabajo de registrar la nómina de sueldos
     *
     * @return void
     */
    public function handle()
    {
        $created_at = now();
        $payrollParameters = new PayrollAssociatedParametersRepository;

        /**
         * Objeto asociado al modelo Payroll
         * @var    Object    $payroll
         */
        $payroll = Payroll::updateOrCreate(
            [
                'id'                        => $this->data['id']
            ],
            [
                'name'                      => $this->data['name'],
                'payroll_payment_period_id' => $this->data['payroll_payment_period_id'],
                'payroll_parameters'        => json_encode($this->data['payroll_parameters']),
                'created_at'                => $this->data['created_at'] ?? $created_at
            ]
        );

        /** Se recorren los conceptos establecidos para la generación de la nómina */
        $concepts = [];
        foreach ($this->data['payroll_concepts'] as $concept) {
            $formula = null;
            $payrollConcept = PayrollConcept::find($concept['id']);
            /** Si el concepto está calculado mediante fórmula se identifican y sustituyen los parámetros,
             * en caso contrario se optiene su valor de acuerdo al tabulador */
            if ($payrollConcept->calculation_way == 'formula') {
                $exploded = multiexplode(
                    [
                        'if', '(', ')', '{', '}', ' ',
                        '==', '<=', '>=', '<', '>', '!=',
                        '+', '-','*','/'
                    ],
                    $payrollConcept->formula
                );
                while (count($exploded) > 0) {
                    $complete = false;
                    $current = max_length($exploded);
                    $key = array_search($current, $exploded);
                    /** Se descartan los elementos vacios y las constantes númericas */
                    if ($current == '' || is_numeric($current)) {
                        unset($exploded[$key]);
                        $complete = true;
                    } else {
                        /** Se recorre el listado de parámetros para sustituirlos por su valor real
                          * en la formula del concepto */
                        foreach ($this->data['payroll_parameters'] as $parameter) {
                            if ($parameter['code'] == $current) {
                                unset($exploded[$key]);
                                $complete = true;
                                $formula = str_replace($parameter['code'], $parameter['value'], $formula ?? $payrollConcept->formula);
                            }
                        }
                        if ($complete == false) {
                            /** Se descartan los parametro de vacaciones y los del expediente del trabajador
                             * para ser analizados mas adelante */
                            unset($exploded[$key]);
                            $complete = true;
                        }
                    }
                }
                array_push($concepts, ['field' => $payrollConcept, 'formula' => $formula]);
            } elseif ($payrollConcept->calculation_way == 'tabulator') {
                array_push($concepts, ['field' => $payrollConcept, 'formula' => null]);
            }
        }
        /** Se evaluan los parámetros del expediente del trabajador y de la configuración de vacaciones */
        /** Se identifica la institución en la que se está operando */
        $institution = Institution::where('active', true)->where('default', true)->first();
        /* Revisar (No funciona en segundo plano --- Alternativa solicitar institucion desde formulario)
        $profileUser = Auth()->user()->profile;
        if ($profileUser) {
            $institution = Institution::find($profileUser->institution_id);
        } else {
            $institution = Institution::where('active', true)->where('default', true)->first();
        }
        */
        /** Se obtienen todos los trabajadores asociados a la institución y se evalua si aplica cada uno de los conceptos */
        $payrollStaffs = PayrollStaff::whereHas('payrollEmployment', function ($q) use ($institution) {
            $q->whereHas('department', function ($qq) use ($institution) {
                $qq->where('institution_id', $institution->id);
            });
        })->get();

        foreach ($payrollStaffs as $payrollStaff) {
            /** Se definen los arreglos de asignaciones y deducciones para clasificar los conceptos */
            $assignments = [];
            $deductions  = [];
            foreach ($concepts as $concept) {
                $formula = null;
                if ($concept['field']->calculation_way == 'formula') {
                    $exploded = multiexplode(
                        [
                            'if', '(', ')', '{', '}', ' ',
                            '==', '<=', '>=', '<', '>', '!=',
                            '+', '-','*','/'
                        ],
                        $concept['formula']
                    );
                    while (count($exploded) > 0) {
                        $complete = false;
                        $current = max_length($exploded);
                        $key = array_search($current, $exploded);
                        /** Se descartan los elementos vacios y las constantes númericas */
                        if ($current == '' || is_numeric($current)) {
                            unset($exploded[$key]);
                            $complete = true;
                        } else {
                            /** Se recorre el listado de parámetros asociados a la configuración de vacaciones
                              * para sustituirlos por su valor real en la formula del concepto */
                            foreach ($payrollParameters->loadData('associatedVacation') as $parameter) {
                                if ($parameter['id'] == $current) {
                                    $records = (is_object($parameter['model']))
                                        ? $parameter['model']
                                        : $parameter['model']::where('institution_id', $institution->id)->first();
                                    unset($exploded[$key]);
                                    $complete = true;
                                    $formula = str_replace(
                                        $parameter['id'],
                                        $records[$parameter['required'][0]],
                                        $formula ?? $concept['formula']);
                                }
                            }
                            /** Se recorre el listado de parámetros asociados al expediente del trabajador
                              * para sustituirlos por su valor real en la formula del concepto */
                            if ($complete == false) {
                                foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameter) {
                                    if (!empty($parameter['children'])) {
                                        foreach ($parameter['children'] as $children) {
                                            if ($children['id'] == $current) {
                                                $record = ($parameter['model'] != PayrollStaff::class)
                                                    ? $parameter['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                                    : $payrollStaff;
                                                unset($exploded[$key]);
                                                $complete = true;
                                                if ($children['type'] == 'number') {
                                                    /** Se calcula el número de registros existentes según sea el caso
                                                     * y se sustituye por su valor real en la fórmula del concepto */
                                                    $record->loadCount($children['required'][0]);
                                                    $formula = str_replace(
                                                        $children['id'],
                                                        $record[Str::camel($children['required'][0]) . '_count'],
                                                        $formula ?? $concept['formula']);
                                                } elseif ($children['type'] == 'date') {
                                                    /** Se calcula el número de años según la fecha de ingreso
                                                     * y se sustituye por su valor real en la fórmula del concepto */
                                                    $formula = str_replace(
                                                        $children['id'],
                                                        $record[age($record[$children['required'][0]])],
                                                        $formula ?? $concept['formula']);
                                                } else {
                                                    /** Se identifica el valor según el expediente del trabajador
                                                     * y se sustituye por su valor real en la fórmula del concepto */
                                                    $formula = str_replace(
                                                        $children['id'],
                                                        $record[$children['required'][0]],
                                                        $formula ?? $concept['formula']);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } elseif ($payrollConcept->calculation_way == 'tabulator') {
                    /** Se carga la propiedad tabulador asociada al concepto */
                    $payrollConcept->load('payrollSalaryTabulator');
                    $payrollSalaryTabulator = $payrollConcept->payrollSalaryTabulator;
                    if ($payrollSalaryTabulator->payroll_salary_tabulator_type == 'horizontal') {
                        /** Se carga el escalafón horizontal asociado al tabulador */
                        $payrollSalaryTabulator->load(['payrollHorizontalSalaryScale' => function($q) {
                            $q->load('payrollScales');
                        }]);
                        foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameter) {
                            if (!empty($parameter['children'])) {
                                foreach ($parameter['children'] as $children) {
                                    if ($children['id'] == $payrollSalaryTabulator->payrollHorizontalSalaryScale['group_by']) {
                                        $record = ($parameter['model'] != PayrollStaff::class)
                                            ? $parameter['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                            : $payrollStaff;
                                        foreach ($payrollSalaryTabulator->payrollHorizontalSalaryScale->payrollScales as $scale) {
                                            if ($children['type'] == 'number') {
                                                /** Se calcula el número de registros existentes según sea el caso
                                                 * y se sustituye por su valor en el tabulador */
                                                $scl = json_decode($scale['value']);
                                                $record->loadCount($children['required'][0]);
                                                if (isset($scl['from']) && isset($scl['to'])) {
                                                    if (($record[Str::camel($children['required'][0]) . '_count'] >= $scl['from']) &&
                                                        ($record[Str::camel($children['required'][0]) . '_count'] < $scl['to'])) {
                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                            ->where('payroll_vertical_scale_id', null)->first();
                                                        $formula = json_decode($tabScale['value']);
                                                    }
                                                } else {
                                                    if ($scl == $record[Str::camel($children['required'][0]) . '_count']) {
                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                            ->where('payroll_vertical_scale_id', null)->first();
                                                        $formula = json_decode($tabScale['value']);
                                                    }
                                                }
                                                
                                            } elseif ($children['type'] == 'date') {
                                                /** Se calcula el número de años según la fecha de ingreso
                                                  * y se sustituye por su valor en el tabulador */
                                                $scl = json_decode($scale['value']);
                                                if (isset($scl['from']) && isset($scl['to'])) {
                                                    if (($record[age($record[$children['required'][0]])] >= $scl['from']) &&
                                                        ($record[age($record[$children['required'][0]])] < $scl['to'])) {
                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                            ->where('payroll_vertical_scale_id', null)->first();
                                                        $formula = json_decode($tabScale['value']);
                                                    }
                                                } else {
                                                    if ($scl == $record[age($record[$children['required'][0]])]) {
                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                            ->where('payroll_vertical_scale_id', null)->first();
                                                        $formula = json_decode($tabScale['value']);
                                                    }
                                                }
                                                
                                            } else {
                                                /** Se identifica el valor según el expediente del trabajador
                                                 * y se sustituye por su valor en el tabulador */
                                                if (json_decode($scale['value']) == $record[$children['required'][0]]) {
                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                        ->where('payroll_vertical_scale_id', null)->first();
                                                    $formula = json_decode($tabScale['value']);
                                                }
                                            }

                                        }
                                    }
                                }
                            }
                        }
                    } else if ($payrollSalaryTabulator->payroll_salary_tabulator_type == 'vertical') {
                        /** Se carga el escalafón vertical asociado al tabulador */
                        $payrollSalaryTabulator->load(['payrollVerticalSalaryScale' => function($q) {
                            $q->load('payrollScales');
                        }]);
                        foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameter) {
                            if (!empty($parameter['children'])) {
                                foreach ($parameter['children'] as $children) {
                                    if ($children['id'] == $payrollSalaryTabulator->payrollVerticalSalaryScale['group_by']) {
                                        $record = ($parameter['model'] != PayrollStaff::class)
                                            ? $parameter['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                            : $payrollStaff;
                                        foreach ($payrollSalaryTabulator->payrollVerticalSalaryScale->payrollScales as $scale) {
                                            if ($children['type'] == 'number') {
                                                /** Se calcula el número de registros existentes según sea el caso
                                                 * y se sustituye por su valor en el tabulador */
                                                $scl = json_decode($scale['value']);
                                                $record->loadCount($children['required'][0]);
                                                if (isset($scl['from']) && isset($scl['to'])) {
                                                    if (($record[Str::camel($children['required'][0]) . '_count'] >= $scl['from']) &&
                                                        ($record[Str::camel($children['required'][0]) . '_count'] < $scl['to'])) {
                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                            ->where('payroll_horizontal_scale_id', null)
                                                            ->where('payroll_vertical_scale_id', $scale['id'])->first();
                                                        $formula = json_decode($tabScale['value']);
                                                    }
                                                } else {
                                                    if ($scl == $record[Str::camel($children['required'][0]) . '_count']) {
                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                            ->where('payroll_horizontal_scale_id', null)
                                                            ->where('payroll_vertical_scale_id', $scale['id'])->first();
                                                        $formula = json_decode($tabScale['value']);
                                                    }
                                                }
                                                
                                            } elseif ($children['type'] == 'date') {
                                                /** Se calcula el número de años según la fecha de ingreso
                                                  * y se sustituye por su valor en el tabulador */
                                                $scl = json_decode($scale['value']);
                                                if (isset($scl['from']) && isset($scl['to'])) {
                                                    if (($record[age($record[$children['required'][0]])] >= $scl['from']) &&
                                                        ($record[age($record[$children['required'][0]])] < $scl['to'])) {
                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                            ->where('payroll_horizontal_scale_id', null)
                                                            ->where('payroll_vertical_scale_id', $scale['id'])->first();
                                                        $formula = json_decode($tabScale['value']);
                                                    }
                                                } else {
                                                    if ($scl == $record[age($record[$children['required'][0]])]) {
                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                            ->where('payroll_horizontal_scale_id', null)
                                                            ->where('payroll_vertical_scale_id', $scale['id'])->first();
                                                        $formula = json_decode($tabScale['value']);
                                                    }
                                                }
                                                
                                            } else {
                                                /** Se identifica el valor según el expediente del trabajador
                                                 * y se sustituye por su valor en el tabulador */
                                                if (json_decode($scale['value']) == $record[$children['required'][0]]) {
                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                        ->where('payroll_horizontal_scale_id', null)
                                                        ->where('payroll_vertical_scale_id', $scale['id'])->first();
                                                    $formula = json_decode($tabScale['value']);
                                                }
                                            }

                                        }
                                    }
                                }
                            }
                        }
                    } else {
                        /** Se carga el escalafón horizontal asociado al tabulador */
                        $payrollSalaryTabulator->load([
                            'payrollHorizontalSalaryScale' => function($q) {
                                $q->load('payrollScales');
                            }, 'payrollVerticalSalaryScale' => function($q) {
                                $q->load('payrollScales');
                            }
                        ]);
                        foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameter) {
                            if (!empty($parameter['children'])) {
                                foreach ($parameter['children'] as $children) {
                                    if ($children['id'] == $payrollSalaryTabulator->payrollHorizontalSalaryScale['group_by']) {
                                        $record = ($parameter['model'] != PayrollStaff::class)
                                            ? $parameter['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                            : $payrollStaff;
                                        foreach ($payrollSalaryTabulator->payrollHorizontalSalaryScale->payrollScales as $scale) {
                                            if ($children['type'] == 'number') {
                                                /** Se calcula el número de registros existentes según sea el caso
                                                 * y se sustituye por su valor en el tabulador */
                                                $scl = json_decode($scale['value']);
                                                $record->loadCount($children['required'][0]);
                                                if (isset($scl['from']) && isset($scl['to'])) {
                                                    if (($record[Str::camel($children['required'][0]) . '_count'] >= $scl['from']) &&
                                                        ($record[Str::camel($children['required'][0]) . '_count'] < $scl['to'])) {

                                                        foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameterV) {
                                                            if (!empty($parameterV['children'])) {
                                                                foreach ($parameterV['children'] as $childrenV) {
                                                                    if ($childrenV['id'] == $payrollSalaryTabulator->payrollVerticalSalaryScale['group_by']) {
                                                                        $recordV = ($parameterV['model'] != PayrollStaff::class)
                                                                            ? $parameterV['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                                                            : $payrollStaff;
                                                                        foreach ($payrollSalaryTabulator->payrollVerticalSalaryScale->payrollScales as $scaleV) {
                                                                            if ($childrenV['type'] == 'number') {
                                                                                /** Se calcula el número de registros existentes según sea el caso
                                                                                 * y se sustituye por su valor en el tabulador */
                                                                                $sclV = json_decode($scaleV['value']);
                                                                                $recordV->loadCount($childrenV['required'][0]);
                                                                                if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                    if (($recordV[Str::camel($childrenV['required'][0]) . '_count'] >= $sclV['from']) &&
                                                                                        ($recordV[Str::camel($childrenV['required'][0]) . '_count'] < $sclV['to'])) {

                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id'])->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                } else {
                                                                                    if ($sclV == $recordV[Str::camel($childrenV['required'][0]) . '_count']) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                }
                                                                            } elseif ($childrenV['type'] == 'date') {
                                                                                /** Se calcula el número de años según la fecha de ingreso
                                                                                  * y se sustituye por su valor en el tabulador */
                                                                                $sclV = json_decode($scaleV['value']);
                                                                                if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                    if (($recordV[age($recordV[$childrenV['required'][0]])] >= $sclV['from']) &&
                                                                                        ($recordV[age($recordV[$childrenV['required'][0]])] < $sclV['to'])) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                } else {
                                                                                    if ($sclV == $recordV[age($recordV[$childrenV['required'][0]])]) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                }
                                                                                
                                                                            } else {
                                                                                /** Se identifica el valor según el expediente del trabajador
                                                                                 * y se sustituye por su valor en el tabulador */
                                                                                if (json_decode($scaleV['value']) == $recordV[$childrenV['required'][0]]) {
                                                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                        ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                    $formula = json_decode($tabScale['value']);
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    if ($scl == $record[Str::camel($children['required'][0]) . '_count']) {

                                                        foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameterV) {
                                                            if (!empty($parameterV['children'])) {
                                                                foreach ($parameterV['children'] as $childrenV) {
                                                                    if ($childrenV['id'] == $payrollSalaryTabulator->payrollVerticalSalaryScale['group_by']) {
                                                                        $recordV = ($parameterV['model'] != PayrollStaff::class)
                                                                            ? $parameterV['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                                                            : $payrollStaff;
                                                                        foreach ($payrollSalaryTabulator->payrollVerticalSalaryScale->payrollScales as $scaleV) {
                                                                            if ($childrenV['type'] == 'number') {
                                                                                /** Se calcula el número de registros existentes según sea el caso
                                                                                 * y se sustituye por su valor en el tabulador */
                                                                                $sclV = json_decode($scaleV['value']);
                                                                                $recordV->loadCount($childrenV['required'][0]);
                                                                                if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                    if (($recordV[Str::camel($childrenV['required'][0]) . '_count'] >= $sclV['from']) &&
                                                                                        ($recordV[Str::camel($childrenV['required'][0]) . '_count'] < $sclV['to'])) {

                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id'])->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                } else {
                                                                                    if ($sclV == $recordV[Str::camel($childrenV['required'][0]) . '_count']) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                }
                                                                            } elseif ($childrenV['type'] == 'date') {
                                                                                /** Se calcula el número de años según la fecha de ingreso
                                                                                  * y se sustituye por su valor en el tabulador */
                                                                                $sclV = json_decode($scaleV['value']);
                                                                                if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                    if (($recordV[age($recordV[$childrenV['required'][0]])] >= $sclV['from']) &&
                                                                                        ($recordV[age($recordV[$childrenV['required'][0]])] < $sclV['to'])) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                } else {
                                                                                    if ($sclV == $recordV[age($recordV[$childrenV['required'][0]])]) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                }
                                                                                
                                                                            } else {
                                                                                /** Se identifica el valor según el expediente del trabajador
                                                                                 * y se sustituye por su valor en el tabulador */
                                                                                if (json_decode($scaleV['value']) == $recordV[$childrenV['required'][0]]) {
                                                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                        ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                    $formula = json_decode($tabScale['value']);
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                
                                            } elseif ($children['type'] == 'date') {
                                                /** Se calcula el número de años según la fecha de ingreso
                                                  * y se sustituye por su valor en el tabulador */
                                                $scl = json_decode($scale['value']);
                                                if (isset($scl['from']) && isset($scl['to'])) {
                                                    if (($record[age($record[$children['required'][0]])] >= $scl['from']) &&
                                                        ($record[age($record[$children['required'][0]])] < $scl['to'])) {
                                                        foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameterV) {
                                                            if (!empty($parameterV['children'])) {
                                                                foreach ($parameterV['children'] as $childrenV) {
                                                                    if ($childrenV['id'] == $payrollSalaryTabulator->payrollVerticalSalaryScale['group_by']) {
                                                                        $recordV = ($parameterV['model'] != PayrollStaff::class)
                                                                            ? $parameterV['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                                                            : $payrollStaff;
                                                                        foreach ($payrollSalaryTabulator->payrollVerticalSalaryScale->payrollScales as $scaleV) {
                                                                            if ($childrenV['type'] == 'number') {
                                                                                /** Se calcula el número de registros existentes según sea el caso
                                                                                 * y se sustituye por su valor en el tabulador */
                                                                                $sclV = json_decode($scaleV['value']);
                                                                                $recordV->loadCount($childrenV['required'][0]);
                                                                                if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                    if (($recordV[Str::camel($childrenV['required'][0]) . '_count'] >= $sclV['from']) &&
                                                                                        ($recordV[Str::camel($childrenV['required'][0]) . '_count'] < $sclV['to'])) {

                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id'])->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                } else {
                                                                                    if ($sclV == $recordV[Str::camel($childrenV['required'][0]) . '_count']) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                }
                                                                            } elseif ($childrenV['type'] == 'date') {
                                                                                /** Se calcula el número de años según la fecha de ingreso
                                                                                  * y se sustituye por su valor en el tabulador */
                                                                                $sclV = json_decode($scaleV['value']);
                                                                                if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                    if (($recordV[age($recordV[$childrenV['required'][0]])] >= $sclV['from']) &&
                                                                                        ($recordV[age($recordV[$childrenV['required'][0]])] < $sclV['to'])) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                } else {
                                                                                    if ($sclV == $recordV[age($recordV[$childrenV['required'][0]])]) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                }
                                                                                
                                                                            } else {
                                                                                /** Se identifica el valor según el expediente del trabajador
                                                                                 * y se sustituye por su valor en el tabulador */
                                                                                if (json_decode($scaleV['value']) == $recordV[$childrenV['required'][0]]) {
                                                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                        ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                    $formula = json_decode($tabScale['value']);
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                } else {
                                                    if ($scl == $record[age($record[$children['required'][0]])]) {
                                                        foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameterV) {
                                                            if (!empty($parameterV['children'])) {
                                                                foreach ($parameterV['children'] as $childrenV) {
                                                                    if ($childrenV['id'] == $payrollSalaryTabulator->payrollVerticalSalaryScale['group_by']) {
                                                                        $recordV = ($parameterV['model'] != PayrollStaff::class)
                                                                            ? $parameterV['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                                                            : $payrollStaff;
                                                                        foreach ($payrollSalaryTabulator->payrollVerticalSalaryScale->payrollScales as $scaleV) {
                                                                            if ($childrenV['type'] == 'number') {
                                                                                /** Se calcula el número de registros existentes según sea el caso
                                                                                 * y se sustituye por su valor en el tabulador */
                                                                                $sclV = json_decode($scaleV['value']);
                                                                                $recordV->loadCount($childrenV['required'][0]);
                                                                                if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                    if (($recordV[Str::camel($childrenV['required'][0]) . '_count'] >= $sclV['from']) &&
                                                                                        ($recordV[Str::camel($childrenV['required'][0]) . '_count'] < $sclV['to'])) {

                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id'])->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                } else {
                                                                                    if ($sclV == $recordV[Str::camel($childrenV['required'][0]) . '_count']) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                }
                                                                            } elseif ($childrenV['type'] == 'date') {
                                                                                /** Se calcula el número de años según la fecha de ingreso
                                                                                  * y se sustituye por su valor en el tabulador */
                                                                                $sclV = json_decode($scaleV['value']);
                                                                                if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                    if (($recordV[age($recordV[$childrenV['required'][0]])] >= $sclV['from']) &&
                                                                                        ($recordV[age($recordV[$childrenV['required'][0]])] < $sclV['to'])) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                } else {
                                                                                    if ($sclV == $recordV[age($recordV[$childrenV['required'][0]])]) {
                                                                                        $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                            ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                            ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                        $formula = json_decode($tabScale['value']);
                                                                                    }
                                                                                }
                                                                                
                                                                            } else {
                                                                                /** Se identifica el valor según el expediente del trabajador
                                                                                 * y se sustituye por su valor en el tabulador */
                                                                                if (json_decode($scaleV['value']) == $recordV[$childrenV['required'][0]]) {
                                                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                        ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                    $formula = json_decode($tabScale['value']);
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                
                                            } else {
                                                /** Se identifica el valor según el expediente del trabajador
                                                 * y se sustituye por su valor en el tabulador */
                                                if (json_decode($scale['value']) == $record[$children['required'][0]]) {
                                                    foreach ($payrollParameters->loadData('associatedWorkerFile') as $parameterV) {
                                                        if (!empty($parameterV['children'])) {
                                                            foreach ($parameterV['children'] as $childrenV) {
                                                                if ($childrenV['id'] == $payrollSalaryTabulator->payrollVerticalSalaryScale['group_by']) {
                                                                    $recordV = ($parameterV['model'] != PayrollStaff::class)
                                                                        ? $parameterV['model']::where('payroll_staff_id', $payrollStaff->id)->first()
                                                                        : $payrollStaff;
                                                                    foreach ($payrollSalaryTabulator->payrollVerticalSalaryScale->payrollScales as $scaleV) {
                                                                        if ($childrenV['type'] == 'number') {
                                                                            /** Se calcula el número de registros existentes según sea el caso
                                                                             * y se sustituye por su valor en el tabulador */
                                                                            $sclV = json_decode($scaleV['value']);
                                                                            $recordV->loadCount($childrenV['required'][0]);
                                                                            if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                if (($recordV[Str::camel($childrenV['required'][0]) . '_count'] >= $sclV['from']) &&
                                                                                    ($recordV[Str::camel($childrenV['required'][0]) . '_count'] < $sclV['to'])) {

                                                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                        ->where('payroll_vertical_scale_id', $scaleV['id'])->first();
                                                                                    $formula = json_decode($tabScale['value']);
                                                                                }
                                                                            } else {
                                                                                if ($sclV == $recordV[Str::camel($childrenV['required'][0]) . '_count']) {
                                                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                        ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                    $formula = json_decode($tabScale['value']);
                                                                                }
                                                                            }
                                                                        } elseif ($childrenV['type'] == 'date') {
                                                                            /** Se calcula el número de años según la fecha de ingreso
                                                                              * y se sustituye por su valor en el tabulador */
                                                                            $sclV = json_decode($scaleV['value']);
                                                                            if (isset($sclV['from']) && isset($sclV['to'])) {
                                                                                if (($recordV[age($recordV[$childrenV['required'][0]])] >= $sclV['from']) &&
                                                                                    ($recordV[age($recordV[$childrenV['required'][0]])] < $sclV['to'])) {
                                                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                        ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                    $formula = json_decode($tabScale['value']);
                                                                                }
                                                                            } else {
                                                                                if ($sclV == $recordV[age($recordV[$childrenV['required'][0]])]) {
                                                                                    $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                        ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                        ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                    $formula = json_decode($tabScale['value']);
                                                                                }
                                                                            }
                                                                            
                                                                        } else {
                                                                            /** Se identifica el valor según el expediente del trabajador
                                                                             * y se sustituye por su valor en el tabulador */
                                                                            if (json_decode($scaleV['value']) == $recordV[$childrenV['required'][0]]) {
                                                                                $tabScale = PayrollSalaryTabulatorScale::where('payroll_salary_tabulator_id', $payrollSalaryTabulator->id)
                                                                                    ->where('payroll_horizontal_scale_id', $scale['id'])
                                                                                    ->where('payroll_vertical_scale_id', $scaleV['id']))->first();
                                                                                $formula = json_decode($tabScale['value']);
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                /** Se carga la propiedad payrollConceptType
                 *  para determinar si clasificar el concepto como asignación o deducción */
                $concept['field']->load('payrollConceptType');
                if ($concept['field']->payrollConceptType['sign'] == '+') {
                    array_push(
                        $assignments,
                        [
                            'name'  => $concept['field']->name,
                            'value' => $formula ? str_eval($formula): str_eval($concept['formula'])
                        ]
                    );
                } elseif ($concept['field']->payrollConceptType['sign'] == '-') {
                    array_push(
                        $deductions,
                        [
                            'name'  => $concept['field']->name,
                            'value' => $formula ? str_eval($formula): str_eval($concept['formula'])
                        ]
                    );
                }
            }
            PayrollStaffPayroll::updateOrCreate(
                [
                    'payroll_id'       => $payroll->id,
                    'payroll_staff_id' => $payrollStaff->id
                ],
                [
                    'assignments' => json_encode($assignments),
                    'deductions'  => json_encode($deductions)
                ]
            );
        }
    }
}
