<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;

class PayrollRoleAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $adminRole = Role::where('slug', 'admin')->first();

        $payrollRole = Role::updateOrCreate(
            ['slug' => 'payroll'],
            ['name' => 'Nómina', 'description' => 'Coordinador de nómina']
        );

        $permissions = [
            [
                'name' => 'Configuración del módulo de nómina', 'slug' => 'payroll.setting.index',
                'description' => 'Acceso a la configuración del módulo de nómina',
                'model' => '', 'model_prefix' => 'nomina',
                'slug_alt' => 'configuracion.ver'
            ],
            /**
             * Staff types
             */
            [
                'name' => 'Ver tipos de personal', 'slug' => 'payroll.staff.types.list',
                'description' => 'Acceso para ver tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.personal.ver'
            ],
            [
                'name' => 'Crear tipos de personal', 'slug' => 'payroll.staff.types.create',
                'description' => 'Acceso para crear tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.personal.crear'
            ],
            [
                'name' => 'Editar tipos de personal', 'slug' => 'payroll.staff.types.edit',
                'description' => 'Acceso para editar los tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.personal.editar'
            ],
            [
                'name' => 'Eliminar tipos de personal', 'slug' => 'payroll.staff.types.delete',
                'description' => 'Acceso para eliminar tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.personal.eliminar'
            ],
            /**
             * Position types
             */
            [
                'name' => 'Ver tipos de cargo', 'slug' => 'payroll.position.types.list',
                'description' => 'Acceso para ver tipos de cargo',
                'model' => 'Modules\Payroll\Models\PayrollPositionType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.cargo.ver'
            ],
            [
                'name' => 'Crear tipos de cargo', 'slug' => 'payroll.position.types.create',
                'description' => 'Acceso para crear tipos de cargo',
                'model' => 'Modules\Payroll\Models\PayrollPositionType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.cargo.crear'
            ],
            [
                'name' => 'Editar tipos de cargo', 'slug' => 'payroll.position.types.edit',
                'description' => 'Acceso para editar los tipos de cargo',
                'model' => 'Modules\Payroll\Models\PayrollPositionType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.cargo.editar'
            ],
            [
                'name' => 'Eliminar tipos de cargo', 'slug' => 'payroll.position.types.delete',
                'description' => 'Acceso para eliminar tipos de cargo',
                'model' => 'Modules\Payroll\Models\PayrollPositionType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.cargo.eliminar'
            ],
            /**
             * Positions
             */
            [
                'name' => 'Ver cargos', 'slug' => 'payroll.positions.list',
                'description' => 'Acceso para ver los cargos',
                'model' => 'Modules\Payroll\Models\PayrollPosition', 'model_prefix' => 'nomina',
                'slug_alt' => 'cargo.ver'
            ],
            [
                'name' => 'Crear cargos', 'slug' => 'payroll.positions.create',
                'description' => 'Acceso para crear cargos',
                'model' => 'Modules\Payroll\Models\PayrollPosition', 'model_prefix' => 'nomina',
                'slug_alt' => 'cargo.crear'
            ],
            [
                'name' => 'Editar cargos', 'slug' => 'payroll.positions.edit',
                'description' => 'Acceso para editar los cargos',
                'model' => 'Modules\Payroll\Models\PayrollPosition', 'model_prefix' => 'nomina',
                'slug_alt' => 'cargo.editar'
            ],
            [
                'name' => 'Eliminar cargos', 'slug' => 'payroll.positions.delete',
                'description' => 'Acceso para eliminar cargos',
                'model' => 'Modules\Payroll\Models\PayrollPosition', 'model_prefix' => 'nomina',
                'slug_alt' => 'cargo.eliminar'
            ],
            /**
             * Staff classifications
             */
            [
                'name' => 'Ver la clasificación del personal', 'slug' => 'payroll.staff.classifications.list',
                'description' => 'Acceso para ver la clasificación del personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffClassification', 'model_prefix' => 'nomina',
                'slug_alt' => 'clasificacion.personal.ver'
            ],
            [
                'name' => 'Crear la clasificación del personal', 'slug' => 'payroll.staff.classifications.create',
                'description' => 'Acceso para crear la clasificación del personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffClassification', 'model_prefix' => 'nomina',
                'slug_alt' => 'clasificacion.personal.crear'
            ],
            [
                'name' => 'Editar la clasificación del personal', 'slug' => 'payroll.staff.classifications.edit',
                'description' => 'Acceso para editar la clasificación del personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffClassification', 'model_prefix' => 'nomina',
                'slug_alt' => 'clasificacion.personal.editar'
            ],
            [
                'name' => 'Eliminar la clasificación del personal', 'slug' => 'payroll.staff.classifications.delete',
                'description' => 'Acceso para eliminar la clasificación del personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffClassification', 'model_prefix' => 'nomina',
                'slug_alt' => 'clasificacion.personal.eliminar'
            ],
            /**
             * Staffs
             */
            [
                'name' => 'Ver el personal', 'slug' => 'payroll.staffs.list',
                'description' => 'Acceso para ver el personal',
                'model' => 'Modules\Payroll\Models\PayrollStaff', 'model_prefix' => 'nomina',
                'slug_alt' => 'personal.ver'
            ],
            [
                'name' => 'Crear el personal', 'slug' => 'payroll.staffs.create',
                'description' => 'Acceso para crear el personal',
                'model' => 'Modules\Payroll\Models\PayrollStaff', 'model_prefix' => 'nomina',
                'slug_alt' => 'personal.crear'
            ],
            [
                'name' => 'Editar el personal', 'slug' => 'payroll.staffs.edit',
                'description' => 'Acceso para editar el personal',
                'model' => 'Modules\Payroll\Models\PayrollStaff', 'model_prefix' => 'nomina',
                'slug_alt' => 'personal.editar'
            ],
            [
                'name' => 'Eliminar el personal', 'slug' => 'payroll.staffs.delete',
                'description' => 'Acceso para eliminar el personal',
                'model' => 'Modules\Payroll\Models\PayrollStaff', 'model_prefix' => 'nomina',
                'slug_alt' => 'personal.eliminar'
            ],
            /**
             * Instruction degrees
             */
            [
                'name' => 'Ver el grado de instrucción', 'slug' => 'payroll.instruction.degrees.list',
                'description' => 'Acceso para ver el grado de instrucción',
                'model' => 'Modules\Payroll\Models\PayrollInstructionDegree', 'model_prefix' => 'nomina',
                'slug_alt' => 'grado.instruccion.ver'
            ],
            [
                'name' => 'Crear el grado de instrucción', 'slug' => 'payroll.instruction.degrees.create',
                'description' => 'Acceso para crear el grado de instrucción',
                'model' => 'Modules\Payroll\Models\PayrollInstructionDegree', 'model_prefix' => 'nomina',
                'slug_alt' => 'grado.instruccion.crear'
            ],
            [
                'name' => 'Editar el grado de instrucción', 'slug' => 'payroll.instruction.degrees.edit',
                'description' => 'Acceso para editar el grado de instrucción',
                'model' => 'Modules\Payroll\Models\PayrollInstructionDegree', 'model_prefix' => 'nomina',
                'slug_alt' => 'grado.instruccion.editar'
            ],
            [
                'name' => 'Eliminar el grado de instrucción', 'slug' => 'payroll.instruction.degrees.delete',
                'description' => 'Acceso para eliminar el grado de instrucción',
                'model' => 'Modules\Payroll\Models\PayrollInstructionDegree', 'model_prefix' => 'nomina',
                'slug_alt' => 'grado.instruccion.eliminar'
            ],
            /**
             * Study types
             */
            [
                'name' => 'Ver el tipo de estudio', 'slug' => 'payroll.study.types.list',
                'description' => 'Acceso para ver el tipo de estudio',
                'model' => 'Modules\Payroll\Models\PayrollStudyType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.estudio.ver'
            ],
            [
                'name' => 'Crear el tipo de estudio', 'slug' => 'payroll.study.types.create',
                'description' => 'Acceso para crear el tipo de estudio',
                'model' => 'Modules\Payroll\Models\PayrollStudyType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.estudio.crear'
            ],
            [
                'name' => 'Editar el tipo de estudio', 'slug' => 'payroll.study.types.edit',
                'description' => 'Acceso para editar el tipo de estudio',
                'model' => 'Modules\Payroll\Models\PayrollStudyType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.estudio.editar'
            ],
            [
                'name' => 'Eliminar el tipo de estudio', 'slug' => 'payroll.study.types.delete',
                'description' => 'Acceso para eliminar el tipo de estudio',
                'model' => 'Modules\Payroll\Models\PayrollStudyType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.estudio.eliminar'
            ],
            /**
             * Nationalities
             */
            [
                'name' => 'Ver la nacionalidad', 'slug' => 'payroll.nationalities.list',
                'description' => 'Acceso para ver la nacionalidad',
                'model' => 'Modules\Payroll\Models\PayrollNationality', 'model_prefix' => 'nomina',
                'slug_alt' => 'nacionalidad.ver'
            ],
            [
                'name' => 'Crear la nacionalidad', 'slug' => 'payroll.nationalities.create',
                'description' => 'Acceso para crear la nacionalidad',
                'model' => 'Modules\Payroll\Models\PayrollNationality', 'model_prefix' => 'nomina',
                'slug_alt' => 'nacionalidad.crear'
            ],
            [
                'name' => 'Editar la nacionalidad', 'slug' => 'payroll.nationalities.edit',
                'description' => 'Acceso para editar la nacionalidad',
                'model' => 'Modules\Payroll\Models\PayrollNationality', 'model_prefix' => 'nomina',
                'slug_alt' => 'nacionalidad.editar'
            ],
            [
                'name' => 'Eliminar la nacionalidad', 'slug' => 'payroll.nationalities.delete',
                'description' => 'Acceso para eliminar la nacionalidad',
                'model' => 'Modules\Payroll\Models\PayrollNationality', 'model_prefix' => 'nomina',
                'slug_alt' => 'nacionalidad.eliminar'
            ],
            /**
             * Concept types
             */
            [
                'name' => 'Ver los tipos de concepto', 'slug' => 'payroll.concept.types.list',
                'description' => 'Acceso para ver los tipos de concepto',
                'model' => 'Modules\Payroll\Models\PayrollConceptType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.concepto.ver'
            ],
            [
                'name' => 'Crear el tipo de concepto', 'slug' => 'payroll.concept.types.create',
                'description' => 'Acceso para crear el tipo de concepto',
                'model' => 'Modules\Payroll\Models\PayrollConceptType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.concepto.crear'
            ],
            [
                'name' => 'Editar el tipo de concepto', 'slug' => 'payroll.concept.types.edit',
                'description' => 'Acceso para editar el tipo de concepto',
                'model' => 'Modules\Payroll\Models\PayrollConceptType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.concepto.editar'
            ],
            [
                'name' => 'Eliminar el tipo de concepto', 'slug' => 'payroll.concept.types.delete',
                'description' => 'Acceso para eliminar el tipo de concepto',
                'model' => 'Modules\Payroll\Models\PayrollConceptType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.concepto.eliminar'
            ],
            /**
             * language levels
             */
            [
                'name' => 'Ver los niveles de idioma', 'slug' => 'payroll.language.levels.list',
                'description' => 'Acceso para ver los niveles de idioma',
                'model' => 'Modules\Payroll\Models\PayrollLanguageLevel', 'model_prefix' => 'nomina',
                'slug_alt' => 'nivel.idioma.ver'
            ],
            [
                'name' => 'Crear el nivel de idioma', 'slug' => 'payroll.language.levels.create',
                'description' => 'Acceso para crear el nivel de idioma',
                'model' => 'Modules\Payroll\Models\PayrollLanguageLevel', 'model_prefix' => 'nomina',
                'slug_alt' => 'nivel.idioma.crear'
            ],
            [
                'name' => 'Editar el nivel de idioma', 'slug' => 'payroll.language.levels.edit',
                'description' => 'Acceso para editar el nivel de idioma',
                'model' => 'Modules\Payroll\Models\PayrollLanguageLevel', 'model_prefix' => 'nomina',
                'slug_alt' => 'nivel.idioma.editar'
            ],
            [
                'name' => 'Eliminar el nivel de idioma', 'slug' => 'payroll.language.levels.delete',
                'description' => 'Acceso para eliminar el nivel de idioma',
                'model' => 'Modules\Payroll\Models\PayrollLanguageLevel', 'model_prefix' => 'nomina',
                'slug_alt' => 'nivel.idioma.eliminar'
            ],
            /**
             * Languages
             */
            [
                'name' => 'Ver los idiomas', 'slug' => 'payroll.languages.list',
                'description' => 'Acceso para ver los idiomas',
                'model' => 'Modules\Payroll\Models\PayrollLanguage', 'model_prefix' => 'nomina',
                'slug_alt' => 'idioma.ver'
            ],
            [
                'name' => 'Crear el idioma', 'slug' => 'payroll.languages.create',
                'description' => 'Acceso para crear el idioma',
                'model' => 'Modules\Payroll\Models\PayrollLanguage', 'model_prefix' => 'nomina',
                'slug_alt' => 'idioma.crear'
            ],
            [
                'name' => 'Editar el idioma', 'slug' => 'payroll.languages.edit',
                'description' => 'Acceso para editar el idioma',
                'model' => 'Modules\Payroll\Models\PayrollLanguage', 'model_prefix' => 'nomina',
                'slug_alt' => 'idioma.editar'
            ],
            [
                'name' => 'Eliminar el idioma', 'slug' => 'payroll.languages.delete',
                'description' => 'Acceso para eliminar el idioma',
                'model' => 'Modules\Payroll\Models\PayrollLanguage', 'model_prefix' => 'nomina',
                'slug_alt' => 'idioma.eliminar'
            ],
            /**
             * Genders
             */
            [
                'name' => 'Ver los géneros', 'slug' => 'payroll.genders.list',
                'description' => 'Acceso para ver los géneros',
                'model' => 'Modules\Payroll\Models\PayrollGender', 'model_prefix' => 'nomina',
                'slug_alt' => 'genero.ver'
            ],
            [
                'name' => 'Crear el género', 'slug' => 'payroll.genders.create',
                'description' => 'Acceso para crear el género',
                'model' => 'Modules\Payroll\Models\PayrollGender', 'model_prefix' => 'nomina',
                'slug_alt' => 'genero.crear'
            ],
            [
                'name' => 'Editar el género', 'slug' => 'payroll.genders.edit',
                'description' => 'Acceso para editar el género',
                'model' => 'Modules\Payroll\Models\PayrollGender', 'model_prefix' => 'nomina',
                'slug_alt' => 'genero.editar'
            ],
            [
                'name' => 'Eliminar el género', 'slug' => 'payroll.genders.delete',
                'description' => 'Acceso para eliminar el género',
                'model' => 'Modules\Payroll\Models\PayrollGender', 'model_prefix' => 'nomina',
                'slug_alt' => 'genero.eliminar'
            ],
            /**
             * Professional informations
             */
            [
                'name' => 'Ver los datos de información profesional',
                'slug' => 'payroll.professional.informations.list',
                'description' => 'Acceso para ver los datos de información socioeconómica',
                'model' => 'Modules\Payroll\Models\PayrollProfessionalInformation', 'model_prefix' => 'nomina',
                'slug_alt' => 'informacion.profesional.ver'
            ],
            [
                'name' => 'Crear datos de información profesional',
                'slug' => 'payroll.professional.informations.create',
                'description' => 'Acceso para crear datos de información profesional',
                'model' => 'Modules\Payroll\Models\PayrollProfessionalInformation', 'model_prefix' => 'nomina',
                'slug_alt' => 'informacion.profesional.crear'
            ],
            [
                'name' => 'Editar datos de información profesional', 'slug' => 'payroll.professional.informations.edit',
                'description' => 'Acceso para editar datos de información profesional',
                'model' => 'Modules\Payroll\Models\PayrollProfessionalInformation', 'model_prefix' => 'nomina',
                'slug_alt' => 'informacion.profesional.editar'
            ],
            [
                'name' => 'Eliminar datos de información profesional',
                'slug' => 'payroll.professional.informations.delete',
                'description' => 'Acceso para eliminar datos de información profesional',
                'model' => 'Modules\Payroll\Models\PayrollProfessionalInformation', 'model_prefix' => 'nomina',
                'slug_alt' => 'informacion.profesional.eliminar'
            ],
            /**
             * Inactivity types
             */
            [
                'name' => 'Ver los datos de tipos de inactividad', 'slug' => 'payroll.inactivity.types.list',
                'description' => 'Acceso para ver los datos de tipos de inactividad',
                'model' => 'Modules\Payroll\Models\PayrollInactivityType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.inactividad.ver'
            ],
            [
                'name' => 'Crear datos de tipos de inactividad', 'slug' => 'payroll.inactivity.types.create',
                'description' => 'Acceso para crear datos de tipos de inactividad',
                'model' => 'Modules\Payroll\Models\PayrollInactivityType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.inactividad.crear'
            ],
            [
                'name' => 'Editar datos de tipos de inactividad', 'slug' => 'payroll.inactivity.types.edit',
                'description' => 'Acceso para editar datos de tipos de inactividad',
                'model' => 'Modules\Payroll\Models\PayrollInactivityType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.inactividad.editar'
            ],
            [
                'name' => 'Eliminar datos de tipos de inactividad', 'slug' => 'payroll.inactivity.types.delete',
                'description' => 'Acceso para eliminar datos de tipos de inactividad',
                'model' => 'Modules\Payroll\Models\PayrollInactivityType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.inactividad.eliminar'
            ],
            /**
             * Contract types
             */
            [
                'name' => 'Ver los datos de tipos de contrato', 'slug' => 'payroll.contract.types.list',
                'description' => 'Acceso para ver los datos de tipos de contrato',
                'model' => 'Modules\Payroll\Models\PayrollContractType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.contrato.ver'
            ],
            [
                'name' => 'Crear datos de tipos de contrato', 'slug' => 'payroll.contract.types.create',
                'description' => 'Acceso para crear datos de tipos de contrato',
                'model' => 'Modules\Payroll\Models\PayrollContractType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.contrato.crear'
            ],
            [
                'name' => 'Editar datos de tipos de contrato', 'slug' => 'payroll.contract.types.edit',
                'description' => 'Acceso para editar datos de tipos de contrato',
                'model' => 'Modules\Payroll\Models\PayrollContractType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.contrato.editar'
            ],
            [
                'name' => 'Eliminar datos de tipos de contrato', 'slug' => 'payroll.contract.types.delete',
                'description' => 'Acceso para eliminar datos de tipos de contrato',
                'model' => 'Modules\Payroll\Models\PayrollContractType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.contrato.eliminar'
            ],
            /**
             * Sector types
             */
            [
                'name' => 'Ver los datos de tipos de sector', 'slug' => 'payroll.sector.types.list',
                'description' => 'Acceso para ver los datos de tipos de sector',
                'model' => 'Modules\Payroll\Models\PayrollSectorType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.sector.ver'
            ],
            [
                'name' => 'Crear datos de tipos de sector', 'slug' => 'payroll.sector.types.create',
                'description' => 'Acceso para crear datos de tipos de sector',
                'model' => 'Modules\Payroll\Models\PayrollSectorType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.sector.crear'
            ],
            [
                'name' => 'Editar datos de tipos de sector', 'slug' => 'payroll.sector.types.edit',
                'description' => 'Acceso para editar datos de tipos de sector',
                'model' => 'Modules\Payroll\Models\PayrollSectorType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.sector.editar'
            ],
            [
                'name' => 'Eliminar datos de tipos de sector', 'slug' => 'payroll.sector.types.delete',
                'description' => 'Acceso para eliminar datos de tipos de sector',
                'model' => 'Modules\Payroll\Models\PayrollSectorType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.sector.eliminar'
            ],
            /**
             * driver licenses
             */
            [
                'name' => 'Ver los datos de grados de licencia de conducir',
                'slug' => 'payroll.license.degrees.list',
                'description' => 'Acceso para ver los datos de grados de licencia de conducir',
                'model' => 'Modules\Payroll\Models\PayrollLicenseDegree',
                'model_prefix' => 'nomina',
                'slug_alt' => 'grado.licencia.ver'
            ],
            [
                'name' => 'Crear datos de grados de licencia de conducir',
                'slug' => 'payroll.license.degrees.create',
                'description' => 'Acceso para crear datos de grados de licencia de conducir',
                'model' => 'Modules\Payroll\Models\PayrollLicenseDegree',
                'model_prefix' => 'nomina',
                'slug_alt' => 'grado.licencia.crear'
            ],
            [
                'name' => 'Editar datos de grados de licencia de conducir',
                'slug' => 'payroll.license.degrees.edit',
                'description' => 'Acceso para editar datos de grados de licencia de conducir',
                'model' => 'Modules\Payroll\Models\PayrollLicenseDegree',
                'model_prefix' => 'nomina',
                'slug_alt' => 'grado.licencia.editar'
            ],
            [
                'name' => 'Eliminar datos de grado de licencia de conducir',
                'slug' => 'payroll.license.degrees.delete',
                'description' => 'Acceso para eliminar datos de grados de licencia de conducir',
                'model' => 'Modules\Payroll\Models\PayrollLicenseDegree',
                'model_prefix' => 'nomina',
                'slug_alt' => 'grado.licencia.eliminar'
            ],
            /**
             * blood types
             */
            [
                'name' => 'Ver los datos de tipos de sangre',
                'slug' => 'payroll.blood.types.list',
                'description' => 'Acceso para ver los datos de tipos de sangre',
                'model' => 'Modules\Payroll\Models\PayrollBloodType',
                'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.sangre.ver'
            ],
            [
                'name' => 'Crear datos de tipos de sangre',
                'slug' => 'payroll.blood.types.create',
                'description' => 'Acceso para crear datos de tipos de sangre',
                'model' => 'Modules\Payroll\Models\PayrollBloodType',
                'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.sangre.crear'
            ],
            [
                'name' => 'Editar datos de tipos de sangre',
                'slug' => 'payroll.blood.types.edit',
                'description' => 'Acceso para editar datos de tipos de sangre',
                'model' => 'Modules\Payroll\Models\PayrollBloodType',
                'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.sangre.editar'
            ],
            [
                'name' => 'Eliminar datos de tipos de sangre',
                'slug' => 'payroll.blood.types.delete',
                'description' => 'Acceso para eliminar datos de tipos de sangre',
                'model' => 'Modules\Payroll\Models\PayrollBloodType',
                'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.sangre.eliminar'
            ],
            /**
             * socioeconomics
             */
            [
                'name' => 'Ver los datos socioeconómicos',
                'slug' => 'payroll.socioeconomics.list',
                'description' => 'Acceso para ver los datos socioeconómicos',
                'model' => 'Modules\Payroll\Models\PayrollSocioeconomic',
                'model_prefix' => 'nomina',
                'slug_alt' => 'socioeconomico.ver'
            ],
            [
                'name' => 'Crear datos socioeconómicos',
                'slug' => 'payroll.socioeconomics.create',
                'description' => 'Acceso para crear datos socioeconómicos',
                'model' => 'Modules\Payroll\Models\PayrollSocioeconomic',
                'model_prefix' => 'nomina',
                'slug_alt' => 'socioeconomico.crear'
            ],
            [
                'name' => 'Editar datos socioeconómicos',
                'slug' => 'payroll.socioeconomics.edit',
                'description' => 'Acceso para editar datos socioeconómicos',
                'model' => 'Modules\Payroll\Models\PayrollSocioeconomic',
                'model_prefix' => 'nomina',
                'slug_alt' => 'socioeconomico.editar'
            ],
            [
                'name' => 'Eliminar datos socioeconómicos',
                'slug' => 'payroll.socioeconomics.delete',
                'description' => 'Acceso para eliminar datos socioeconómicos',
                'model' => 'Modules\Payroll\Models\PayrollSocioeconomic',
                'model_prefix' => 'nomina',
                'slug_alt' => 'socioeconomico.eliminar'
            ],
            /**
             * Professionals
             */
            [
                'name' => 'Ver los datos de profesionales',
                'slug' => 'payroll.professionals.list',
                'description' => 'Acceso para ver los datos profesionales',
                'model' => 'Modules\Payroll\Models\PayrollProfessional',
                'model_prefix' => 'nomina',
                'slug_alt' => 'profesional.ver'
            ],
            [
                'name' => 'Crear datos profesionales',
                'slug' => 'payroll.professionals.create',
                'description' => 'Acceso para crear datos profesionales',
                'model' => 'Modules\Payroll\Models\PayrollProfessional',
                'model_prefix' => 'nomina',
                'slug_alt' => 'profesional.crear'
            ],
            [
                'name' => 'Editar datos profesionales',
                'slug' => 'payroll.professionals.edit',
                'description' => 'Acceso para editar datos profesionales',
                'model' => 'Modules\Payroll\Models\PayrollProfessional',
                'model_prefix' => 'nomina',
                'slug_alt' => 'profesional.editar'
            ],
            [
                'name' => 'Eliminar datos profesionales',
                'slug' => 'payroll.professionals.delete',
                'description' => 'Acceso para eliminar datos profesionales',
                'model' => 'Modules\Payroll\Models\PayrollProfessional',
                'model_prefix' => 'nomina',
                'slug_alt' => 'profesional.eliminar'
            ],
            /**
             * Employments
             */
            [
                'name' => 'Ver los datos laborales',
                'slug' => 'payroll.employments.list',
                'description' => 'Acceso para ver los datos laborales',
                'model' => 'Modules\Payroll\Models\PayrollEmployment',
                'model_prefix' => 'nomina',
                'slug_alt' => 'laboral.ver'
            ],
            [
                'name' => 'Crear datos laborales',
                'slug' => 'payroll.employments.create',
                'description' => 'Acceso para crear datos laborales',
                'model' => 'Modules\Payroll\Models\PayrollEmployment',
                'model_prefix' => 'nomina',
                'slug_alt' => 'laboral.crear'
            ],
            [
                'name' => 'Editar datos laborales',
                'slug' => 'payroll.employments.edit',
                'description' => 'Acceso para editar datos laborales',
                'model' => 'Modules\Payroll\Models\PayrollEmployment',
                'model_prefix' => 'nomina',
                'slug_alt' => 'laboral.editar'
            ],
            [
                'name' => 'Eliminar datos laborales',
                'slug' => 'payroll.employments.delete',
                'description' => 'Acceso para eliminar datos laborales',
                'model' => 'Modules\Payroll\Models\PayrollEmployment',
                'model_prefix' => 'nomina',
                'slug_alt' => 'laboral.eliminar'
            ],
        ];

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt']
                ]
            );

            $payrollRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }
    }
}
