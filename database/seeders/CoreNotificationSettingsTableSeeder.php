<?php
namespace Database\Seeders;

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
                'slug' => 'institution',
                'description' => 'Gestión de instituciones',
                'message' => 'Se ha generado un evento en Instituciones'
            ],
            [
                'model' => Currency::class,
                'name' => 'Moneda',
                'slug' => 'currency',
                'description' => 'Gestión de monedas',
                'message' => 'Se ha generado un evento en Monedas'
            ],
            [
                'model' => Deduction::class,
                'name' => 'Deducción',
                'slug' => 'deduction',
                'description' => 'Gestión de deducciones',
                'message' => 'Se ha generado un evento en Deducciones'
            ],
            [
                'model' => Department::class,
                'name' => 'Departamento',
                'slug' => 'department',
                'description' => 'Gestión de departamentos',
                'message' => 'Se ha generado un evento en Departamentos'
            ],
            [
                'model' => Document::class,
                'name' => 'Documento',
                'slug' => 'document',
                'description' => 'Gestión de documentos',
                'message' => 'Se ha generado un evento en Documentos'
            ],
            [
                'model' => ExchangeRate::class,
                'name' => 'Intercambio de Moneda',
                'slug' => 'exchange_rate',
                'description' => 'Gestión de intercambios de monedas',
                'message' => 'Se ha generado un evento en Intercambio de Monedas'
            ],
            [
                'model' => Profession::class,
                'name' => 'Profesión',
                'slug' => 'profession',
                'description' => 'Gestión de profesiones',
                'message' => 'Se ha generado un evento en Profesiones'
            ],
            [
                'model' => Tax::class,
                'name' => 'Impuesto',
                'slug' => 'tax',
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
                        'slug' => $setting['slug'],
                        'description' => $setting['description'],
                        'message' => $setting['message']
                    ]
                );
            }
        });
    }
}
