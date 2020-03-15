<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Institution;
use App\Models\Currency;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Document;
use App\Models\ExchangeRate;
use App\Models\Profession;
use App\Models\Tax;
use App\Models\NotificationSetting;

class CoreNotificationSettingsTableSeeder extends Seeder
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
                'model' => Institution::class,
                'name' => 'Institución',
                'description' => 'Gestión de instituciones',
                'message' => 'Se ha generado un evento en Instituciones'
            ],
            [
                'model' => Currency::class,
                'name' => 'Moneda',
                'description' => 'Gestión de monedas',
                'message' => 'Se ha generado un evento en Monedas'
            ],
            [
                'model' => Deduction::class,
                'name' => 'Deducción',
                'description' => 'Gestión de deducciones',
                'message' => 'Se ha generado un evento en Deducciones'
            ],
            [
                'model' => Department::class,
                'name' => 'Departamento',
                'description' => 'Gestión de departamentos',
                'message' => 'Se ha generado un evento en Departamentos'
            ],
            [
                'model' => Document::class,
                'name' => 'Documento',
                'description' => 'Gestión de documentos',
                'message' => 'Se ha generado un evento en Documentos'
            ],
            [
                'model' => ExchangeRate::class,
                'name' => 'Intercambio de Moneda',
                'description' => 'Gestión de intercambios de monedas',
                'message' => 'Se ha generado un evento en Intercambio de Monedas'
            ],
            [
                'model' => Profession::class,
                'name' => 'Profesión',
                'description' => 'Gestión de profesiones',
                'message' => 'Se ha generado un evento en Profesiones'
            ],
            [
                'model' => Tax::class,
                'name' => 'Impuesto',
                'description' => 'Gestión de impuestos',
                'message' => 'Se ha generado un evento en Impuestos'
            ]
        ];

        DB::transaction(function () use ($notifySettings) {
            foreach ($notifySettings as $setting) {
                NotificationSetting::updateOrCreate(
                    ['model' => $setting['model']],
                    [
                        'name' => $setting['name'],
                        'description' => $setting['description'],
                        'message' => $setting['message']
                    ]
                );
            }
        });
    }
}
