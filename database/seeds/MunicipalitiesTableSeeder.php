<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Roles\Role;
use App\Roles\Permission;
use App\Models\Estate;
use App\Models\Municipality;

/**
 * @class MunicipalitiesTableSeeder
 * @brief Información por defecto para Municipios
 * 
 * Gestiona la información por defecto a registrar inicialmente para los Municipios
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class MunicipalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $estates_municipalities = [
        	"01" => [
        		"0101" => "Libertador"
        	],
        	"02" => [
        		"0201" => "Autonomo Alto Orinoco",
        		"0202" => "Autonomo Atabapo",
        		"0203" => "Autonomo Atures", 
        		"0204" => "Autonomo Autana",
        		"0205" => "Autonomo Maroa",
        		"0206" => "Autonomo Manapiare", 
        		"0207" => "Autonomo Río Negro"
        	],
        	"03" => [
        		"0301" => "Anaco",
        		"0302" => "Aragua",
        		"0303" => "Fernando de Peñalver", 
        		"0304" => "Francisco del Carmen Carvajal",
        		"0305" => "Francisco de Miranda",
        		"0306" => "Guanta",
        		"0307" => "Independencia",
        		"0308" => "Juan Antonio Sotillo",
        		"0309" => "Juan Manuel Cajigal",
        		"0310" => "José Gregorio Monagas",
        		"0311" => "Libertad",
        		"0312" => "Manuel Ezequiel Bruzual",
        		"0313" => "Pedro María Freites",
        		"0314" => "Píritu",
        		"0315" => "San José de Guanipa", 
        		"0316" => "San Juan de Capistrano",
        		"0317" => "Santa Ana",
        		"0318" => "Simón Bolívar", 
        		"0319" => "Simón Rodríguez",
        		"0320" => "Sir Artur Mc Gregor",
        		"0321" => "Turístico Diego Bautista Urbaneja"
        	],
        	"04" => [
        		"0401" => "Achaguas",
        		"0402" => "Biruaca",
        		"0403" => "Muñoz",
        		"0404" => "Paéz",
        		"0405" => "Pedro Camejo",
        		"0406" => "Rómulo Gallegos",
        		"0407" => "San Fernando"
        	],
        	"05" => [
        		"0501" => "Bolívar",
        		"0502" => "Camatagua",
        		"0503" => "Girardot",
        		"0504" => "José Ángel Lamas",
        		"0505" => "José Félix Rivas",
        		"0506" => "José Rafael Revenga",
        		"0507" => "Libertador",
        		"0508" => "Mario Briceño Iragorry",
        		"0509" => "San Casimiro",
        		"0510" => "San Sebástian",
        		"0511" => "Santiago Mariño",
        		"0512" => "Santos Michelena",
        		"0513" => "Sucre",
        		"0514" => "Tovar",
        		"0515" => "Urdaneta",
        		"0516" => "Zamora",
        		"0517" => "Francisco Linares Alcantara",
        		"0518" => "Ocumare de la Costa de Oro"
        	],
        	"06" => [
        		"0601" => "Alberto Arvelo Torrealba",
        		"0602" => "Antonio José de Sucre",
        		"0603" => "Arismendí",
        		"0604" => "Barinas",
        		"0605" => "Bolívar",
        		"0606" => "Cruz Paredes",
        		"0607" => "Ezequiel Zamora",
        		"0608" => "Obispos",
        		"0609" => "Pedraza",
        		"0610" => "Rojas",
        		"0611" => "Sosa",
        		"0612" => "Andrés Eloy Blanco"
        	],
        	"07" => [
        		"0701" => "Caroní",
        		"0702" => "Cedeño",
        		"0703" => "El Callao",
        		"0704" => "Gran Sabana",
        		"0705" => "Héres",
        		"0706" => "Piar",
        		"0707" => "Raúl Leoní",
        		"0708" => "Roscio",
        		"0709" => "Sifontes",
        		"0710" => "Sucre",
        		"0711" => "Padre Pedro Chien"
        	],
        	"08" => [
        		"0801" => "Bejuma",
        		"0802" => "Carlos Arvelo",
        		"0803" => "Diego Íbarra",
        		"0804" => "Guacara",
        		"0805" => "Juan José Mora",
        		"0806" => "Libertador",
        		"0807" => "Los Guayos",
        		"0808" => "Miranda",
        		"0809" => "Montalban",
        		"0810" => "Naguanagua",
        		"0811" => "Puerto Cabello",
        		"0812" => "San Diego",
        		"0813" => "San Joaquín",
        		"0814" => "Valencia"
        	],
        	"09" => [
        		"0901" => "Anzoategui",
        		"0902" => "Falcón",
        		"0903" => "Girardot",
        		"0904" => "Lima Blanco",
        		"0905" => "Pao de San Juan Bautista",
        		"0906" => "Ricaurte",
        		"0907" => "Rómulo Gallegos",
        		"0908" => "San Carlos",
        		"0909" => "Tinaco"
        	],
        	"10" => [
        		"1001" => "Antonio Díaz",
        		"1002" => "Casacoíma",
        		"1003" => "Pedernales",
        		"1004" => "Tucupita"
        	],
        	"11" => [
        		"1101" => "Acosta",
        		"1102" => "Bolívar",
        		"1103" => "Buchivacoa",
        		"1104" => "Cacique Manaure",
        		"1105" => "Carirubana",
        		"1106" => "Colina",
        		"1107" => "Dabajuro",
        		"1108" => "Democracia",
        		"1109" => "Falcón",
        		"1110" => "Federación",
        		"1111" => "Jacura",
        		"1112" => "Los Taques",
        		"1113" => "Mauroa",
        		"1114" => "Miranda",
        		"1115" => "Monseñor Iturriza",
        		"1116" => "Palmasola",
        		"1117" => "Petit",
        		"1118" => "Piritú",
        		"1119" => "San Francisco",
        		"1120" => "Silva",
        		"1121" => "Sucre",
        		"1122" => "Tocopero",
        		"1123" => "Unión",
        		"1124" => "Urumaco",
        		"1125" => "Zamora"
        	],
        	"12" => [
        		"1201" => "Camaguan",
        		"1202" => "Chaguaramas",
        		"1203" => "El Socorro",
        		"1204" => "San Gerónimo de Guayabal",
        		"1205" => "Leonardo Infante",
        		"1206" => "Las Mercedes",
        		"1207" => "Julian Mellado",
        		"1208" => "Francisco de Miranda",
        		"1209" => "José Tadeo Monagas",
        		"1210" => "Ortiz",
        		"1211" => "José Félix Rivas",
        		"1212" => "Juan German Roscio",
        		"1213" => "San José de Guaribe",
        		"1214" => "Santa María de Ipire",
        		"1215" => "Zaraza"
        	],
        	"13" => [
        		"1301" => "Andrés Eloy Blanco",
        		"1302" => "Crespo",
        		"1303" => "Iribarren",
        		"1304" => "Jiménez",
        		"1305" => "Moran",
        		"1306" => "Palavecino",
        		"1307" => "Simón Planas",
        		"1308" => "Torres",
        		"1309" => "Urdaneta"
        	],
        	"14" => [
        		"1401" => "Alberto Adriani",
        		"1402" => "Andrés Bello",
        		"1403" => "Antonio Pinto Salinas",
        		"1404" => "Aricagua",
        		"1405" => "Arzobispo Chacón",
        		"1406" => "Campo Elías",
        		"1407" => "Caracciolo Parra Olmedo",
        		"1408" => "Cardenal Quintero",
        		"1409" => "Guaraque",
        		"1410" => "Julio Cesar Salas",
        		"1411" => "Justo Briceño",
        		"1412" => "Libertador",
        		"1413" => "Miranda",
        		"1414" => "Obispo Ramos de Lora",
        		"1415" => "Padre Noguera",
        		"1416" => "Pueblo Llano",
        		"1417" => "Rángel",
        		"1418" => "Rivas Dávila",
        		"1419" => "Santos Marquina",
        		"1420" => "Sucre",
        		"1421" => "Tovar",
        		"1422" => "Tulio Febres Cordero",
        		"1423" => "Zea"
        	],
        	"15" => [
        		"1501" => "Acevedo",
        		"1502" => "Andrés Bello",
        		"1503" => "Baruta",
        		"1504" => "Brion",
        		"1505" => "Buroz",
        		"1506" => "Carrizal",
        		"1507" => "Chacao",
        		"1508" => "Cristobal Rojas",
        		"1509" => "El Hatillo",
        		"1510" => "Guaicaipuro",
        		"1511" => "Independencia",
        		"1512" => "Lander",
        		"1513" => "Los Salias",
        		"1514" => "Paéz",
        		"1515" => "Paz Castillo",
        		"1516" => "Pedro Gual",
        		"1517" => "Plaza",
        		"1518" => "Simón Bolívar",
        		"1519" => "Sucre",
        		"1520" => "Urdaneta",
        		"1521" => "Zamora"
        	],
        	"16" => [
        		"1601" => "Acosta",
        		"1602" => "Aguasay",
        		"1603" => "Bolívar",
        		"1604" => "Caripe",
        		"1605" => "Cedeño",
        		"1606" => "Ezequiel Zamora",
        		"1607" => "Libertador",
        		"1608" => "Maturín",
        		"1609" => "Piar",
        		"1610" => "Punceres",
        		"1611" => "Santa Barbara",
        		"1612" => "Sotillo",
        		"1613" => "Uracoa"
        	],
        	"17" => [
        		"1701" => "Antolín del Campo",
        		"1702" => "Arismendí",
        		"1703" => "Díaz",
        		"1704" => "Garcia",
        		"1705" => "Gómez",
        		"1706" => "Maneiro",
        		"1707" => "Marcano",
        		"1708" => "Mario",
        		"1709" => "Península de Macanao",
        		"1710" => "Tubores",
        		"1711" => "Villalba"
        	],
        	"18" => [
        		"1801" => "Agua Blanca",
        		"1802" => "Araure",
        		"1803" => "Esteller",
        		"1804" => "Guanare",
        		"1805" => "Guanarito",
        		"1806" => "Monseñor José Vicente de Unda",
        		"1807" => "Ospino",
        		"1808" => "Paéz",
        		"1809" => "Papelón",
        		"1810" => "San Genaro de Boconoíto",
        		"1811" => "San Rafael de Onoto",
        		"1812" => "Santa Rosalia",
        		"1813" => "Sucre",
        		"1814" => "Turen"
        	],
        	"19" => [
        		"1901" => "Andrés Eloy Blanco",
        		"1902" => "Andrés Mata",
        		"1903" => "Arismendí",
        		"1904" => "Benítez",
        		"1905" => "Bermudez",
        		"1906" => "Bolívar",
        		"1907" => "Cajigal",
        		"1908" => "Cruz Salmeron Acosta",
        		"1909" => "Libertador",
        		"1910" => "Mario",
        		"1911" => "Mejia",
        		"1912" => "Montes",
        		"1913" => "Ribero",
        		"1914" => "Sucre",
        		"1915" => "Valdez"
        	],
        	"20" => [
        		"2001" => "Andrés Bello",
        		"2002" => "Antonio Rómulo Costa",
        		"2003" => "Ayacucho",
        		"2004" => "Bolívar",
        		"2005" => "Cardenas",
        		"2006" => "Cordoba",
        		"2007" => "Fernández Feo",
        		"2008" => "Francisco de Miranda",
        		"2009" => "Garcia de Hevia",
        		"2010" => "Guasimos",
        		"2011" => "Independencia",
        		"2012" => "Jaureguí",
        		"2013" => "José María Vargas",
        		"2014" => "Junín",
        		"2015" => "Libertad",
        		"2016" => "Libertador",
        		"2017" => "Lobatera",
        		"2018" => "Michelena",
        		"2019" => "Panamericano",
        		"2020" => "Pedro María Ureña",
        		"2021" => "Rafael Urdaneta",
        		"2022" => "Samuel Darío Maldonado",
        		"2023" => "San Cristóbal",
        		"2024" => "Seboruco",
        		"2025" => "Simón Rodríguez",
        		"2026" => "Sucre",
        		"2027" => "Torbes",
        		"2028" => "Uribante",
        		"2029" => "San Judas Tadeo"
        	],
        	"21" => [
        		"2101" => "Andrés Bello",
        		"2102" => "Bocono",
        		"2103" => "Bolívar",
        		"2104" => "Candelaria",
        		"2105" => "Carache",
        		"2106" => "Escuque",
        		"2107" => "José Felipe Marquez Caizales",
        		"2108" => "Juan Vicente Campo Elías",
        		"2109" => "La Ceiba",
        		"2110" => "Miranda",
        		"2111" => "Monte Carmelo",
        		"2112" => "Motatan",
        		"2113" => "Pampan",
        		"2114" => "Pampanito",
        		"2115" => "Rafael Rángel",
        		"2116" => "San Rafael de Carvajal",
        		"2117" => "Sucre",
        		"2118" => "Trujillo",
        		"2119" => "Urdaneta",
        		"2120" => "Valera"
        	],
        	"22" => [
        		"2201" => "Aristides Bastidas",
        		"2202" => "Bolívar",
        		"2203" => "Bruzual",
        		"2204" => "Cocorote",
        		"2205" => "Independencia",
        		"2206" => "José Antonio Paéz",
        		"2207" => "La Trinidad",
        		"2208" => "Manuel Monge",
        		"2209" => "Nirgua",
        		"2210" => "Peña",
        		"2211" => "San Felipe",
        		"2212" => "Sucre",
        		"2213" => "Urachiche",
        		"2214" => "Veroes"
        	],
        	"23" => [
        		"2301" => "Almirante Padilla",
        		"2302" => "Baralt",
        		"2303" => "Cabimas",
        		"2304" => "Catatumbo",
        		"2305" => "Colón",
        		"2306" => "Francisco Javier Pulgar",
        		"2307" => "Jesús Enrique Lossada",
        		"2308" => "Jesús María Semprum",
        		"2309" => "La Cañada de Urdaneta",
        		"2310" => "Lagunillas",
        		"2311" => "Machiques de Perija",
        		"2312" => "Mara",
        		"2313" => "Maracaibo",
        		"2314" => "Miranda",
        		"2315" => "Paéz",
        		"2316" => "Rosario de Perija",
        		"2317" => "San Francisco",
        		"2318" => "Santa Rita",
        		"2319" => "Simón Bolívar",
        		"2320" => "Sucre",
        		"2321" => "Valmore Rodríguez"
        	],
        	"24" => [
        		"2401" => "Vargas"
        	],
        ];

        foreach ($estates_municipalities as $code_estate => $municipalities) {
        	$edo = Estate::where('code', $code_estate)->first();
        	foreach ($municipalities as $code => $municipality) {
        		if ($municipality) {
        			Municipality::updateOrCreate(
		        		['code' => $code],
		        		['name' => $municipality, 'estate_id' => $edo->id]
			        );
        		}
        	}
        }

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de municipios
         */

        $permissions = [
            [
                'name' => 'Crear Municipios', 'slug' => 'municipality.create',
                'description' => 'Acceso al registro de municipios', 
                'model' => 'App\Models\Municipality', 'model_prefix' => '0general',
                'slug_alt' => 'municipio.crear', 'short_description' => 'agregar municipio'
            ],
            [
                'name' => 'Editar Municipios', 'slug' => 'municipality.edit',
                'description' => 'Acceso para editar municipios', 
                'model' => 'App\Models\Municipality', 'model_prefix' => '0general',
                'slug_alt' => 'municipio.editar', 'short_description' => 'editar municipio'
            ],
            [
                'name' => 'Eliminar Municipios', 'slug' => 'municipality.delete',
                'description' => 'Acceso para eliminar municipios', 
                'model' => 'App\Models\Municipality', 'model_prefix' => '0general',
                'slug_alt' => 'municipio.eliminar', 'short_description' => 'eliminar municipio'
            ],
            [
                'name' => 'Ver Municipios', 'slug' => 'municipality.list',
                'description' => 'Acceso para ver municipios', 
                'model' => 'App\Models\Municipality', 'model_prefix' => '0general',
                'slug_alt' => 'municipio.ver', 'short_description' => 'ver municipios'
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
