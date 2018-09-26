<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;
use App\Models\Country;
use App\Models\Estate;

class EstatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $country_default = Country::where('name', 'Venezuela')->first();

        $estates = [
        	"01" => "Distrito Capital",
        	"02" => "Amazonas",
        	"03" => "Anzoategui", 
        	"04" => "Apure",
        	"05" => "Aragua",
        	"06" => "Barinas",
        	"07" => "Bolívar",
        	"08" => "Carabobo",
        	"09" => "Cojedes",
        	"10" => "Delta Amacuro",
        	"11" => "Falcón",
        	"12" => "Guárico",
        	"13" => "Lara",
        	"14" => "Mérida",
        	"15" => "Miranda",
        	"16" => "Monagas",
        	"17" => "Nueva Esparta",
        	"18" => "Portuguesa",
        	"19" => "Sucre",
        	"20" => "Táchira",
        	"21" => "Trujillo",
        	"22" => "Yaracuy",
        	"23" => "Zulia",
        	"24" => "Vargas"
        ];

        foreach ($estates as $code => $state) {
        	Estate::updateOrCreate(
        		['code' => $code],
        		['name' => $state, 'country_id' => $country_default->id]
	        );
        }

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de estados
         */

        $permissions = [
            [
                'name' => 'Crear Estados', 'slug' => 'estate.create',
                'description' => 'Acceso al registro de estados', 
                'model' => 'App\Models\Estate', 'model_prefix' => '0general',
                'slug_alt' => 'estado.crear', 'short_description' => 'agregar estado'
            ],
            [
                'name' => 'Editar Estados', 'slug' => 'estate.edit',
                'description' => 'Acceso para editar estados', 
                'model' => 'App\Models\Estate', 'model_prefix' => '0general',
                'slug_alt' => 'estado.editar', 'short_description' => 'editar estado'
            ],
            [
                'name' => 'Eliminar Estados', 'slug' => 'estate.delete',
                'description' => 'Acceso para eliminar estados', 
                'model' => 'App\Models\Estate', 'model_prefix' => '0general',
                'slug_alt' => 'estado.eliminar', 'short_description' => 'eliminar estado'
            ],
            [
                'name' => 'Ver Estados', 'slug' => 'estate.list',
                'description' => 'Acceso para ver estados', 
                'model' => 'App\Models\Estate', 'model_prefix' => '0general',
                'slug_alt' => 'estado.ver', 'short_description' => 'ver estados'
            ],
        ];

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                ]
            );
            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }
    }
}
