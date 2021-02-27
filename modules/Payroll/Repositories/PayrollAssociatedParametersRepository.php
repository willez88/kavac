<?php

namespace Modules\Payroll\Repositories;

/**
 * @class      PayrollAssociatedParametersRepository
 * @brief      Gestiona los parámetros asociados a la generación de nómina
 *
 * Clase que gestiona los parámetros asociados a la generación de nómina
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollAssociatedParametersRepository
{
    /**
     * Arreglo con los registros asociados a la configuración de vacaciones
     * @var Array $associatedVacation
     */
    protected $associatedVacation;

    /**
     * Arreglo con los registros asociados al expediente del trabajador
     * @var Array $associatedWorkerFile
     */
    protected $associatedWorkerFile;

    public function __construct()
    {
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
        $this->associatedWorkerFile = [
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
                'required' => ['payrollEmployment'],
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
     * Listado de parámetros
     *
     * @method    loadData
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    Array      Devuelve un arreglo con todas las opciones correspondientes
     */
    public function loadData($type)
    {
        return $this->$type;
    }
}
