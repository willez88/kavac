<?php

use Illuminate\Database\Seeder;

use App\Models\DocumentStatus;

class DocumentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $doc_status = [
        	[
        		'name' => 'Aprobado(a)',
        		'description' => 'Aprobado(a) en todas las instancias',
        		'color' => '#18CE0F'
        	],
        	[
        		'name' => 'Rechazado(a)',
        		'description' => 'Rechazado(a) en cualquiera de las instancias',
        		'color' => '#FFB236'
        	],
        	[
        		'name' => 'En Proceso',
        		'description' => 'Contiene algunas firmas pero no todas las requeridas para su ' .
        						 'aprobación',
        		'color' => '#2CA8FF'
        	],
        	[
        		'name' => 'Elaborado(a)',
        		'description' => 'Faltan todas las firmas',
        		'color' => '#888'
        	],
        	[
        		'name' => 'Anulado(a)',
        		'description' => 'Anulado(a) antes de su aprobación',
        		'color' => '#FF3636'
        	]
        ];

        foreach ($doc_status as $doc) {
        	DocumentStatus::updateOrCreate(
        		['name' => $doc['name']],
        		['description' => $doc['description'], 'color' => $doc['color']]
        	);
        }
    }
}
