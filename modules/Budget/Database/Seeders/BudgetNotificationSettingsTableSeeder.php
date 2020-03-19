<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationSetting;
use Modules\Budget\Models\BudgetAccount;
use Modules\Budget\Models\BudgetCentralizedAction;
use Modules\Budget\Models\BudgetCompromise;
use Modules\Budget\Models\BudgetModification;
use Modules\Budget\Models\BudgetProject;
use Modules\Budget\Models\BudgetSpecificAction;
use Modules\Budget\Models\BudgetSubSpecificFormulation;

class BudgetNotificationSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $notifySettings = [
            [
                'module' => 'budget',
                'module_name' => 'Presupuesto',
                'model' => BudgetAccount::class,
                'name' => 'Cuenta Presupuestaria',
                'slug' => 'budget.account',
                'description' => 'Gestión de Catálogo de cuentas presupuestarias',
                'message' => 'Se ha generado un evento en el catálogo de cuentas presupuestarías'
            ],
            [
                'module' => 'budget',
                'module_name' => 'Presupuesto',
                'model' => BudgetCentralizedAction::class,
                'name' => 'Acciones Centralizadas',
                'slug' => 'budget.centralized.action',
                'description' => 'Gestión de Acciones Centralizadas',
                'message' => 'Se ha generado un evento en acciones centralizadas'
            ],
            [
                'module' => 'budget',
                'module_name' => 'Presupuesto',
                'model' => BudgetCompromise::class,
                'name' => 'Compromisos Presupuestarios',
                'slug' => 'budget.compromise',
                'description' => 'Gestión de compromisos presupuestarios',
                'message' => 'Se ha generado un evento en compromisos presupuestarios'
            ],
            [
                'module' => 'budget',
                'module_name' => 'Presupuesto',
                'model' => BudgetModification::class,
                'name' => 'Modificaciones Presupuestarias',
                'slug' => 'budget.modification',
                'description' => 'Gestión de modificaciones presupuestarias',
                'message' => 'Se ha generado un evento en modificaciones presupuestarias'
            ],
            [
                'module' => 'budget',
                'module_name' => 'Presupuesto',
                'model' => BudgetProject::class,
                'name' => 'Proyectos',
                'slug' => 'budget.projects',
                'description' => 'Gestión de proyectos',
                'message' => 'Se ha generado un evento en proyectos'
            ],
            [
                'module' => 'budget',
                'module_name' => 'Presupuesto',
                'model' => BudgetSpecificAction::class,
                'name' => 'Acciones Específicas',
                'slug' => 'budget.specific.actions',
                'description' => 'Gestión de acciones específicas',
                'message' => 'Se ha generado un evento en acciones específicas'
            ],
            [
                'module' => 'budget',
                'module_name' => 'Presupuesto',
                'model' => BudgetSubSpecificFormulation::class,
                'name' => 'Formulación de Presupuesto',
                'slug' => 'budget.subspecific.formulations',
                'description' => 'Gestión de formulaciones presupuestarias',
                'message' => 'Se ha generado un evento en formulación presupuestaria'
            ],
        ];

        DB::transaction(function () use ($notifySettings) {
            foreach ($notifySettings as $setting) {
                NotificationSetting::updateOrCreate(
                    ['model' => $setting['model']],
                    [
                        'module' => $setting['module'],
                        'module_name' => $setting['module_name'],
                        'name' => $setting['name'],
                        'slug' => $setting['slug'],
                        'description' => $setting['description'],
                        'message' => $setting['message']
                    ]
                );
            }
        });
    }
}
