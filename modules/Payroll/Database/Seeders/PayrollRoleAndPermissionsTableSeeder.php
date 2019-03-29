<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

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
            // Staff Types
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
            // Position Types
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
            // Positions
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
            // Staff Classifications
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
            // Staffs
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
            // instruction degrees
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
            // study types
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
            // nationalities
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
            // concept types
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
            // language levels
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
            // languages
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
