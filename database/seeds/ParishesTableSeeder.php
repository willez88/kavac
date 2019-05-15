<?php

use Illuminate\Database\Seeder;

use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;
use App\Models\Municipality;
use App\Models\Parish;

/**
 * @class ParishTableSeeder
 * @brief Información por defecto para Parroquias
 * 
 * Gestiona la información por defecto a registrar inicialmente para las Parroquias
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class ParishesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $municipalities_parishes = [
            '0101' => [
                '010101' => 'Altagracia',
                '010102' => 'Antímano',
                '010103' => 'Candelaria',
                '010104' => 'Caricuao',
                '010105' => 'Catedral',
                '010106' => 'Coche',
                '010107' => 'El Junquito',
                '010108' => 'EL Paraíso',
                '010109' => 'El Recreo',
                '010110' => 'El Valle',
                '010111' => 'La Pastora',
                '010112' => 'La Vega',
                '010113' => 'Macarao',
                '010114' => 'San Agustín',
                '010115' => 'San Bernardino',
                '010116' => 'San José',
                '010117' => 'San Juan',
                '010118' => 'San Pedro',
                '010119' => 'Santa Rosalía',
                '010120' => 'Santa Teresa',
                '010121' => 'Sucre',
                '010122' => '23 de Enero',
            ],
            '0201' => [
                '020101' => 'Capital Alto Orinoco',
                '020102' => 'Huachamacare',
                '020103' => 'Marawaka',
                '020104' => 'Mavaca',
                '020105' => 'Sierra Parima',
            ],
            '0202' => [
                '020201' => 'Capital Atabapo',
                '020202' => 'Ucata',
                '020203' => 'Yapacana',
                '020204' => 'Caname',
            ],
            '0203' => [
                '020301' => 'Fernando Girón Tovar',
                '020302' => 'Luis Alberto Gómez',
                '020303' => 'Parhueña',
                '020304' => 'Platanillal',
            ],
            '0204' => [
                '020401' => 'Capital Autana',
                '020402' => 'Samariapo',
                '020403' => 'Sipapo',
                '020404' => 'Munduapo',
                '020405' => 'Guayapo',
            ],
            '0205' => [
                '020501' => 'Victorino',
                '020502' => 'Comunidad',
            ],
            '0206' => [
                '020601' => 'Capital Manapiare',
                '020602' => 'Alto Ventuari',
                '020603' => 'Medio Ventuari',
                '020604' => 'Bajo Ventuari',
            ],
            '0207' => [
                '020701' => 'Capital Río Negro',
                '020702' => 'Solano',
                '020703' => 'Casiquiare',
                '020704' => 'Cocuy',
            ],
            '0301' => [
                '030101' => 'Anaco',
                '030102' => 'San Joaquín',
            ],
            '0302' => [
                '030201' => 'Capital Aragua',
                '030202' => 'Cachipo',
            ],
            '0303' => [
                '030301' => 'Capital Fernando de Peñalver',
                '030302' => 'San Miguel',
                '030303' => 'Sucre',
            ],
            '0304' => [
                '030401' => 'Valle de Guanape',
                '030402' => 'Santa Bárbara',
            ],
            '0305' => [
                '030501' => 'Capital Francisco de Miranda',
                '030502' => 'Atapirire',
                '030503' => 'Boca del Pao',
                '030504' => 'El Pao',
                '030505' => 'Múcura',
            ],
            '0306' => [
                '030601' => 'Guanta',
                '030602' => 'Chorrerón',
            ],
            '0307' => [
                '030701' => 'Capital Independencia',
                '030702' => 'Mamo',
            ],
            '0308' => [
                '030801' => 'Puerto La Cruz',
                '030802' => 'Pozuelos',
            ],
            '0309' => [
                '030901' => 'Onoto',
                '030902' => 'San Pablo',
            ],
            '0310' => [
                '031001' => 'Capital José Gregorio Monagas',
                '031002' => 'Piar',
                '031003' => 'San Diego de Cabrutica',
                '031004' => 'Santa Clara',
                '031005' => 'Uverito',
                '031006' => 'Zuata',
            ],
            '0311' => [
                '031101' => 'Capital Libertad',
                '031102' => 'El Carito',
                '031103' => 'Santa Inés',
            ],
            '0312' => [
                '031201' => 'Clarines',
                '031202' => 'Guanape',
                '031203' => 'Sabana de Uchire',
            ],
            '0313' => [
                '031301' => 'Capital Pedro María Freites',
                '031302' => 'Libertador',
                '031303' => 'Santa Rosa',
                '031304' => 'Urica',
            ],
            '0314' => [
                '031401' => 'Píritu',
                '031402' => 'San Francisco',
            ],
            '0315' => [
                '031501' => 'Capital San José de Guanipa',
            ],
            '0316' => [
                '031601' => 'Boca de Uchire',
                '031602' => 'Boca de Chávez',
            ],
            '0317' => [
                '031701' => 'Santa Ana',
                '031702' => 'Pueblo Nuevo',
            ],
            '0318' => [
                '031801' => 'El Carmen',
                '031802' => 'San Cristóbal',
                '031803' => 'Bergantín',
                '031804' => 'Caigua',
                '031805' => 'El Pilar',
                '031806' => 'Naricual',
            ],
            '0319' => [
                '031901' => 'Edmundo Barrios',
                '031902' => 'Miguel Otero Silva',
            ],
            '0320' => [
                '032001' => 'El Chaparro',
                '032002' => 'Tomás Alfaro Calatrava',
            ],
            '0321' => [
                '032101' => 'Lecherías',
                '032102' => 'El Morro',
            ],
            '0401' => [
                '040101' => 'Achaguas',
                '040102' => 'Apurito',
                '040103' => 'El Yagual',
                '040104' => 'Guachara',
                '040105' => 'Mucuritas',
                '040106' => 'Queseras del Medio',
            ],
            '0402' => [
                '040201' => 'Biruaca',
            ],
            '0403' => [
                '040301' => 'Bruzual',
                '040302' => 'Mantecal',
                '040303' => 'Quintero',
                '040304' => 'Rincón Hondo',
                '040305' => 'San Vicente',
            ],
            '0404' => [
                '040401' => 'Guasdualito',
                '040402' => 'Aramendi',
                '040403' => 'El Amparo',
                '040404' => 'San Camilo',
                '040405' => 'Urdaneta',
            ],
            '0405' => [
                '040501' => 'San Juan de Payara',
                '040502' => 'Codazzi',
                '040503' => 'Cunaviche',
            ],
            '0406' => [
                '040601' => 'Elorza',
                '040602' => 'La Trinidad',
            ],
            '0407' => [
                '040701' => 'San Fernando',
                '040702' => 'El Recreo',
                '040703' => 'Peñalver',
                '040704' => 'San Rafael de Atamaica',
            ],
            '0501' => [
                '050101' => 'Capital Bolívar',
            ],
            '0502' => [
                '050201' => 'Capital Camatagua',
                '050202' => 'Carmen de Cura',
            ],
            '0503' => [
                '050302' => 'Choroní',
                '050303' => 'Las Delicias',
                '050304' => 'Madre María de San José',
                '050305' => 'Joaquín Crespo',
                '050306' => 'Pedro José Ovalles',
                '050307' => 'José Casanova Godoy',
                '050308' => 'Andrés Eloy Blanco',
                '050309' => 'Los Tacariguas',
            ],
            '0504' => [
                '050401' => 'Capital José Angel Lamas',
            ],
            '0505' => [
                '050501' => 'Capital José Félix Ribas',
                '050502' => 'Castor Nieves Ríos',
                '050503' => 'Las Guacamayas',
                '050504' => 'Pao de Zárate',
                '050505' => 'Zuata',
            ],
            '0506' => [
                '050601' => 'Capital José Rafael Revenga',
            ],
            '0507' => [
                '050701' => 'Capital Libertador',
                '050702' => 'San Martín de Porres',
            ],
            '0508' => [
                '050801' => 'Capital Mario Briceño Iragorry',
                '050802' => 'Caña de Azúcar',
            ],
            '0509' => [
                '050901' => 'Capital San Casimiro',
                '050902' => 'Güiripa',
                '050903' => 'Ollas de Caramacate',
                '050904' => 'Valle Morín',
            ],
            '0510' => [
                '051001' => 'Capital San Sebastián',
            ],
            '0511' => [
                '051101' => 'Capital Santiago Mariño',
                '051102' => 'Arévalo Aponte',
                '051103' => 'Chuao',
                '051104' => 'Samán de Güere',
                '051105' => 'Alfredo Pacheco Miranda',
            ],
            '0512' => [
                '051201' => 'Capital Santos Michelena',
                '051202' => 'Tiara',
            ],
            '0513' => [
                '051301' => 'Capital Sucre',
                '051302' => 'Bella Vista',
            ],
            '0514' => [
                '051401' => 'Capital Tovar',
            ],
            '0515' => [
                '051501' => 'Capital Urdaneta',
                '051502' => 'Las Peñitas',
                '051503' => 'San Francisco de Cara',
                '051504' => 'Taguay',
            ],
            '0516' => [
                '051601' => 'Capital Zamora',
                '051602' => 'Magdaleno',
                '051603' => 'San Francisco de Asís',
                '051604' => 'Valles de Tucutunemo',
                '051605' => 'Augusto Mijares',
            ],
            '0517' => [
                '051701' => 'Capital Francisco Linares Alcántara',
                '051702' => 'Francisco de Miranda',
                '051703' => 'Monseñor Feliciano González',
            ],
            '0518' => [
                '051801' => 'Capital Ocumare de La Costa de Oro',
            ],
            '0601' => [
                '060101' => 'Sabaneta',
                '060102' => 'Rodríguez Domínguez',
            ],
            '0602' => [
                '060201' => 'Ticoporo',
                '060202' => 'Andrés Bello',
                '060203' => 'Nicolás Pulido',
            ],
            '0603' => [
                '060301' => 'Arismendi',
                '060302' => 'Guadarrama',
                '060303' => 'La Unión',
                '060304' => 'San Antonio',
            ],
            '0604' => [
                '060401' => 'Barinas',
                '060402' => 'Alfredo Arvelo Larriva',
                '060403' => 'San Silvestre',
                '060404' => 'Santa Inés',
                '060405' => 'Santa Lucía',
                '060406' => 'Torunos',
                '060407' => 'El Carmen',
                '060408' => 'Rómulo Betancourt',
                '060409' => 'Corazón de Jesús',
                '060410' => 'Ramón Ignacio Méndez',
                '060411' => 'Alto Barinas',
                '060412' => 'Manuel Palacio Fajardo',
                '060413' => 'Juan Antonio Rodríguez Domínguez',
                '060414' => 'Dominga Ortiz de Páez',
            ],
            '0605' => [
                '060501' => 'Barinitas',
                '060502' => 'Altamira',
                '060503' => 'Calderas',
            ],
            '0606' => [
                '060601' => 'Barrancas',
                '060602' => 'El Socorro',
                '060603' => 'Masparrito',
            ],
            '0607' => [
                '060701' => 'Santa Bárbara',
                '060702' => 'José Ignacio del Pumar',
                '060703' => 'Pedro Briceño Méndez',
                '060704' => 'Ramón Ignacio Méndez',
            ],
            '0608' => [
                '060801' => 'Obispos',
                '060802' => 'El Real',
                '060803' => 'La Luz',
                '060804' => 'Los Guasimitos',
            ],
            '0609' => [
                '060901' => 'Ciudad Bolivia',
                '060902' => 'Ignacio Briceño',
                '060903' => 'José Félix Ribas',
                '060904' => 'Páez',
            ],
            '0610' => [
                '061001' => 'Libertad',
                '061002' => 'Dolores',
                '061003' => 'Palacios Fajardo',
                '061004' => 'Santa Rosa',
            ],
            '0611' => [
                '061101' => 'Ciudad de Nutrias',
                '061102' => 'El Regalo',
                '061103' => 'Puerto de Nutrias',
                '061104' => 'Santa Catalina',
            ],
            '0612' => [
                '061201' => 'El Cantón',
                '061202' => 'Santa Cruz de Guacas',
                '061203' => 'Puerto Vivas',
            ],
            '0701' => [
                '070101' => 'Cachamay',
                '070102' => 'Chirica',
                '070103' => 'Dalla Costa',
                '070104' => 'Once de Abril',
                '070105' => 'Simón Bolívar',
                '070106' => 'Unare',
                '070107' => 'Universidad',
                '070108' => 'Vista al Sol',
                '070109' => 'Pozo Verde',
                '070110' => 'Yocoima',
            ],
            '0702' => [
                '070201' => 'Sección Capital Cedeño',
                '070202' => 'Altagracia',
                '070203' => 'Ascensión Farreras',
                '070204' => 'Guaniamo',
                '070205' => 'La Urbana',
                '070206' => 'Pijiguaos',
            ],
            '0703' => [
                '070301' => 'Capital El Callao',
            ],
            '0704' => [
                '070401' => 'Sección Capital Gran Sabana',
                '070402' => 'Ikabarú',
            ],
            '0705' => [
                '070501' => 'Agua Salada',
                '070502' => 'Catedral',
                '070503' => 'José Antonio Páez',
                '070504' => 'La Sabanita',
                '070505' => 'Marhuanta',
                '070506' => 'Vista Hermosa',
                '070507' => 'Orinoco',
                '070508' => 'Panapana',
                '070509' => 'Zea',
            ],
            '0706' => [
                '070601' => 'Sección Capital Piar',
                '070602' => 'Andrés Eloy Blanco',
                '070603' => 'Pedro Cova',
            ],
            '0707' => [
                '070701' => 'Sección Capital Raúl Leoni',
                '070702' => 'Barceloneta',
                '070703' => 'San Francisco',
                '070704' => 'Santa Bárbara',
            ],
            '0708' => [
                '070801' => 'Sección Capital Roscio',
                '070802' => 'Salom',
            ],
            '0709' => [
                '070901' => 'Sección Capital Sifontes',
                '070902' => 'Dalla Costa',
                '070903' => 'San Isidro',
            ],
            '0710' => [
                '071001' => 'Sección Capital Sucre',
                '071002' => 'Aripao',
                '071003' => 'Guarataro',
                '071004' => 'Las Majadas',
                '071005' => 'Moitaco',
            ],
            '0711' => [
                '071101' => 'Capital Padre Pedro Chien',
            ],
            '0801' => [
                '080101' => 'Bejuma',
                '080102' => 'Canoabo',
                '080103' => 'Simón Bolívar',
            ],
            '0802' => [
                '080201' => 'Güigüe',
                '080202' => 'Belén',
                '080203' => 'Tacarigua',
            ],
            '0803' => [
                '080301' => 'Aguas Calientes',
                '080302' => 'Mariara',
            ],
            '0804' => [
                '080401' => 'Ciudad Alianza',
                '080402' => 'Guacara',
                '080403' => 'Yagua',
            ],
            '0805' => [
                '080501' => 'Morón',
                '080502' => 'Urama',
            ],
            '0806' => [
                '080601' => 'Tocuyito',
                '080602' => 'Independencia',
            ],
            '0807' => [
                '080701' => 'Los Guayos',
            ],
            '0808' => [
                '080801' => 'Miranda',
            ],
            '0809' => [
                '080901' => 'Montalbán',
            ],
            '0810' => [
                '081001' => 'Naguanagua',
            ],
            '0811' => [
                '081101' => 'Bartolomé Salom',
                '081102' => 'Democracia',
                '081103' => 'Fraternidad',
                '081104' => 'Goaigoaza',
                '081105' => 'Juan José Flores',
                '081106' => 'Unión',
                '081107' => 'Borburata',
                '081108' => 'Patanemo',
            ],
            '0812' => [
                '081201' => 'San Diego',
            ],
            '0813' => [
                '081301' => 'San Joaquín',
            ],
            '0814' => [
                '081401' => 'Candelaria',
                '081402' => 'Catedral',
                '081403' => 'El Socorro',
                '081404' => 'Miguel Peña',
                '081405' => 'Rafael Urdaneta',
                '081406' => 'San Blas',
                '081407' => 'San José',
                '081408' => 'Santa Rosa',
                '081409' => 'Negro Primero',
            ],
            '0901' => [
                '090101' => 'Cojedes',
                '090102' => 'Juan de Mata Suárez',
            ],
            '0902' => [
                '090201' => 'Tinaquillo',
            ],
            '0903' => [
                '090301' => 'El Baúl',
                '090302' => 'Sucre',
            ],
            '0904' => [
                '090401' => 'Macapo',
                '090402' => 'La Aguadita',
            ],
            '0905' => [
                '090501' => 'El Pao',
            ],
            '0906' => [
                '090601' => 'Libertad de Cojedes',
                '090602' => 'El Amparo',
            ],
            '0907' => [
                '090701' => 'Rómulo Gallegos',
            ],
            '0908' => [
                '090801' => 'San Carlos de Austria',
                '090802' => 'Juan Angel Bravo',
                '090803' => 'Manuel Manrique',
            ],
            '0909' => [
                '090901' => 'General en Jefe José Laurencio Silva',
            ],
            '1001' => [
                '100101' => 'Curiapo',
                '100102' => 'Almirante Luis Brión',
                '100103' => 'Francisco Aniceto Lugo',
                '100104' => 'Manuel Renaud',
                '100105' => 'Padre Barral',
                '100106' => 'Santos de Abelgas',
            ],
            '1002' => [
                '100201' => 'Imataca',
                '100202' => 'Cinco de Julio',
                '100203' => 'Juan Bautista Arismendi',
                '100204' => 'Manuel Piar',
                '100205' => 'Rómulo Gallegos',
            ],
            '1003' => [
                '100301' => 'Pedernales',
                '100302' => 'Luis Beltrán Prieto Figueroa',
            ],
            '1004' => [
                '100401' => 'San José',
                '100402' => 'José Vidal Marcano',
                '100403' => 'Juan Millán',
                '100404' => 'Leonardo Ruíz Pineda',
                '100405' => 'Mariscal Antonio José de Sucre',
                '100406' => 'Monseñor Argimiro García',
                '100407' => 'San Rafael',
                '100408' => 'Virgen del Valle',
            ],
            '1101' => [
                '110101' => 'San Juan de los Cayos',
                '110102' => 'Capadare',
                '110103' => 'La Pastora',
                '110104' => 'Libertador',
            ],
            '1102' => [
                '110201' => 'San Luis',
                '110202' => 'Aracua',
                '110203' => 'La Peña',
            ],
            '1103' => [
                '110301' => 'Capatárida',
                '110302' => 'Bariro',
                '110303' => 'Borojó',
                '110304' => 'Guajiro',
                '110305' => 'Seque',
                '110306' => 'Zazárida',
            ],
            '1104' => [
                '110401' => 'Capital Cacique Manaure',
            ],
            '1105' => [
                '110501' => 'Carirubana',
                '110502' => 'Norte',
                '110503' => 'Punta Cardón',
                '110504' => 'Santa Ana',
            ],
            '1106' => [
                '110601' => 'La Vela de Coro',
                '110602' => 'Acurigua',
                '110603' => 'Guaibacoa',
                '110604' => 'Las Calderas',
                '110605' => 'Macoruca',
            ],
            '1107' => [
                '110701' => 'Capital Dabajuro',
            ],
            '1108' => [
                '110801' => 'Pedregal',
                '110802' => 'Agua Clara',
                '110803' => 'Avaria',
                '110804' => 'Piedra Grande',
                '110805' => 'Purureche',
            ],
            '1109' => [
                '110901' => 'Pueblo Nuevo',
                '110902' => 'Adícora',
                '110903' => 'Baraived',
                '110904' => 'Buena Vista',
                '110905' => 'Jadacaquiva',
                '110906' => 'Moruy',
                '110907' => 'Adaure',
                '110908' => 'El Hato',
                '110909' => 'El Vínculo',
            ],
            '1110' => [
                '111001' => 'Churuguara',
                '111002' => 'Agua Larga',
                '111003' => 'Paují',
                '111004' => 'Independencia',
                '111005' => 'Mapararí',
            ],
            '1111' => [
                '111101' => 'Jacura',
                '111102' => 'Agua Linda',
                '111103' => 'Araurima',
            ],
            '1112' => [
                '111201' => 'Los Taques',
                '111202' => 'Judibana',
            ],
            '1113' => [
                '111301' => 'Mene de Mauroa',
                '111302' => 'Casigua',
                '111303' => 'San Félix',
            ],
            '1114' => [
                '111401' => 'San Antonio',
                '111402' => 'San Gabriel',
                '111403' => 'Santa Ana',
                '111404' => 'Guzmán Guillermo',
                '111405' => 'Mitare',
                '111406' => 'Río Seco',
                '111407' => 'Sabaneta',
            ],
            '1115' => [
                '111501' => 'Chichiriviche',
                '111502' => 'Boca de Tocuyo',
                '111503' => 'Tocuyo de la Costa',
            ],
            '1116' => [
                '111601' => 'Capital Palmasola',
            ],
            '1117' => [
                '111701' => 'Cabure',
                '111702' => 'Colina',
                '111703' => 'Curimagua',
            ],
            '1118' => [
                '111801' => 'Píritu',
                '111802' => 'San José de la Costa',
            ],
            '1119' => [
                '111901' => 'Capital San Francisco',
            ],
            '1120' => [
                '112001' => 'Tucacas',
                '112002' => 'Boca de Aroa',
            ],
            '1121' => [
                '112101' => 'Sucre',
                '112102' => 'Pecaya',
            ],
            '1122' => [
                '112201' => 'Capital Tocópero',
            ],
            '1123' => [
                '112301' => 'Santa Cruz de Bucaral',
                '112302' => 'El Charal',
                '112303' => 'Las Vegas del Tuy',
            ],
            '1124' => [
                '112401' => 'Urumaco',
                '112402' => 'Bruzual',
            ],
            '1125' => [
                '112501' => 'Puerto Cumarebo',
                '112502' => 'La Ciénaga',
                '112503' => 'La Soledad',
                '112504' => 'Pueblo Cumarebo',
                '112505' => 'Zazárida',
            ],
            '1201' => [
                '120101' => 'Camaguán',
                '120102' => 'Puerto Miranda',
                '120103' => 'Uverito',
            ],
            '1202' => [
                '120201' => 'Chaguaramas',
            ],
            '1203' => [
                '120301' => 'El Socorro',
            ],
            '1204' => [
                '120401' => 'Capital San Gerónimo de Guayabal',
                '120402' => 'Cazorla',
            ],
            '1205' => [
                '120501' => 'Valle de La Pascua',
                '120502' => 'Espino',
            ],
            '1206' => [
                '120601' => 'Las Mercedes',
                '120602' => 'Cabruta',
                '120603' => 'Santa Rita de Manapire',
            ],
            '1207' => [
                '120701' => 'El Sombrero',
                '120702' => 'Sosa',
            ],
            '1208' => [
                '120801' => 'Calabozo',
                '120802' => 'El Calvario',
                '120803' => 'El Rastro',
                '120804' => 'Guardatinajas',
            ],
            '1209' => [
                '120901' => 'Altagracia de Orituco',
                '120902' => 'Lezama',
                '120903' => 'Libertad de Orituco',
                '120904' => 'Paso Real de Macaira',
                '120905' => 'San Francisco de Macaira',
                '120906' => 'San Rafael de Orituco',
                '120907' => 'Soublette',
            ],
            '1210' => [
                '121001' => 'Ortiz',
                '121002' => 'San Francisco de Tiznados',
                '121003' => 'San José de Tiznados',
                '121004' => 'San Lorenzo de Tiznados',
            ],
            '1211' => [
                '121101' => 'Tucupido',
                '121102' => 'San Rafael de Laya',
            ],
            '1212' => [
                '121201' => 'San Juan de Los Morros',
                '121202' => 'Cantagallo',
                '121203' => 'Parapara',
            ],
            '1213' => [
                '121301' => 'San José de Guaribe',
            ],
            '1214' => [
                '121401' => 'Santa María de Ipire',
                '121402' => 'Altamira',
            ],
            '1215' => [
                '121501' => 'Zaraza',
                '121502' => 'San José de Unare',
            ],
            '1301' => [
                '130101' => 'Pío Tamayo',
                '130102' => 'Quebrada Honda de Guache',
                '130103' => 'Yacambú',
            ],
            '1302' => [
                '130201' => 'Fréitez',
                '130202' => 'José María Blanco',
            ],
            '1303' => [
                '130301' => 'Catedral',
                '130302' => 'Concepción',
                '130303' => 'El Cují',
                '130304' => 'Juan de Villegas',
                '130305' => 'Santa Rosa',
                '130306' => 'Tamaca',
                '130307' => 'Unión',
                '130308' => 'Aguedo Felipe Alvarado',
                '130309' => 'Buena Vista',
                '130310' => 'Juárez',
            ],
            '1304' => [
                '130401' => 'Juan Bautista Rodríguez',
                '130402' => 'Cuara',
                '130403' => 'Diego de Lozada',
                '130404' => 'Paraíso de San José',
                '130405' => 'San Miguel',
                '130406' => 'Tintorero',
                '130407' => 'José Bernardo Dorante',
                '130408' => 'Coronel Mariano Peraza',
            ],
            '1305' => [
                '130501' => 'Bolívar',
                '130502' => 'Anzoátegui',
                '130503' => 'Guarico',
                '130504' => 'Hilario Luna y Luna',
                '130505' => 'Humocaro Alto',
                '130506' => 'Humocaro Bajo',
                '130507' => 'La Candelaria',
                '130508' => 'Morán',
            ],
            '1306' => [
                '130601' => 'Cabudare',
                '130602' => 'José Gregorio Bastidas',
                '130603' => 'Agua Viva',
            ],
            '1307' => [
                '130701' => 'Sarare',
                '130702' => 'Buría',
                '130703' => 'Gustavo Vegas León',
            ],
            '1308' => [
                '130801' => 'Trinidad Samuel',
                '130802' => 'Antonio Díaz',
                '130803' => 'Camacaro',
                '130804' => 'Castañeda',
                '130805' => 'Cecilio Zubillaga',
                '130806' => 'Chiquinquirá',
                '130807' => 'El Blanco',
                '130808' => 'Espinoza de los Monteros',
                '130809' => 'Lara',
                '130810' => 'Las Mercedes',
                '130811' => 'Manuel Morillo',
                '130812' => 'Montaña Verde',
                '130813' => 'Montes de Oca',
                '130814' => 'Torres',
                '130815' => 'Heriberto Arroyo',
                '130816' => 'Reyes Vargas',
                '130817' => 'Altagracia',
            ],
            '1309' => [
                '130901' => 'Siquisique',
                '130902' => 'Moroturo',
                '130903' => 'San Miguel',
                '130904' => 'Xaguas',
            ],
            '1401' => [
                '140101' => 'Presidente Betancourt',
                '140102' => 'Presidente Páez',
                '140103' => 'Presidente Rómulo Gallegos',
                '140104' => 'Gabriel Picón González',
                '140105' => 'Héctor Amable Mora',
                '140106' => 'José Nucete Sardi',
                '140107' => 'Pulido Méndez',
            ],
            '1402' => [
                '140201' => 'Capital Andrés Bello',
            ],
            '1403' => [
                '140301' => 'Capital Antonio Pinto Salinas',
                '140302' => 'Mesa Bolívar',
                '140303' => 'Mesa de Las Palmas',
            ],
            '1404' => [
                '140401' => 'Capital Aricagua',
                '140402' => 'San Antonio',
            ],
            '1405' => [
                '140501' => 'Capital Arzobispo Chacón',
                '140502' => 'Capurí',
                '140503' => 'Chacantá',
                '140504' => 'El Molino',
                '140505' => 'Guaimaral',
                '140506' => 'Mucutuy',
                '140507' => 'Mucuchachí',
            ],
            '1406' => [
                '140601' => 'Fernández Peña',
                '140602' => 'Matriz',
                '140603' => 'Montalbán',
                '140604' => 'Acequias',
                '140605' => 'Jají',
                '140606' => 'La Mesa',
                '140607' => 'San José del Sur',
            ],
            '1407' => [
                '140701' => 'Capital Caracciolo Parra Olmedo',
                '140702' => 'Florencio Ramírez',
            ],
            '1408' => [
                '140801' => 'Capital Cardenal Quintero',
                '140802' => 'Las Piedras',
            ],
            '1409' => [
                '140901' => 'Capital Guaraque',
                '140902' => 'Mesa de Quintero',
                '140903' => 'Río Negro',
            ],
            '1410' => [
                '141001' => 'Capital Julio César Salas',
                '141002' => 'Palmira',
            ],
            '1411' => [
                '141101' => 'Capital Justo Briceño',
                '141102' => 'San Cristóbal de Torondoy',
            ],
            '1412' => [
                '141201' => 'Antonio Spinetti Dini',
                '141202' => 'Arias',
                '141203' => 'Caracciolo Parra Pérez',
                '141204' => 'Domingo Peña',
                '141205' => 'El Llano',
                '141206' => 'Gonzalo Picón Febres',
                '141207' => 'Jacinto Plaza',
                '141208' => 'Juan Rodríguez Suárez',
                '141209' => 'Lasso de la Vega',
                '141210' => 'Mariano Picón Salas',
                '141211' => 'Milla',
                '141212' => 'Osuna Rodríguez',
                '141213' => 'Sagrario',
                '141214' => 'El Morro',
                '141215' => 'Los Nevados',
            ],
            '1413' => [
                '141301' => 'Capital Miranda',
                '141302' => 'Andrés Eloy Blanco',
                '141303' => 'La Venta',
                '141304' => 'Piñango',
            ],
            '1414' => [
                '141401' => 'Capital Obispo Ramos de Lora',
                '141402' => 'Eloy Paredes',
                '141403' => 'San Rafael de Alcázar',
            ],
            '1415' => [
                '141501' => 'Capital Padre Noguera',
            ],
            '1416' => [
                '141601' => 'Capital Pueblo Llano',
            ],
            '1417' => [
                '141701' => 'Capital Rangel',
                '141702' => 'Cacute',
                '141703' => 'La Toma',
                '141704' => 'Mucurubá',
                '141705' => 'San Rafael',
            ],
            '1418' => [
                '141801' => 'Capital Rivas Dávila',
                '141802' => 'Gerónimo Maldonado',
            ],
            '1419' => [
                '141901' => 'Capital Santos Marquina',
            ],
            '1420' => [
                '142001' => 'Capital Sucre',
                '142002' => 'Chiguará',
                '142003' => 'Estánquez',
                '142004' => 'La Trampa',
                '142005' => 'Pueblo Nuevo del Sur',
                '142006' => 'San Juan',
            ],
            '1421' => [
                '142101' => 'El Amparo',
                '142102' => 'El Llano',
                '142103' => 'San Francisco',
                '142104' => 'Tovar',
            ],
            '1422' => [
                '142201' => 'Capital Tulio Febres Cordero',
                '142202' => 'Independencia',
                '142203' => 'María de la Concepción Palacios Blanco',
                '142204' => 'Santa Apolonia',
            ],
            '1423' => [
                '142301' => 'Capital Zea',
                '142302' => 'Caño El Tigre',
            ],
            '1501' => [
                '150101' => 'Caucagua',
                '150102' => 'Aragüita',
                '150103' => 'Arévalo González',
                '150104' => 'Capaya',
                '150105' => 'El Café',
                '150106' => 'Marizapa',
                '150107' => 'Panaquire',
                '150108' => 'Ribas',
            ],
            '1502' => [
                '150201' => 'San José de Barlovento',
                '150202' => 'Cumbo',
            ],
            '1503' => [
                '150301' => 'Baruta',
                '150302' => 'El Cafetal',
                '150303' => 'Las Minas de Baruta',
            ],
            '1504' => [
                '150401' => 'Higuerote',
                '150402' => 'Curiepe',
                '150403' => 'Tacarigua',
            ],
            '1505' => [
                '150501' => 'Mamporal',
            ],
            '1506' => [
                '150601' => 'Carrizal',
            ],
            '1507' => [
                '150701' => 'Chacao',
            ],
            '1508' => [
                '150801' => 'Charallave',
                '150802' => 'Las Brisas',
            ],
            '1509' => [
                '150901' => 'El Hatillo',
            ],
            '1510' => [
                '151001' => 'Los Teques',
                '151002' => 'Altagracia de La Montaña',
                '151003' => 'Cecilio Acosta',
                '151004' => 'El Jarillo',
                '151005' => 'Paracotos',
                '151006' => 'San Pedro',
                '151007' => 'Tácata',
            ],
            '1511' => [
                '151101' => 'Santa Teresa del Tuy',
                '151102' => 'El Cartanal',
            ],
            '1512' => [
                '151201' => 'Ocumare del Tuy',
                '151202' => 'La Democracia',
                '151203' => 'Santa Bárbara',
            ],
            '1513' => [
                '151301' => 'San Antonio de Los Altos',
            ],
            '1514' => [
                '151401' => 'Río Chico',
                '151402' => 'El Guapo',
                '151403' => 'Tacarigua de La Laguna',
                '151404' => 'Paparo',
                '151405' => 'San Fernando del Guapo',
            ],
            '1515' => [
                '151501' => 'Santa Lucía',
            ],
            '1516' => [
                '151601' => 'Cúpira',
                '151602' => 'Machurucuto',
            ],
            '1517' => [
                '151701' => 'Guarenas',
            ],
            '1518' => [
                '151801' => 'San Francisco de Yare',
                '151802' => 'San Antonio de Yare',
            ],
            '1519' => [
                '151901' => 'Petare',
                '151902' => 'Caucagüita',
                '151903' => 'Fila de Mariches',
                '151904' => 'La Dolorita',
                '151905' => 'Leoncio Martínez',
            ],
            '1520' => [
                '152001' => 'Cúa',
                '152002' => 'Nueva Cúa',
            ],
            '1521' => [
                '152101' => 'Guatire',
                '152102' => 'Bolívar',
            ],
            '1601' => [
                '160101' => 'Capital Acosta',
                '160102' => 'San Francisco',
            ],
            '1602' => [
                '160201' => 'Capital Aguasay',
            ],
            '1603' => [
                '160301' => 'Capital Bolívar',
            ],
            '1604' => [
                '160401' => 'Capital Caripe',
                '160402' => 'El Guácharo',
                '160403' => 'La Guanota',
                '160404' => 'Sabana de Piedra',
                '160405' => 'San Agustín',
                '160406' => 'Teresén',
            ],
            '1605' => [
                '160501' => 'Capital Cedeño',
                '160502' => 'Areo',
                '160503' => 'San Félix',
                '160504' => 'Viento Fresco',
            ],
            '1606' => [
                '160601' => 'Capital Ezequiel Zamora',
                '160602' => 'El Tejero',
            ],
            '1607' => [
                '160701' => 'Capital Libertador',
                '160702' => 'Chaguaramas',
                '160703' => 'Las Alhuacas',
                '160704' => 'Tabasca',
            ],
            '1608' => [
                '160801' => 'Capital Maturín',
                '160802' => 'Alto de los Godos',
                '160803' => 'Boquerón',
                '160804' => 'Las Cocuizas',
                '160805' => 'San Simón',
                '160806' => 'Santa Cruz',
                '160807' => 'El Corozo',
                '160808' => 'El Furrial',
                '160809' => 'Jusepín',
                '160810' => 'La Pica',
                '160811' => 'San Vicente',
            ],
            '1609' => [
                '160901' => 'Capital Piar',
                '160902' => 'Aparicio',
                '160903' => 'Chaguaramal',
                '160904' => 'El Pinto',
                '160905' => 'Guanaguana',
                '160906' => 'La Toscana',
                '160907' => 'Taguaya',
            ],
            '1610' => [
                '161001' => 'Capital Punceres',
                '161002' => 'Cachipo',
            ],
            '1611' => [
                '161101' => 'Capital Santa Bárbara',
            ],
            '1612' => [
                '161201' => 'Capital Sotillo',
                '161202' => 'Los Barrancos de Fajardo',
            ],
            '1613' => [
                '161301' => 'Capital Uracoa',
            ],
            '1701' => [
                '170101' => 'Capital Antolín del Campo',
            ],
            '1702' => [
                '170201' => 'Capital Arismendi',
            ],
            '1703' => [
                '170301' => 'Capital Díaz',
                '170302' => 'Zabala',
            ],
            '1704' => [
                '170401' => 'Capital García',
                '170402' => 'Francisco Fajardo',
            ],
            '1705' => [
                '170501' => 'Capital Gómez',
                '170502' => 'Bolívar',
                '170503' => 'Guevara',
                '170504' => 'Matasiete',
                '170505' => 'Sucre',
            ],
            '1706' => [
                '170601' => 'Capital Maneiro',
                '170602' => 'Aguirre',
            ],
            '1707' => [
                '170701' => 'Capital Marcano',
                '170702' => 'Adrián',
            ],
            '1708' => [
                '170801' => 'Capital Mariño',
            ],
            '1709' => [
                '170901' => 'Capital Península de Macanao',
                '170902' => 'San Francisco',
            ],
            '1710' => [
                '171001' => 'Capital Tubores',
                '171002' => 'Los Barales',
            ],
            '1711' => [
                '171101' => 'Capital Villalba',
                '171102' => 'Vicente Fuentes',
            ],
            '1801' => [
                '180101' => 'Capital Agua Blanca',
            ],
            '1802' => [
                '180201' => 'Capital Araure',
                '180202' => 'Río Acarigua',
            ],
            '1803' => [
                '180301' => 'Capital Esteller',
                '180302' => 'Uveral',
            ],
            '1804' => [
                '180401' => 'Capital Guanare',
                '180402' => 'Córdoba',
                '180403' => 'San José de la Montaña',
                '180404' => 'San Juan de Guanaguanare',
                '180405' => 'Virgen de la Coromoto',
            ],
            '1805' => [
                '180501' => 'Capital Guanarito',
                '180502' => 'Trinidad de la Capilla',
                '180503' => 'Divina Pastora',
            ],
            '1806' => [
                '180601' => 'Capital Monseñor José Vicente de Unda',
                '180602' => 'Peña Blanca',
            ],
            '1807' => [
                '180701' => 'Capital Ospino',
                '180702' => 'Aparición',
                '180703' => 'La Estación',
            ],
            '1808' => [
                '180801' => 'Capital Páez',
                '180802' => 'Payara',
                '180803' => 'Pimpinela',
                '180804' => 'Ramón Peraza',
            ],
            '1809' => [
                '180901' => 'Capital Papelón',
                '180902' => 'Caño Delgadito',
            ],
            '1810' => [
                '181001' => 'Capital San Genaro de Boconoito',
                '181002' => 'Antolín Tovar',
            ],
            '1811' => [
                '181101' => 'Capital San Rafael de Onoto',
                '181102' => 'Santa Fe',
                '181103' => 'Thermo Morles',
            ],
            '1812' => [
                '181201' => 'Capital Santa Rosalía',
                '181202' => 'Florida',
            ],
            '1813' => [
                '181301' => 'Capital Sucre',
                '181302' => 'Concepción',
                '181303' => 'San Rafael de Palo Alzado',
                '181304' => 'Uvencio Antonio Velásquez',
                '181305' => 'San José de Saguaz',
                '181306' => 'Villa Rosa',
            ],
            '1814' => [
                '181401' => 'Capital Turén',
                '181402' => 'Canelones',
                '181403' => 'Santa Cruz',
                '181404' => 'San Isidro Labrador',
            ],
            '1901' => [
                '190101' => 'Mariño',
                '190102' => 'Rómulo Gallegos',
            ],
            '1902' => [
                '190201' => 'San José de Aerocuar',
                '190202' => 'Tavera Acosta',
            ],
            '1903' => [
                '190301' => 'Río Caribe',
                '190302' => 'Antonio José de Sucre',
                '190303' => 'El Morro de Puerto Santo',
                '190304' => 'Puerto Santo',
                '190305' => 'San Juan de Las Galdonas',
            ],
            '1904' => [
                '190401' => 'El Pilar',
                '190402' => 'El Rincón',
                '190403' => 'General Francisco Antonio Vásquez',
                '190404' => 'Guaraúnos',
                '190405' => 'Tunapuicito',
                '190406' => 'Unión',
            ],
            '1905' => [
                '190501' => 'Bolívar',
                '190502' => 'Macarapana',
                '190503' => 'Santa Catalina',
                '190504' => 'Santa Rosa',
                '190505' => 'Santa Teresa',
            ],
            '1906' => [
                '190601' => 'Capital Bolívar',
            ],
            '1907' => [
                '190701' => 'Yaguaraparo',
                '190702' => 'El Paujil',
                '190703' => 'Libertad',
            ],
            '1908' => [
                '190801' => 'Araya',
                '190802' => 'Chacopata',
                '190803' => 'Manicuare',
            ],
            '1909' => [
                '190901' => 'Tunapuy',
                '190902' => 'Campo Elías',
            ],
            '1910' => [
                '191001' => 'Irapa',
                '191002' => 'Campo Claro',
                '191003' => 'Marabal',
                '191004' => 'San Antonio de Irapa',
                '191005' => 'Soro',
            ],
            '1911' => [
                '191101' => 'Capital Mejía',
            ],
            '1912' => [
                '191201' => 'Cumanacoa',
                '191202' => 'Arenas',
                '191203' => 'Aricagua',
                '191204' => 'Cocollar',
                '191205' => 'San Fernando',
                '191206' => 'San Lorenzo',
            ],
            '1913' => [
                '191301' => 'Cariaco',
                '191302' => 'Catuaro',
                '191303' => 'Rendón',
                '191304' => 'Santa Cruz',
                '191305' => 'Santa María',
            ],
            '1914' => [
                '191401' => 'Altagracia',
                '191402' => 'Ayacucho',
                '191403' => 'Santa Inés',
                '191404' => 'Valentín Valiente',
                '191405' => 'San Juan',
                '191406' => 'Raúl Leoni',
                '191407' => 'Santa Fe',
            ],
            '1915' => [
                '191501' => 'Güiria',
                '191502' => 'Bideau',
                '191503' => 'Cristóbal Colón',
                '191504' => 'Punta de Piedras',
            ],
            '2001' => [
                '200101' => 'Capital Andrés Bello',
            ],
            '2002' => [
                '200201' => 'Capital Antonio Rómulo Costa',
            ],
            '2003' => [
                '200301' => 'Capital Ayacucho',
                '200302' => 'Rivas Berti',
                '200303' => 'San Pedro del Río',
            ],
            '2004' => [
                '200401' => 'Capital Bolívar',
                '200402' => 'Palotal',
                '200403' => 'Juan Vicente Gómez',
                '200404' => 'Isaías Medina Angarita',
            ],
            '2005' => [
                '200501' => 'Capital Cárdenas',
                '200502' => 'Amenodoro Rangel Lamús',
                '200503' => 'La Florida',
            ],
            '2006' => [
                '200601' => 'Capital Córdoba',
            ],
            '2007' => [
                '200701' => 'Capital Fernández Feo',
                '200702' => 'Alberto Adriani',
                '200703' => 'Santo Domingo',
            ],
            '2008' => [
                '200801' => 'Capital Francisco de Miranda',
            ],
            '2009' => [
                '200901' => 'Capital García de Hevia',
                '200902' => 'Boca de Grita',
                '200903' => 'José Antonio Páez',
            ],
            '2010' => [
                '201001' => 'Capital Guásimos',
            ],
            '2011' => [
                '201101' => 'Capital Independencia',
                '201102' => 'Juan Germán Roscio',
                '201103' => 'Román Cárdenas',
            ],
            '2012' => [
                '201201' => 'Capital Jáuregui',
                '201202' => 'Emilio Constantino Guerrero',
                '201203' => 'Monseñor Miguel Antonio Salas',
            ],
            '2013' => [
                '201301' => 'Capital José María Vargas',
            ],
            '2014' => [
                '201401' => 'Capital Junín',
                '201402' => 'La Petrólea',
                '201403' => 'Quinimarí',
                '201404' => 'Bramón',
            ],
            '2015' => [
                '201501' => 'Capital Libertad',
                '201502' => 'Cipriano Castro',
                '201503' => 'Manuel Felipe Rugeles',
            ],
            '2016' => [
                '201601' => 'Capital Libertador',
                '201602' => 'Emeterio Ochoa',
                '201603' => 'Doradas',
                '201604' => 'San Joaquín de Navay',
            ],
            '2017' => [
                '201701' => 'Capital Lobatera',
                '201702' => 'Constitución',
            ],
            '2018' => [
                '201801' => 'Capital Michelena',
            ],
            '2019' => [
                '201901' => 'Capital Panamericano',
                '201902' => 'La Palmita',
            ],
            '2020' => [
                '202001' => 'Capital Pedro María Ureña',
                '202002' => 'Nueva Arcadia',
            ],
            '2021' => [
                '202101' => 'Capital Rafael Urdaneta',
            ],
            '2022' => [
                '202201' => 'Capital Samuel Darío Maldonado',
                '202202' => 'Boconó',
                '202203' => 'Hernández',
            ],
            '2023' => [
                '202301' => 'La Concordia',
                '202302' => 'Pedro María Morantes',
                '202303' => 'San Juan Bautista',
                '202304' => 'San Sebastián',
                '202305' => 'Dr. Francisco Romero Lobo',
            ],
            '2024' => [
                '202401' => 'Capital Seboruco',
            ],
            '2025' => [
                '202501' => 'Capital Simón Rodríguez',
            ],
            '2026' => [
                '202601' => 'Capital Sucre',
                '202602' => 'Eleazar López Contreras',
                '202603' => 'San Pablo',
            ],
            '2027' => [
                '202701' => 'Capital Torbes',
            ],
            '2028' => [
                '202801' => 'Capital Uribante',
                '202802' => 'Cárdenas',
                '202803' => 'Juan Pablo Peñaloza',
                '202804' => 'Potosí',
            ],
            '2029' => [
                '202901' => 'Capital San Judas Tadeo',
            ],
            '2101' => [
                '210101' => 'Santa Isabel',
                '210102' => 'Araguaney',
                '210103' => 'El Jagüito',
                '210104' => 'La Esperanza',
            ],
            '2102' => [
                '210201' => 'Boconó',
                '210202' => 'El Carmen',
                '210203' => 'Mosquey',
                '210204' => 'Ayacucho',
                '210205' => 'Burbusay',
                '210206' => 'General Rivas',
                '210207' => 'Guaramacal',
                '210208' => 'Vega de Guaramacal',
                '210209' => 'Monseñor Jáuregui',
                '210210' => 'Rafael Rangel',
                '210211' => 'San Miguel',
                '210212' => 'San José',
            ],
            '2103' => [
                '210301' => 'Sabana Grande',
                '210302' => 'Cheregüé',
                '210303' => 'Granados',
            ],
            '2104' => [
                '210401' => 'Chejendé',
                '210402' => 'Arnoldo Gabaldón',
                '210403' => 'Bolivia',
                '210404' => 'Carrillo',
                '210405' => 'Cegarra',
                '210406' => 'Manuel Salvador Ulloa',
                '210407' => 'San José',
            ],
            '2105' => [
                '210501' => 'Carache',
                '210502' => 'Cuicas',
                '210503' => 'La Concepción',
                '210504' => 'Panamericana',
                '210505' => 'Santa Cruz',
            ],
            '2106' => [
                '210601' => 'Escuque',
                '210602' => 'La Unión',
                '210603' => 'Sabana Libre',
                '210604' => 'Santa Rita',
            ],
            '2107' => [
                '210701' => 'El Socorro',
                '210702' => 'Antonio José de Sucre',
                '210703' => 'Los Caprichos',
            ],
            '2108' => [
                '210801' => 'Campo Elías',
                '210802' => 'Arnoldo Gabaldón',
            ],
            '2109' => [
                '210901' => 'Santa Apolonia',
                '210902' => 'El Progreso',
                '210903' => 'La Ceiba',
                '210904' => 'Tres de Febrero',
            ],
            '2110' => [
                '211001' => 'El Dividive',
                '211002' => 'Agua Santa',
                '211003' => 'Agua Caliente',
                '211004' => 'El Cenizo',
                '211005' => 'Valerita',
            ],
            '2111' => [
                '211101' => 'Monte Carmelo',
                '211102' => 'Buena Vista',
                '211103' => 'Santa María del Horcón',
            ],
            '2112' => [
                '211201' => 'Motatán',
                '211202' => 'El Baño',
                '211203' => 'Jalisco',
            ],
            '2113' => [
                '211301' => 'Pampán',
                '211302' => 'Flor de Patria',
                '211304' => 'La Paz',
                '211305' => 'Santa Ana',
            ],
            '2114' => [
                '211401' => 'Pampanito',
                '211402' => 'La Concepción',
                '211403' => 'Pampanito II',
            ],
            '2115' => [
                '211501' => 'Betijoque',
                '211502' => 'La Pueblita',
                '211503' => 'Los Cedros',
                '211504' => 'José Gregorio Hernández',
            ],
            '2116' => [
                '211601' => 'Carvajal',
                '211602' => 'Antonio Nicolás Briceño',
                '211603' => 'Campo Alegre',
                '211604' => 'José Leonardo Suárez',
            ],
            '2117' => [
                '211701' => 'Sabana de Mendoza',
                '211702' => 'El Paraíso',
                '211703' => 'Junín',
                '211704' => 'Valmore Rodríguez',
            ],
            '2118' => [
                '211801' => 'Andrés Linares',
                '211802' => 'Chiquinquirá',
                '211803' => 'Cristóbal Mendoza',
                '211804' => 'Cruz Carrillo',
                '211805' => 'Matriz',
                '211806' => 'Monseñor Carrillo',
                '211807' => 'Tres Esquinas',
            ],
            '2119' => [
                '211901' => 'La Quebrada',
                '211902' => 'Cabimbú',
                '211903' => 'Jajó',
                '211904' => 'La Mesa',
                '211905' => 'Santiago',
                '211906' => 'Tuñame',
            ],
            '2120' => [
                '212001' => 'Juan Ignacio Montilla',
                '212002' => 'La Beatriz',
                '212003' => 'Mercedes Díaz',
                '212004' => 'San Luis',
                '212005' => 'La Puerta',
                '212006' => 'Mendoza',
            ],
            '2201' => [
                '220101' => 'Capital Arístides Bastidas',
            ],
            '2202' => [
                '220201' => 'Capital Bolívar',
            ],
            '2203' => [
                '220301' => 'Capital Bruzual',
                '220302' => 'Campo Elías',
            ],
            '2204' => [
                '220401' => 'Capital Cocorote',
            ],
            '2205' => [
                '220501' => 'Capital Independencia',
            ],
            '2206' => [
                '220601' => 'Capital José Antonio Páez',
            ],
            '2207' => [
                '220701' => 'Capital La Trinidad',
            ],
            '2208' => [
                '220801' => 'Capital Manuel Monge',
            ],
            '2209' => [
                '220901' => 'Capital Nirgua',
                '220902' => 'Salom',
                '220903' => 'Temerla',
            ],
            '2210' => [
                '221001' => 'Capital Peña',
                '221002' => 'San Andrés',
            ],
            '2211' => [
                '221101' => 'Capital San Felipe',
                '221102' => 'Albarico',
                '221103' => 'San Javier',
            ],
            '2212' => [
                '221201' => 'Capital Sucre',
            ],
            '2213' => [
                '221301' => 'Capital Urachiche',
            ],
            '2214' => [
                '221401' => 'Capital Veroes',
                '221402' => 'El Guayabo',
            ],
            '2301' => [
                '230101' => 'Isla de Toas',
                '230102' => 'Monagas',
            ],
            '2302' => [
                '230201' => 'San Timoteo',
                '230202' => 'General Urdaneta',
                '230203' => 'Libertador',
                '230204' => 'Manuel Guanipa Matos',
                '230205' => 'Marcelino Briceño',
                '230206' => 'Pueblo Nuevo',
            ],
            '2303' => [
                '230301' => 'Ambrosio',
                '230302' => 'Carmen Herrera',
                '230303' => 'Germán Ríos Linares',
                '230304' => 'La Rosa',
                '230305' => 'Jorge Hernández',
                '230306' => 'Rómulo Betancourt',
                '230307' => 'San Benito',
                '230308' => 'Arístides Calvani',
                '230309' => 'Punta Gorda',
            ],
            '2304' => [
                '230401' => 'Encontrados',
                '230402' => 'Udón Pérez',
            ],
            '2305' => [
                '230501' => 'San Carlos del Zulia',
                '230502' => 'Moralito',
                '230503' => 'Santa Bárbara',
                '230504' => 'Santa Cruz del Zulia',
                '230505' => 'Urribarri',
            ],
            '2306' => [
                '230601' => 'Simón Rodríguez',
                '230602' => 'Carlos Quevedo',
                '230603' => 'Francisco Javier Pulgar',
            ],
            '2307' => [
                '230701' => 'La Concepción',
                '230702' => 'José Ramón Yepes',
                '230703' => 'Mariano Parra León',
                '230704' => 'San José',
            ],
            '2308' => [
                '230801' => 'Jesús María Semprún',
                '230802' => 'Barí',
            ],
            '2309' => [
                '230901' => 'Concepción',
                '230902' => 'Andrés Bello',
                '230903' => 'Chiquinquirá',
                '230904' => 'El Carmelo',
                '230905' => 'Potreritos',
            ],
            '2310' => [
                '231001' => 'Alonso de Ojeda',
                '231002' => 'Libertad',
                '231003' => 'Campo Lara',
                '231004' => 'Eleazar López Contreras',
                '231005' => 'Venezuela',
            ],
            '2311' => [
                '231101' => 'Libertad',
                '231102' => 'Bartolomé de las Casas',
                '231103' => 'Río Negro',
                '231104' => 'San José de Perijá',
            ],
            '2312' => [
                '231201' => 'San Rafael',
                '231202' => 'La Sierrita',
                '231203' => 'Las Parcelas',
                '231204' => 'Luis de Vicente',
                '231205' => 'Monseñor Marcos Sergio Godoy',
                '231206' => 'Ricaurte',
                '231207' => 'Tamare',
            ],
            '2313' => [
                '231301' => 'Antonio Borjas Romero',
                '231302' => 'Bolívar',
                '231303' => 'Cacique Mara',
                '231304' => 'Caracciolo Parra Pérez',
                '231305' => 'Cecilio Acosta',
                '231306' => 'Cristo de Aranza',
                '231307' => 'Coquivacoa',
                '231308' => 'Chiquinquirá',
                '231309' => 'Francisco Eugenio Bustamante',
                '231310' => 'Idelfonso Vásquez',
                '231311' => 'Juana de Avila',
                '231312' => 'Luis Hurtado Higuera',
                '231313' => 'Manuel Dagnino',
                '231314' => 'Olegario Villalobos',
                '231315' => 'Raúl Leoni',
                '231316' => 'Santa Lucía',
                '231317' => 'Venancio Pulgar',
                '231318' => 'San Isidro',
            ],
            '2314' => [
                '231401' => 'Altagracia',
                '231402' => 'Ana María Campos',
                '231403' => 'Faría',
                '231404' => 'San Antonio',
                '231405' => 'San José',
            ],
            '2315' => [
                '231501' => 'Sinamaica',
                '231502' => 'Alta Guajira',
                '231503' => 'Elías Sánchez Rubio',
                '231504' => 'Guajira',
            ],
            '2316' => [
                '231601' => 'El Rosario',
                '231602' => 'Donaldo García',
                '231603' => 'Sixto Zambrano',
            ],
            '2317' => [
                '231701' => 'San Francisco',
                '231702' => 'El Bajo',
                '231703' => 'Domitila Flores',
                '231704' => 'Francisco Ochoa',
                '231705' => 'Los Cortijos',
                '231706' => 'Marcial Hernández',
            ],
            '2318' => [
                '231801' => 'Santa Rita',
                '231802' => 'El Mene',
                '231803' => 'José Cenovio Urribarri',
                '231804' => 'Pedro Lucas Urribarri',
            ],
            '2319' => [
                '231901' => 'Manuel Manrique',
                '231902' => 'Rafael María Baralt',
                '231903' => 'Rafael Urdaneta',
            ],
            '2320' => [
                '232001' => 'Bobures',
                '232002' => 'El Batey',
                '232003' => 'Gibraltar',
                '232004' => 'Heras',
                '232005' => 'Monseñor Arturo Celestino Alvarez',
                '232006' => 'Rómulo Gallegos',
            ],
            '2321' => [
                '232101' => 'La Victoria',
                '232102' => 'Rafael Urdaneta',
                '232103' => 'Raúl Cuenca',
            ],
            '2401' => [
                '240101' => 'Caraballeda',
                '240102' => 'Carayaca',
                '240103' => 'Caruao',
                '240104' => 'Catia La Mar',
                '240105' => 'El Junko',
                '240106' => 'La Guaira',
                '240107' => 'Macuto',
                '240108' => 'Maiquetía',
                '240109' => 'Naiguatá',
                '240110' => 'Raúl Leoni',
                '240111' => 'Carlos Soublette',
            ],
            '8801' => [
                '880101' => 'Gran Roque',
                '880102' => 'Madrisqui (Madrisque - Cayo Rata)',
                '880103' => 'Francisqui del Norte',
                '880104' => 'Francisqui del Sur ó Cayo Refugio',
                '880105' => 'Cayo Pirata',
                '880106' => 'Crasqui',
                '880107' => 'Rasqui',
                '880108' => 'Aguistín ó Prestonqui',
                '880109' => 'Cayo Loco ó Porqui',
                '880110' => 'Botoqui',
                '880111' => 'Samqui',
                '880112' => 'Burqui',
                '880113' => 'Cayo Carenero',
                '880114' => 'Cayo Fernando',
                '880115' => 'Mosquises Norte',
                '880116' => 'Mosquises Sur (F.C.L.R.)',
                '880117' => 'Pelona de Dos Mosquises',
                '880118' => 'Vespen ó Cayo Sal',
                '880119' => 'Boca de Cote',
                '880120' => 'Bajo de Botuto',
            ],
            '8802' => [
                '880201' => 'Testigos Grandes',
                '880202' => 'Iguana',
            ],
            '8803' => [
                '880301' => 'La Borracha',
                '880302' => 'Chimana Grande',
                '880303' => 'Chimana del Oeste',
                '880304' => 'Chimana del Sur',
                '880305' => 'Burro',
                '880306' => 'Varadero',
                '880307' => 'Monos',
                '880308' => 'Picuda Grande',
            ],
            '8804' => [
                '880401' => 'La Blanquilla',
            ],
            '8805' => [
                '880500' => 'Grupo 5',
                '880501' => 'Morro de la Pecha (Puerto Real)',
            ],
            '8806' => [
                '880601' => 'Isla de Patos',
            ],
            '8807' => [
                '880701' => 'Píritu Adentro',
            ]
        ];

        foreach ($municipalities_parishes as $code_municipality => $parishes) {
        	$mun = Municipality::where('code', $code_municipality)->first();
        	foreach ($parishes as $code => $parish) {
        		if ($parish && isset($mun->id)) {
        			Parish::updateOrCreate(
		        		['code' => $code],
		        		['name' => $parish, 'municipality_id' => $mun->id]
			        );
        		}
        	}
        }

        $adminRole = Role::where('slug', 'admin')->first();

        /**
         * Permisos disponibles para la gestión de parroquías
         */

        $permissions = [
            [
                'name' => 'Crear Parroquías', 'slug' => 'parish.create',
                'description' => 'Acceso al registro de parroquías', 
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parroquia.crear', 'short_description' => 'agregar parroquia'
            ],
            [
                'name' => 'Editar Parroquías', 'slug' => 'parish.edit',
                'description' => 'Acceso para editar parroquías', 
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parroquia.editar', 'short_description' => 'editar parroquia'
            ],
            [
                'name' => 'Eliminar Parroquías', 'slug' => 'parish.delete',
                'description' => 'Acceso para eliminar parroquías', 
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parroquia.eliminar', 'short_description' => 'eliminar parroquia'
            ],
            [
                'name' => 'Ver Parroquías', 'slug' => 'parish.list',
                'description' => 'Acceso para ver parroquías', 
                'model' => Parish::class, 'model_prefix' => '0general',
                'slug_alt' => 'parroquia.ver', 'short_description' => 'ver parroquías'
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
