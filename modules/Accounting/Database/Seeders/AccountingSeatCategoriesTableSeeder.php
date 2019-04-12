<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Models\AccountingSeatCategory;

class AccountingSeatCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $categories = [
            [
                'name' => 'Solicitud de pago',
                'acronym' => 'SOP.',
            ],
            [
                'name' => 'Emisión de cheques',
                'acronym' => 'CHQ.',
            ],
            [
                'name' => 'Movimientos bancarios',
                'acronym' => 'DEP.',
            ]
        ];

        DB::transaction(function() use ($categories) {
            foreach ($categories as $category) {
                DB::table('accounting_seat_categories')->insert([
                    "name" => $category["name"],
                    "acronym" => $category["acronym"],
                ]);
            }
        });
    }
}