<?php

namespace Modules\Payroll\Jobs;

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
     * Arreglo con los registros asociados a la configuración de vacaciones
     * @var Array $associatedVacation
     */
    protected $associatedVacation;

    /**
     * Arreglo con los registros asociados al expediente del trabajador
     * @var Array $associatedRecords
     */
    protected $associatedRecords;

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

        /** Define los campos de la configuración de vacaciones a emplear en el formulario */
        $this->associatedVacation = [
            [
                'id'       => 'VACATION_DAYS',
                'name'     => 'Días a otorgar para el disfrute de vacaciones',
                'model'    => 'Modules\Payroll\Models\PayrollVacationPolicy',
                'required' => ['vacation_days'],
            ],
            [
                'id'       => 'ADDITIONAL_DAYS_PER_YEAR',
                'name'     => 'Días de disfrute adicionales por año de servicio',
                'model'    => 'Modules\Payroll\Models\PayrollVacationPolicy',
                'required' => ['additional_days_per_year'],
            ],
            [
                'id'       => 'DAYS_REQUESTED',
                'name'     => 'Días a otogar para el pago de vacaciones',
                'model'    => 'Modules\Payroll\Models\PayrollVacationRequests',
                'required' => ['days_requested'],
            ]
        ];

        /** Define los campos del expediente del trabajador a emplear en el formulario */
        $this->associatedRecords = [
            [
                'id'       => 'STAFF',
                'name'     => 'Datos Personales',
                'model'    => 'Modules\Payroll\Models\PayrollStaff',
                'required' => [],
                'children' =>  [
                    [
                        'id'        => 'NATIONALITY',
                        'name'      => 'Nacionalidad',
                        'type'      => 'list',
                        'model'     => 'Modules\Payroll\Models\PayrollNationality',
                        'required'  => ['payroll_nationality_id']
                    ],
                    [
                        'id'        => 'GENDER',
                        'name'      => 'Género',
                        'type'      => 'list',
                        'model'     => 'Modules\Payroll\Models\PayrollGender',
                        'required'  => ['payroll_gender_id']

                    ],
                    [
                        'id'        => 'DISABLE',
                        'name'      => 'Estatus Discapacitado',
                        'type'      => 'boolean',
                        'model'     => '',
                        'required'  => ['has_disability']
                    ],
                    [
                        'id'        => 'BLOOD_TYPE',
                        'name'      => 'Tipo de sangre',
                        'type'      => 'list',
                        'model'     => 'Modules\Payroll\Models\PayrollBloodType',
                        'required'  => ['payroll_blood_type_id']
                    ],
                    [
                        'id'        => 'LICENSE_DEGREE',
                        'name'      => 'Grado de licencia de conducir',
                        'type'      => 'list',
                        'model'     => 'Modules\Payroll\Models\PayrollLicenseDegree',
                        'required'  => ['payroll_license_degree_id']
                    ]
                ]
            ],
            [
                'id'       => 'PROFESIONAL',
                'name'     => 'Datos Profesionales',
                'model'    => 'Modules\Payroll\Models\PayrollProfesional',
                'required' => ['payrollProfesional'],
                'children' =>
                [
                    [
                        'id'        => 'INSTRUCTION_DEGREE',
                        'name'      => 'Grado de instrucción',
                        'type'      => 'list',
                        'model'     => 'Modules\Payroll\Models\PayrollInstructionDegree',
                        'required'  => ['payroll_instruction_degree_id']
                    ],
                    [
                        'id'        => 'PROFESSION',
                        'name'      => 'Profesión',
                        'type'      => 'list',
                        'model'     => 'Modules\Payroll\Models\Profession',
                        'required'  => ['Profession_id']
                    ],
                    [
                        'id'        => 'STUDENT',
                        'name'      => 'Estatus Estudiante',
                        'type'      => 'boolean',
                        'model'     => '',
                        'required'  => ['is_student']
                    ],
                    [
                        'id'        => 'NUMBER_LANG',
                        'name'      => 'Número de idiomas',
                        'type'      => 'number',
                        'model'     => '',
                        'required'  => ['payrollLanguages']
                    ]
                ]
            ],
            [
                'id'       => 'SOCIOECONOMIC_INFORMATION',
                'name'     => 'Datos Socioeconómicos',
                'model'    => 'Modules\Payroll\Models\PayrollSocioeconomic',
                'required' => ['payrollSocioecomicInformation'],
                'children' =>
                [
                    [
                        'id'       => 'MARITAL_STATUS',
                        'name'     => 'Estado Civil',
                        'type'     => 'list',
                        'model'    => 'Modules\Payroll\Models\MaritalStatus',
                        'required' => ['marital_status_id']
                    ],
                    [
                        'id'       => 'NUMBER_CHILDREN',
                        'name'     => 'Número de hijos',
                        'type'     => 'number',
                        'model'    => '',
                        'required' => ['payrollChildrens']
                    ]
                ]
            ],
            [
                'id'       => 'EMPLOYMENT_INFORMATION',
                'name'     => 'Datos Laborales',
                'required' => ['payrollEmploymentInformation'],
                'children' =>
                [
                    [
                        'id'       => 'START_APN',
                        'name'     => 'Años en la administración pública',
                        'type'     => 'date',
                        'model'    => '',
                        'required' => ['start_date_apn']
                    ],
                    [
                        'id'       => 'START_DATE',
                        'name'     => 'Años en la institución',
                        'type'     => 'date',
                        'model'    => '',
                        'required' => ['start_date']
                    ],
                    [
                        'id'       => 'POSITION_TYPE',
                        'name'     => 'Tipo de cargo',
                        'type'     => 'list',
                        'model'    => 'Modules\Payroll\Models\PayrollPositionType',
                        'required' => ['payroll_position_type_id']
                    ],
                    [
                        'id'       => 'POSITION',
                        'name'     => 'Cargo',
                        'type'     => 'list',
                        'model'    => 'Modules\Payroll\Models\PayrollPosition',
                        'required' => ['payroll_position_id']
                    ],
                    [
                        'id'       => 'DEPARTMENT',
                        'name'     => 'Departamento',
                        'type'     => 'list',
                        'model'    => 'Modules\Payroll\Models\Department',
                        'required' => ['department_id']
                    ],
                    [
                        'id'       => 'STAFF_TYPE',
                        'name'     => 'Tipo de personal',
                        'type'     => 'list',
                        'model'    => 'Modules\Payroll\Models\PayrollStaffType',
                        'required' => ['payroll_staff_type_id']
                    ],
                    [
                        'id'       => 'CONTRACT_TYPE',
                        'name'     => 'Tipo de contrato',
                        'type'     => 'list',
                        'model'    => 'Modules\Payroll\Models\PayrollContractType',
                        'required' => ['payroll_contract_type_id']
                    ]
                ]
            ]
        ];
    }

    /**
     * Ejecuta el trabajo de registrar la nómina de sueldos
     *
     * @return void
     */
    public function handle()
    {
        $created_at = now();

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
            } elseif ($payrollConcept->calculation_way == 'tabulator') {

            }
            array_push($concepts, ['field' => $payrollConcept, 'formula' => $formula]);
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
        $payrollStaffs = PayrollStaff::whereHas('payrollEmploymentInformation', function ($q) use ($institution) {
            $q->whereHas('department', function ($qq) use ($institution) {
                $qq->where('institution_id', $institution->id);
            });
        })->get();

        foreach ($payrollStaffs as $payrollStaff) {
            /** Se definen los areglos de asignaciones y deducciones para clasificar los conceptos */
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
                            foreach ($this->associatedVacation as $parameter) {
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
                                foreach ($this->associatedRecords as $parameter) {
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
                                                        $record[from_camel_case($children['required'][0]) . '_count'],
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
                } elseif ($payrollConcept->calculation_way == 'tabulator') {

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
