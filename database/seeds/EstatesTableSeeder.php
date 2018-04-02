<?php

use Illuminate\Database\Seeder;

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
    }
}
