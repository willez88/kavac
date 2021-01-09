<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\CodeSetting;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Document;
use App\Models\DocumentStatus;
use App\Models\Estate;
use App\Models\ExchangeRate;
use App\Models\FiscalYear;
use App\Models\Institution;
use App\Models\InstitutionSector;
use App\Models\InstitutionType;
use App\Models\Profession;
use App\Models\Tax;
use App\Models\HistoryTax;
use App\Models\TaxUnit;
use App\Models\MaritalStatus;
use App\Models\MeasurementUnit;
use App\Models\Municipality;
use App\Models\Parameter;
use App\Models\Parish;
use App\Models\Setting;
use App\Models\RequiredDocument;
use App\Models\NotificationSetting;
use App\Models\User;
use DB;

/**
 * @class CoreNotificationSettingsTableSeeder
 * @brief Información por defecto para la configuración de notificaciones
 *
 * Gestiona la información por defecto a registrar inicialmente para la configuración de notificaciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
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

        $userAdmin = User::where('level', 1)->get();

        $notifySettings = [
            [
                'model' => City::class,
                'name' => 'Ciudad',
                'slug' => 'city',
                'description' => 'Gestión de Ciudades',
                'message' => 'Se ha generado un evento en Ciudades',
                'perm_required' => 'city.notify'
            ],
            [
                'model' => Parameter::class,
                'name' => 'Parámetro',
                'slug' => 'parameter',
                'description' => 'Gestión de Parámetros',
                'message' => 'Se ha generado un evento en Parámetros',
                'perm_required' => 'system.param.setting.notify'
            ],
            [
                'model' => CodeSetting::class,
                'name' => 'Configuración de código',
                'slug' => 'codeSetting',
                'description' => 'Gestión de códigos en registros',
                'message' => 'Se ha generado un evento en configuración de códigos',
                'perm_required' => 'code.settings.notify'
            ],
            [
                'model' => Country::class,
                'name' => 'Configuración de Pais',
                'slug' => 'country',
                'description' => 'Gestión de Países',
                'message' => 'Se ha generado un evento en Pais',
                'perm_required' => 'country.notify'
            ],
            [
                'model' => RequiredDocument::class,
                'name' => 'Documentos Requeridos',
                'slug' => 'requiredDocument',
                'description' => 'Documentos Requeridos',
                'message' => 'Se ha generado un evento en Documentos Requeridos',
                'perm_required' => 'document.required.notify'
            ],
            [
                'model' => Setting::class,
                'name' => 'Configuración General',
                'slug' => 'setting',
                'description' => 'Gestión de Configuraciones',
                'message' => 'Se ha generado un evento en Configuración',
                'perm_required' => 'system.param.setting.notify'
            ],
            [
                'model' => Parish::class,
                'name' => 'Configuración de Parroquias',
                'slug' => 'parish',
                'description' => 'Gestión de Parroquias',
                'message' => 'Se ha generado un evento en Parroquias',
                'perm_required' => 'parish.notify'
            ],
            [
                'model' => Institution::class,
                'name' => 'Organización',
                'slug' => 'institution',
                'description' => 'Gestión de organizaciones',
                'message' => 'Se ha generado un evento en organizaciones',
                'perm_required' => 'institution.notify'
            ],
            [
                'model' => InstitutionSector::class,
                'name' => 'Sector de Organización',
                'slug' => 'institutionSector',
                'description' => 'Gestión de sectores de organizaciones',
                'message' => 'Se ha generado un evento en sectores de organizaciones',
                'perm_required' => 'institution.sector.notify'
            ],
            [
                'model' => InstitutionType::class,
                'name' => 'Tipo de Organización',
                'slug' => 'institutionType',
                'description' => 'Gestión de tipos de organizaciones',
                'message' => 'Se ha generado un evento en tipos de organizaciones',
                'perm_required' => 'institution.type.notify'
            ],
            [
                'model' => Currency::class,
                'name' => 'Moneda',
                'slug' => 'currency',
                'description' => 'Gestión de monedas',
                'message' => 'Se ha generado un evento en Monedas',
                'perm_required' => 'currency.notify'
            ],
            [
                'model' => MaritalStatus::class,
                'name' => 'Estado Civil',
                'slug' => 'maritalStatus',
                'description' => 'Gestión de Estados Civiles',
                'message' => 'Se ha generado un evento en Estados Civiles',
                'perm_required' => 'marital.status.notify'
            ],
            [
                'model' => MeasurementUnit::class,
                'name' => 'Unidades de Medida',
                'slug' => 'measurementUnit',
                'description' => 'Gestión de Unidades de Medida',
                'message' => 'Se ha generado un evento en Unidades de Medida',
                'perm_required' => 'measurement.unit.notify'
            ],
            [
                'model' => Municipality::class,
                'name' => 'Municipio',
                'slug' => 'municipality',
                'description' => 'Gestión de Municipios',
                'message' => 'Se ha generado un evento en Municipios',
                'perm_required' => 'municipality.notify'
            ],
            [
                'model' => Deduction::class,
                'name' => 'Deducción',
                'slug' => 'deduction',
                'description' => 'Gestión de deducciones',
                'message' => 'Se ha generado un evento en Deducciones',
                'perm_required' => 'deduction.notify'
            ],
            [
                'model' => Department::class,
                'name' => 'Departamento',
                'slug' => 'department',
                'description' => 'Gestión de departamentos',
                'message' => 'Se ha generado un evento en Departamentos',
                'perm_required' => 'department.notify'
            ],
            [
                'model' => Document::class,
                'name' => 'Documento',
                'slug' => 'document',
                'description' => 'Gestión de documentos',
                'message' => 'Se ha generado un evento en Documentos',
                'perm_required' => 'document.notify'
            ],
            [
                'model' => DocumentStatus::class,
                'name' => 'Estatus de documento',
                'slug' => 'documentStatus',
                'description' => 'Gestión de estatus de documentos',
                'message' => 'Se ha generado un evento en Estatus de Documentos',
                'perm_required' => 'document.status.notify'
            ],
            [
                'model' => Estate::class,
                'name' => 'Estado',
                'slug' => 'estate',
                'description' => 'Gestión en Estados de un Pais',
                'message' => 'Se ha generado un evento en Estados de Pais',
                'perm_required' => 'estate.notify'
            ],
            [
                'model' => ExchangeRate::class,
                'name' => 'Intercambio de Moneda',
                'slug' => 'exchange_rate',
                'description' => 'Gestión de intercambios de monedas',
                'message' => 'Se ha generado un evento en Intercambio de Monedas',
                'perm_required' => 'exchange.rate.notify'
            ],
            [
                'model' => FiscalYear::class,
                'name' => 'Año fiscal',
                'slug' => 'fiscalYear',
                'description' => 'Gestión de años fiscales',
                'message' => 'Se ha generado un evento en Año fiscal',
                'perm_required' => 'fiscal.year.notify'
            ],
            [
                'model' => HistoryTax::class,
                'name' => 'Histórico de impuesto',
                'slug' => 'historyTax',
                'description' => 'Gestión de histórico de impuestos',
                'message' => 'Se ha generado un evento en histórico de impuestos',
                'perm_required' => 'history.tax.notify'
            ],
            [
                'model' => Profession::class,
                'name' => 'Profesión',
                'slug' => 'profession',
                'description' => 'Gestión de profesiones',
                'message' => 'Se ha generado un evento en Profesiones',
                'perm_required' => 'profession.notify'
            ],
            [
                'model' => Tax::class,
                'name' => 'Impuesto',
                'slug' => 'tax',
                'description' => 'Gestión de impuestos',
                'message' => 'Se ha generado un evento en Impuestos',
                'perm_required' => 'tax.notify'
            ],
            [
                'model' => TaxUnit::class,
                'name' => 'Unidad Tributaria',
                'slug' => 'taxUnit',
                'description' => 'Gestión de Unidades Tributarias',
                'message' => 'Se ha generado un evento en Unidad Tributaria',
                'perm_required' => 'tax.unit.notify'
            ]
        ];

        DB::transaction(function () use ($notifySettings, $userAdmin) {
            foreach ($notifySettings as $setting) {
                $notificationSetting = NotificationSetting::updateOrCreate(
                    ['model' => $setting['model']],
                    [
                        'name' => $setting['name'],
                        'slug' => $setting['slug'],
                        'description' => $setting['description'],
                        'message' => $setting['message'],
                        'perm_required' => $setting['perm_required'] ?? null
                    ]
                );
                $notificationSetting->users()->sync($userAdmin);
            }
        });
    }
}
